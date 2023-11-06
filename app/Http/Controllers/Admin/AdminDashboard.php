<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public function index()
    {
        $admins = User::where('role_id', 1)->get();
        $doctors = User::where('role_id', 2)->get();
        $assistants = User::where('role_id', 3)->get();
        $patients = User::where('role_id', 4)->get();
        // $appointments = Appointment
        return view('admin.dashboard', compact('admins','doctors', 'assistants', 'patients'));
    }
}
