<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Equipment::query();

        if ($request->search) {
            $query->where('eq_name', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('id', 'DESC')->paginate(10);

        return view('admins.equipment', compact('data'));
    }

    public function add(Request $request)
    {
        $check = Equipment::where('eq_name', $request->name)->first();

        if ($check) {
            return response()->json([
                'mgs' => 'ข้อมูลซ้ำ กรุณากรอกข้อมูลใหม่',
                'icon' => 'error'
            ]);
        }

        Equipment::create([
            'eq_name' => $request->name
        ]);

        return response()->json([
            'mgs' => 'บันทึกข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }

    public function edit(Request $request)
    {
        Equipment::where('id', $request->id)->update([
            'eq_name' => $request->name
        ]);

        return response()->json([
            'mgs' => 'แก้ไขข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }

    public function del(Request $request)
    {
        Equipment::where('id', $request->id)->delete();

        return response()->json([
            'mgs' => 'ลบข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }
}
