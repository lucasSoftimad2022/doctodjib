<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Appointment;

class AppointmentController extends Controller
{
    public function appoitmentClientDoctor(Request $request)
    {

      
        $appointment = Appointment::create([
            'date' => $request->date,
            'time' => $request->time,
            'motif' => $request->motif,
            'patient_record' => $request->patient_record,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'appointment' => $appointment,
            'message' => 'votre rendez vous est enrgistré avec success',
        ],200);
        
    }   
}
