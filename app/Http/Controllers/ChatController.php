<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Get all conversations for psychologist (método corregido)
     */
    public function getConversations()
    {
        try {
            $user = Auth::user();
            
            if ($user->role !== 'psicologo') {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            $conversations = Conversation::with(['user', 'latestMessage'])
                ->where('psychologist_id', $user->id)
                ->orderBy('last_message_at', 'desc')
                ->get()
                ->map(function ($conversation) use ($user) {
                    $lastMessage = $conversation->latestMessage;
                    
                    return [
                        'id' => $conversation->id,
                        'patient_name' => $conversation->user->name,
                        'patient_email' => $conversation->user->email,
                        'last_message_preview' => $lastMessage ? 
                            (strlen($lastMessage->message) > 50 ? 
                                substr($lastMessage->message, 0, 50) . '...' : 
                                $lastMessage->message) : 
                            'Nueva conversación',
                        'last_message_time' => $conversation->last_message_at,
                        'unread_count' => $conversation->unreadMessagesCount($user->id),
                        'status' => $conversation->status
                    ];
                });

            return response()->json([
                'success' => true,
                'conversations' => $conversations
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener conversaciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark conversation as read
     */
    public function markAsRead($conversationId)
    {
        try {
            $user = Auth::user();
            
            $conversation = Conversation::where('id', $conversationId)
                ->where(function($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('psychologist_id', $user->id);
                })
                ->firstOrFail();
            
            $conversation->markAsRead($user->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Conversación marcada como leída'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar como leída'
            ], 500);
        }
    }

    /**
     * Check for new messages in a conversation
     */
    public function checkNewMessages($conversationId)
    {
        try {
            $user = Auth::user();
            
            $conversation = Conversation::where('id', $conversationId)
                ->where(function($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('psychologist_id', $user->id);
                })
                ->first();
            
            if (!$conversation) {
                return response()->json(['hasNewMessages' => false]);
            }
            
            $unreadCount = $conversation->unreadMessagesCount($user->id);
            
            return response()->json([
                'hasNewMessages' => $unreadCount > 0,
                'unreadCount' => $unreadCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['hasNewMessages' => false]);
        }
    }

    public function clearConversation($conversationId)
    {
        try {
            // Verificar que la conversación pertenece al usuario autenticado
            $conversation = Conversation::where('id', $conversationId)
                ->where(function($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere('psychologist_id', auth()->id());
                })
                ->firstOrFail();
            
            // Eliminar todos los mensajes de la conversación
            Message::where('conversation_id', $conversationId)->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Conversación eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la conversación'
            ], 500);
        }
    }

    /**
     * Send a message in a conversation.
     */
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
                'conversation_id' => 'nullable|exists:conversations,id'
            ]);

            $user = Auth::user();
            $conversationId = $request->conversation_id;

            // Si no hay conversación, crear una nueva
            if (!$conversationId) {
                $conversation = $this->getOrCreateConversation($user);
                $conversationId = $conversation->id;
            } else {
                $conversation = Conversation::findOrFail($conversationId);
                
                // Verificar que el usuario tenga acceso a esta conversación
                if (!$this->userHasAccessToConversation($user, $conversation)) {
                    return response()->json(['error' => 'No tienes acceso a esta conversación'], 403);
                }
            }

            // Crear el mensaje
            $message = Message::create([
                'conversation_id' => $conversationId,
                'user_id' => $user->id,
                'message' => $request->message,
                'is_read' => false
            ]);

            // Actualizar el timestamp de la conversación
            $conversation->update([
                'last_message_at' => now()
            ]);

            // Obtener todos los mensajes de la conversación
            $messages = $this->getConversationMessages($conversationId);

            return response()->json([
                'success' => true,
                'conversation_id' => $conversationId,
                'messages' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al enviar el mensaje: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get messages for a conversation.
     */
    public function getMessages(Request $request)
    {
        try {
            $conversationId = $request->conversation_id;
            
            if (!$conversationId) {
                return response()->json(['messages' => []]);
            }

            $conversation = Conversation::findOrFail($conversationId);
            $user = Auth::user();

            // Verificar acceso
            if (!$this->userHasAccessToConversation($user, $conversation)) {
                return response()->json(['error' => 'No tienes acceso a esta conversación'], 403);
            }

            // Marcar mensajes como leídos
            $conversation->markAsRead($user->id);

            $messages = $this->getConversationMessages($conversationId);

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener mensajes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's conversation.
     */
    public function getUserConversation()
    {
        try {
            $user = Auth::user();
            $conversation = null;

            if ($user->role === 'paciente') {
                // Para pacientes, buscar su conversación con el psicólogo admin
                $psychologist = User::where('email', 'admin.p@gmail.com')->first();
                
                if ($psychologist) {
                    $conversation = Conversation::where('user_id', $user->id)
                        ->where('psychologist_id', $psychologist->id)
                        ->first();
                }
            } else if ($user->role === 'psicologo') {
                // Para psicólogos, obtener la conversación más reciente
                $conversation = Conversation::where('psychologist_id', $user->id)
                    ->orderBy('last_message_at', 'desc')
                    ->first();
            }

            return response()->json([
                'conversation' => $conversation,
                'has_unread' => $conversation ? $conversation->unreadMessagesCount($user->id) > 0 : false
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener conversación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get or create a conversation for a patient.
     */
    private function getOrCreateConversation($user)
    {
        if ($user->role === 'paciente') {
            // Buscar el psicólogo admin
            $psychologist = User::where('email', 'admin.p@gmail.com')->first();
            
            if (!$psychologist) {
                throw new \Exception('Psicólogo no encontrado');
            }

            // Buscar conversación existente o crear una nueva
            return Conversation::firstOrCreate([
                'user_id' => $user->id,
                'psychologist_id' => $psychologist->id
            ], [
                'status' => 'active',
                'last_message_at' => now()
            ]);
        }

        throw new \Exception('Solo los pacientes pueden iniciar nuevas conversaciones');
    }

    /**
     * Check if user has access to a conversation.
     */
    private function userHasAccessToConversation($user, $conversation)
    {
        return $conversation->user_id === $user->id || 
               $conversation->psychologist_id === $user->id;
    }

    /**
     * Get formatted messages for a conversation.
     */
    private function getConversationMessages($conversationId)
    {
        return Message::with('user')
            ->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'user_id' => $message->user_id,
                    'user_name' => $message->user->name,
                    'created_at' => $message->created_at->format('H:i'),
                    'is_read' => $message->is_read
                ];
            });
    }
}