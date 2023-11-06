<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function  index()
    {
        $depts = Department::latest()->get();
        return view('admin.department.index', compact('depts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|unique:departments,name',
        ]);

        $dept = new Department();
        $dept->name = $request->name;
        $dept->slug = Str::slug($request->name).uniqid();
        $dept->desc = $request->desc;
        $dept->user_id = Auth::id();
        $dept->last_updated_by = Auth::id();
        $dept->save();

        Toastr::success('Department created successfully', 'Successful');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required',
        ]);

        $dept = Department::findOrFail($id);
        $dept->name = $request->name;
        $dept->slug = Str::slug($request->name).uniqid();
        $dept->desc = $request->desc;
        $dept->last_updated_by = Auth::id();
        $dept->save();

        Toastr::success('Department created updated', 'Successful');
        return redirect()->back();
    }
}
