<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Building::query();

        if ($request->search) {
            $query->where('build_name', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('id', 'DESC')->paginate(10);

        return view('admins.building', compact('data'));
    }

    public function add(Request $request)
    {
        $check = Building::where('build_name', $request->name)->first();

        if ($check) {
            return response()->json([
                'mgs' => 'ข้อมูลซ้ำ กรุณากรอกข้อมูลใหม่',
                'icon' => 'error'
            ]);
        }

        Building::create([
            'build_name' => $request->name
        ]);

        return response()->json([
            'mgs' => 'บันทึกข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }

    public function edit(Request $request)
    {
        Building::where('id', $request->id)->update([
            'build_name' => $request->name
        ]);

        return response()->json([
            'mgs' => 'แก้ไขข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }

    public function del(Request $request)
    {
        Building::where('id', $request->id)->delete();

        return response()->json([
            'mgs' => 'ลบข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }
}
