<?php
// app/Models/PatientNote.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'created_by',
        'content'
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