<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointments;
use App\Services;

class AppointmentsController extends Controller
{
    public function index()
    {
        return Appointments::all();
    }

    public function show(Appointments $appointment)
    {
        return $appointment;
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
    
        if ($requestData['appointment_types_id'] == 1) {
            $lastTurnNumberQCL =  Appointments::whereRaw("turn_serial = 'QCL'")->orderBy('id', 'desc')->first();

            //If turn is quicklane we use the serial QCL ollowed by turn number . For turn number we check the last turn added to the database of type QuickLane
            if ($lastTurnNumberQCL) {
                $requestData['turn_number'] = $lastTurnNumberQCL->turn_number + 1;
                $requestData['turn_serial'] = 'QCL';
                $requestData['turn'] = 'QCL-' . $requestData['turn_number'];
            } else {
                $requestData['turn_number'] = 0;
                $requestData['turn_serial'] = 'QCL';
                $requestData['turn'] = 'QCL-' . $requestData['turn_number'];
            }
        } else {
            //If turn is Taller we use the serial TLR followed by turn number. For turn number we check the last turn added to the database of type Taller

            $lastTurnNumberTLR =  Appointments::whereRaw("turn_serial = 'TLR'")->orderBy('id', 'desc')->first();
            //If turn is quicklane we use the serial QCL ollowed by turn number . For turn number we check the last turn added to the database of type QuickLane
            if ($lastTurnNumberTLR) {
                $requestData['turn_number'] = $lastTurnNumberTLR->turn_number + 1;
                $requestData['turn_serial'] = 'TLR';
                $requestData['turn'] = 'TLR-' . $requestData['turn_number'];
            } else {
                $requestData['turn_number'] = 0;
                $requestData['turn_serial'] = 'TLR';
                $requestData['turn'] = 'TLR-' . $requestData['turn_number'];
            }
        }

        $appointment = Appointments::create($requestData);

        return response()->json($appointment, 201);
    }

    public function update(Request $request, Appointments $appointment)
    {
        $appointment->update($request->all());

        return response()->json($appointment, 200);
    }

    public function delete(Appointments $appointment)
    {
        $appointment->delete();

        return response()->json(null, 204);
    }

    public function dispatchTurn(Appointments $appointment)
    {
        $currentAppoinment =  Appointments::where("id", $appointment->id)->first();

        if ($currentAppoinment) {
            //Get the first service that is available
            $availableService =  Services::where("id", $currentAppoinment->service_id)->first();
        
            if ($availableService) {
                $currentAppoinment->service_id = 0;

                if ($currentAppoinment->update()) {
                    $availableService->is_available = 1;

                    if ($availableService->update()) {
                        return 'Success';
                    } else {
                        return 'Failed to update service';
                    }
                } else {
                    return 'Failed to update appointment';
                }
            }
        } else {
            return 'Appointment not found';
        }
    }

    public function assignTurn(Appointments $appointment, Services $service)
    {
        $currentAppoinment =  Appointments::where("id", $appointment->id)->first();

        if ($currentAppoinment) {
            //Get the first service that is available
            $availableService =  Services::where("is_available", 1)->where('id', $service->id)->first();

            if ($availableService) {
                $currentAppoinment->service_id = $availableService->id;

                if ($currentAppoinment->save()) {
                    $availableService->is_available = 0;

                    if ($availableService->save()) {
                        return 'Success';
                    } else {
                        return 'Failed to update service';
                    }
                } else {
                    return 'Failed to update appointment';
                }
            }
        }
    }
}
