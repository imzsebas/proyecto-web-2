<?php

// app/Models/PatientReport.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'created_by',
        'title',
        'content',
        'type'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}