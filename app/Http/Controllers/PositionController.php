<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Position::query();

        if ($request->search) {
            $query->where('position_name', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('id', 'DESC')->paginate(10);

        return view('admins.position', compact('data'));
    }

    public function add(Request $request)
    {
        $check = Position::where('position_name', $request->name)->first();

        if ($check) {
            return response()->json([
                'mgs' => 'ข้อมูลซ้ำ กรุณากรอกข้อมูลใหม่',
                'icon' => 'error'
            ]);
        }

        Position::create([
            'position_name' => $request->name
        ]);

        return response()->json([
            'mgs' => 'บันทึกข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }

    public function edit(Request $request)
    {
        Position::where('id', $request->id)->update([
            'position_name' => $request->name
        ]);

        return response()->json([
            'mgs' => 'แก้ไขข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }

    public function del(Request $request)
    {
        Position::where('id', $request->id)->delete();

        return response()->json([
            'mgs' => 'ลบข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }
}
