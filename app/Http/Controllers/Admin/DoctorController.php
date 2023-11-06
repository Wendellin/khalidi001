<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\District;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::latest()->get();  // add users array with role id 4.
        return view('admin.doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $depts = Department::all();
        $districts = District::all();
        return view('admin.doctor.create', compact('depts', 'districts'));
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
            'department_id'=>'required',
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
        $user->role_id = 2;
        $user->email_verified_at = now();
        $user->password = Hash::make($request->password);
        $user->save();

        $doctor = new Doctor();
        $doctor->user_id = $user->id;
        $doctor->slug = Str::slug($user->name).uniqid();
        $doctor->dob = $request->dob;
        $doctor->street_address = $request->address;
        $doctor->gender = $request->gender;
        $doctor->district_id = $request->district_id;
        $doctor->created_by = Auth::id();
        $doctor->department_id = $request->department_id;
        $doctor->last_updated_by = Auth::id();
        $doctor->phone_no = $request->phone_number;
        $doctor->alt_phone_no = $request->alt_phone_number;
        $doctor->save();

        Toastr::success($user->name . ' Successfully registred', 'successful');
        return redirect()->route('admin.doctors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('admin.doctor.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $depts = Department::all();
        $districts = District::all();
        return view('admin.doctor.edit', compact('doctor','depts', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $this->validate($request, [
            'f_name'=>'required',
            'address'=>'required',
            'email'=>'required|email',
            'department_id'=>'required',
            'dob'=>'required|before:'.date('Y-m-d'),
            'gender'=>'required',
            'district_id'=>'required',
            'phone_number'=>'required',
            'alt_phone_number'=>'required',
        ]);

        $user_id = $doctor->user_id;

        $user = User::where('id', $user_id)->first();
        $user->name = $request->f_name;
        $user->email = $request->email;
        $user->save();


        $doctor->user_id = $user->id;
        $doctor->slug = Str::slug($user->name).uniqid();
        $doctor->dob = $request->dob;
        $doctor->street_address = $request->address;
        $doctor->gender = $request->gender;
        $doctor->district_id = $request->district_id;
        $doctor->last_updated_by = Auth::id();
        $doctor->department_id = $request->department_id;
        $doctor->phone_no = $request->phone_number;
        $doctor->alt_phone_no = $request->alt_phone_number;
        $doctor->save();

        Toastr::success('Doctor Successfully updated', 'Successful');
        return redirect()->route('admin.doctors.index'); //redirect to show instead
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
