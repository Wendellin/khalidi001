<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentTime;
use App\Models\Department;
use App\Models\District;
use App\Models\Patient;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::latest()->get();
        $aTimes = AppointmentTime::all();
        $depts = Department::all();
        return view('admin.patient.index', compact('patients', 'aTimes', 'depts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $districts = District::all();
        return view('admin.patient.create', compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'f_name'=>'required',
            'l_name'=>'required',
            'address'=>'required',
            'email'=>'required|email|unique:users,email',
            'dob'=>'required|before:'.date('Y-m-d'),
            'gender'=>'required',
            'district_id'=>'required',
            'phone_number'=>'required',
            'alt_phone_number'=>'required',
            'password'=>'required|confirmed',
        ]);

        $user = new User();
        $user->name = $request->f_name . ' '. $request->l_name;
        $user->email = $request->email;
        $user->role_id = 4;
        $user->email_verified_at = now();
        $user->password = Hash::make($request->password);
        $user->save();

        $patient = new Patient();
        $patient->user_id = $user->id;
        $patient->slug = Str::slug($user->name).uniqid();
        $patient->dob = $request->dob;
        $patient->street_address = $request->address;
        $patient->gender = $request->gender;
        $patient->district_id = $request->district_id;
        $patient->created_by = Auth::id();
        $patient->last_updated_by = Auth::id();
        $patient->phone_no = $request->phone_number;
        $patient->alt_phone_no = $request->alt_phone_number;
        $patient->save();

        Toastr::success('Patient Successfully registred', 'successful');
        return redirect()->route('admin.patients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::find($id);
        return view('admin.patient.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = Patient::find($id);
        $districts = District::all();
        return view('admin.patient.edit', compact('patient', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'f_name'=>'required',
            'address'=>'required',
            'email'=>'required|email',
            'dob'=>'required|before:'.date('Y-m-d'),
            'gender'=>'required',
            'district_id'=>'required',
            'phone_number'=>'required',
            'alt_phone_number'=>'required',
        ]);

        $patient = Patient::find($id);
        $user_id = $patient->user_id;

        $user = User::where('id', $user_id)->first();
        $user->name = $request->f_name;
        $user->email = $request->email;
        $user->save();


        $patient->user_id = $user->id;
        $patient->slug = Str::slug($user->name).uniqid();
        $patient->dob = $request->dob;
        $patient->street_address = $request->address;
        $patient->gender = $request->gender;
        $patient->district_id = $request->district_id;
        $patient->last_updated_by = Auth::id();
        $patient->phone_no = $request->phone_number;
        $patient->alt_phone_no = $request->alt_phone_number;
        $patient->save();

        Toastr::success('Patient Successfully updated', 'Successful');
        return redirect()->route('admin.patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
