<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = ['medical_record', 'name', 'phone', 'email', 'dob', 'address', 'notes'];

    protected $casts = [
        'dob' => 'date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
