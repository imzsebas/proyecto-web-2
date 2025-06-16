<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'medical_history'
    ];

    public function patientReports()
    {
        return $this->hasMany(PatientReport::class);
    }
}