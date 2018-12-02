<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointments;
use App\Services;

class ServicesController extends Controller
{
    public function showAssingnedTurns(Services $service)
    {
        $appointments =  Appointments::where("service_id", $service->id)->get();
        return $appointments;
    }
}
