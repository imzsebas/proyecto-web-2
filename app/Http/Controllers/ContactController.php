<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:5000',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo no es válido.',
            'phone.required' => 'El teléfono es obligatorio.',
            'message.required' => 'El mensaje es obligatorio.',
        ]);

        try {
            // Enviar el correo
            Mail::to('sebastianube19@gmail.com') // Cambia por tu email donde quieres recibir los mensajes
                ->send(new ContactFormMail($validated));

            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente. Te responderemos pronto.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Inténtalo de nuevo.'
            ], 500);
        }
    }
}