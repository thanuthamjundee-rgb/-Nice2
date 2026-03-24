<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = Department::query();

        if ($request->search) {
            $data->where('dep_name', 'like', '%' . $request->search . '%');
        }

        $data = $data->orderBy('id', 'DESC')->paginate(10);

        return view('admins.department', compact('data'));
    }

    public function add(Request $request)
    {
        $check = Department::where('dep_name', $request->name)->first();

        if ($check) {
            return response()->json([
                'mgs' => 'ข้อมูลซ้ำ กรุณากรอกข้อมูลใหม่',
                'icon' => 'error'
            ]);
        }

        Department::create([
            'dep_name' => $request->name
        ]);

        return response()->json([
            'mgs' => 'บันทึกข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }

    public function edit(Request $request)
    {
        Department::where('id', $request->id)->update([
            'dep_name' => $request->name
        ]);

        return response()->json([
            'mgs' => 'แก้ไขข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }

    public function del(Request $request)
    {
        Department::where('id', $request->id)->delete();

        return response()->json([
            'mgs' => 'ลบข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }
}
