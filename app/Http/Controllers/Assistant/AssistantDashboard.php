<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssistantDashboard extends Controller
{
    public function index()
    {
        return view('home');
    }
}
