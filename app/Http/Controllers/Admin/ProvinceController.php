<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::latest()->get();
        return view('admin.province.index', compact('provinces'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
        ]);

        $province = new Province();
        $province->name = $request->name;
        $province->slug = Str::slug($request->name).uniqid();
        $province->user_id = Auth::id();
        $province->last_updated_by = Auth::id();
        $province->save();

        Toastr::success('Province Successfully Created', 'Successful');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required',
        ]);

        $province = Province::find($id);
        $province->name = $request->name;
        $province->slug = Str::slug($request->name).uniqid();
        $province->last_updated_by = Auth::id();
        $province->save();

        Toastr::success('Province Successfully Updated', 'Successful');
        return redirect()->back();
    }
}
