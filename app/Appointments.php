<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $fillable = [
        'identification',
        'appointment_number',
        'was_scheduled',
        'appointment_types_id',
        'turn_number',
        'turn_serial',
        'turn',
        'service_id'
      ];
}
