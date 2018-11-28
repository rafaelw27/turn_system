<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppointmentTypes;

class AppointmentTypesController extends Controller
{
    public function index()
    {
        return AppointmentTypes::all();
    }

    public function show(Appointments $appointmentType)
    {
        return $appointmentType;
    }

    public function store(Appointments $request)
    {
        $appointmentType = AppointmentTypes::create($request->all());

        return response()->json($appointmentType, 201);
    }

    public function update(Request $request, Appointments $appointmentType)
    {
        $appointmentType->update($request->all());

        return response()->json($appointmentType, 200);
    }

    public function delete(Appointments $appointmentType)
    {
        $appointmentType->delete();

        return response()->json(null, 204);
    }
}
