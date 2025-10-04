<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id', 'doctor_id', 'appointment_date', 'status', 'notes'];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
