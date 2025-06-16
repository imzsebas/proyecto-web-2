<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'occupation',
        'age',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'age' => 'integer',
    ];

    /**
     * Get the conversations where this user is the client.
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * Get the conversations where this user is the psychologist.
     */
    public function psychologistConversations()
    {
        return $this->hasMany(Conversation::class, 'psychologist_id');
    }

    /**
     * Get all messages sent by this user.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get all conversations (as client or psychologist).
     */
    public function allConversations()
    {
        $clientConversations = $this->conversations()->getQuery();
        $psychologistConversations = $this->psychologistConversations()->getQuery();

        return $clientConversations->union($psychologistConversations)->get();
    }

        /**
     * Check if the user is a psychologist.
     */
    public function isPsychologist()
    {
        return $this->role === 'psicologo';
    }

    /**
     * Check if the user is a patient.
     */
    public function isPatient()
    {
        return $this->role === 'paciente';
    }

    /**
     * Check if the user is a regular user.
     */
    public function isUser()
    {
        return $this->role === 'paciente';
    }

    // Agregar estos métodos al final de tu clase User, antes de la llave de cierre

/**
 * Check if the user is an admin.
 */
public function isAdmin()
{
    return $this->role === 'admin';
}

/**
 * Check if the user has admin privileges.
 */
public function hasAdminAccess()
{
    return $this->role === 'admin';
}

/**
 * Get role display name.
 */
public function getRoleDisplayName()
{
    switch ($this->role) {
        case 'admin':
            return 'Administrador';
        case 'psicologo':
            return 'Psicólogo';
        case 'paciente':
            return 'Paciente';
        default:
            return 'Usuario';
    }
}
public function notes()
{
    return $this->hasMany(PatientNote::class, 'patient_id');
}

public function reports()
{
    return $this->hasMany(PatientReport::class, 'patient_id');
}

public function createdNotes()
{
    return $this->hasMany(PatientNote::class, 'created_by');
}

public function createdReports()
{
    return $this->hasMany(PatientReport::class, 'created_by');
}



}