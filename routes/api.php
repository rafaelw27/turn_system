<?php

use Illuminate\Http\Request;
use  App\Article;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('appointments', 'AppointmentsController@index');
Route::get('appointments/{appointment}', 'AppointmentsController@show');
Route::post('appointments', 'AppointmentsController@store');
Route::put('appointments/{appointment}', 'AppointmentsController@update');
Route::delete('appointments/{appointment}', 'AppointmentsController@delete');

//Dispatch and assign appointments to services endpoints
Route::get('appointments/{appointment}/services/{service}/assign', 'AppointmentsController@assignTurn');
Route::get('appointments/{appointment}/services/dispatch', 'AppointmentsController@dispatchTurn');

Route::get('appointment-types', 'AppointmentTypesController@index');
Route::get('appointment-types/{appointmentType}', 'AppointmentTypesController@show');
Route::post('appointment-types', 'AppointmentTypesController@store');
Route::put('appointment-types/{appointmentType}', 'AppointmentTypesController@update');
Route::delete('appointment-types/{appointmentType}', 'AppointmentTypesController@delete');

Route::get('services/{service}', 'ServicesController@showAssingnedTurns');
