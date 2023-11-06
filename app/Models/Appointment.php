<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id','id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function apointmentTimes()
    {
        return $this->belongsTo(AppointmentTime::class, 'appointment_time_id', 'id');
    }

    // Getting the person who closed it
    public function lastUpdatedBys()
    {
        return $this->belongsTo(User::class, 'last_updated_by', 'id');
    }
}
