<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentTime;
use App\Models\Department;
use App\Models\Patient;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AssistantAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::orderBy('status', 'desc')->latest()->get(); // order based on dates; todays appointsments first
        return view('assistant.appointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $patients = Patient::latest()->get();
        $depts = Department::latest()->get();
        $aTimes = AppointmentTime::latest()->get();

        return view('assistant.appointment.create-page', compact('patients', 'depts', 'aTimes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'session'=>'required',
            'department'=>'required',
            'date'=>'required|after:'.date('Y-m-d'),
        ]);

        $appointment = new Appointment();
        $appointment->slug = Str::slug($request->session).Str::slug($request->patient_id).'-'.uniqid();
        $appointment->department_id = $request->department;
        $appointment->patient_id = $request->patient_id;
        $appointment->appointment_time_id = $request->session;
        $appointment->date = $request->date;
        $appointment->user_id = Auth::id();
        $appointment->last_updated_by = Auth::id();
        $appointment->save();

        Toastr::success('Appointment successfully saved', 'Successful');
        return redirect()->back(); // if need be change it to route to appointment index
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Appointment::find($id);
        $patients = Patient::latest()->get();
        $depts = Department::latest()->get();
        $aTimes = AppointmentTime::latest()->get();

        return view('assistant.appointment.edit', compact('appointment','patients', 'depts', 'aTimes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'session'=>'required',
            'department'=>'required',
            'date'=>'required|after:'.date('Y-m-d'),
        ]);

        $appointment = Appointment::find($id);
        $appointment->slug = Str::slug($request->session).Str::slug($request->patient_id).'-'.uniqid();
        $appointment->department_id = $request->department;
        $appointment->patient_id = $request->patient_id;
        $appointment->appointment_time_id = $request->session;
        $appointment->date = $request->date;
        $appointment->last_updated_by = Auth::id();
        $appointment->save();

        Toastr::success('Appointment successfully updated', 'Successful');
        return redirect()->back(); // if need be change it to route to appointment index
    }

    /**
     * Close an Appointment
     */
    public function close(Request $request, $id)
    {
        $this->validate($request, [
            'confirm'=>'required'
        ]);

        if($request->confirm  == 'confirm' || $request->confirm == 'Confirm')
        {
            $appointment = Appointment::find($id);
            $appointment->status = FALSE;
            $appointment->last_updated_by = Auth::id();
            $appointment->save();

            Toastr::success('Appointment Successfully closed', 'successful');
            return redirect()->back();
        }
        else
        {
            Toastr::error('Sorry, an error occurred', 'Error');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
