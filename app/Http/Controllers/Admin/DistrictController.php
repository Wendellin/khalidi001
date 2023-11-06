<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::latest()->get();
        $provinces = Province::all();
        return view('admin.district.index', compact('districts', 'provinces'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'province_id'=>'required'
        ]);

        $district = new District();
        $district->name = $request->name;
        $district->province_id = $request->province_id;
        $district->slug = Str::slug($request->name).uniqid();
        $district->user_id = Auth::id();
        $district->last_updated_by = Auth::id();
        $district->save();

        Toastr::success('District Successfully Created', 'Successful');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required',
            'province_id'=>'required'
        ]);

        $district = District::find($id);
        $district->name = $request->name;
        $district->province_id = $request->province_id;
        $district->slug = Str::slug($request->name).uniqid();
        $district->last_updated_by = Auth::id();
        $district->save();

        Toastr::success('Province Successfully Updated', 'Successful');
        return redirect()->back();
    }
}
