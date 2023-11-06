<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorAppointmentController extends Controller
{
    public function index()
    {
        $doctor_dept = Doctor::select('department_id')->where('user_id', Auth::id())->get(); //getting doctors department only
        $appointments = Appointment::whereIn('department_id', $doctor_dept)->orderBy('status', 'desc')->get();

        return view('doctor.appointment.index', compact('appointments', 'doctor_dept'));
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
}
