<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentTypes extends Model
{
    protected $fillable = [
        'identification',
        'appointment_serial',
        'was_scheduled',
        'appointment_types_id'
      ];
}
