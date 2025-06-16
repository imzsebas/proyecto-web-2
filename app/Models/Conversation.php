<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'psychologist_id',
        'status',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the patient (user) that owns the conversation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the psychologist that owns the conversation.
     */
    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }

    /**
     * Get all messages for the conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message for the conversation.
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Get unread messages count for a specific user.
     */
    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Mark all messages as read for a specific user.
     */
    public function markAsRead($userId)
    {
        $this->messages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}