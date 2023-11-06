<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;

class AppointmentTimeController extends Controller
{
    function index()
    {
        $aTimes = AppointmentTime::active()->get();
        return view('admin.appointment-time.index', compact('aTimes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'starttime'=>'required',
            'endtime'=>'required',
        ]);

        $aTime = new AppointmentTime();
        $aTime->name = $request->name;
        $aTime->slug = Str::slug($request->name).uniqid();
        $aTime->start_time = $request->starttime;
        $aTime->end_time = $request->endtime;
        $aTime->last_updated_by = Auth::id();
        $aTime->user_id = Auth::id();
        $aTime->save();

        Toastr::success('Appointment time created successful', 'Successful');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required',
            'starttime'=>'required',
            'endtime'=>'required',
        ]);

        $aTime = AppointmentTime::findOrFail($id);
        $aTime->name = $request->name;
        $aTime->slug = Str::slug($request->name).uniqid();
        $aTime->start_time = $request->starttime;
        $aTime->end_time = $request->endtime;
        $aTime->last_updated_by = Auth::id();
        $aTime->save();

        Toastr::success('Appointment time created updated', 'Successful');
        return redirect()->back();
    }
}
