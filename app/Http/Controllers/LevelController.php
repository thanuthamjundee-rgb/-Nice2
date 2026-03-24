<?php

namespace App\Http\Controllers;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = Level::select('*');
        if(isset($request->search)){
            $data = $data->where('level_name', 'like', '%' . $request->search. '%');
        }
        $data = $data->orderBy('id', 'DESC')->paginate(10);
                 
        // return $data;
        return view('admins/level', compact(
            'data'
        ));
    }
    public function add(Request $request)
    {
        $check = Level::where('level_name', $request->name)->first();
        if(isset($check)){
            return response() -> json([
                'level_name' => $request->name,
                'mgs' => 'ข้อมูลซ้ำ กรุณากรอกข้อมูลใหม่',
                'icon' => 'error'
            ]);
        }else{
            Level::insert(['level_name'=>$request->name]);
            return response() -> json([
                'level_name' => $request->name,
                'mgs' => 'บันทึกข้อมูลสำเร็จ',
                'icon' => 'success'
            ]);
        }
    }
    public function edit(Request $request)
    {
        Level::where('id', $request->id)->update(['level_name'=>$request->name]);
        return response() -> json([
            'level_name' => $request->name,
            'mgs' => 'แก้ไขข้อมูลสำเร็จ'
        ]);
    }
    public function del(Request $request)
    {
        Level::where('id', $request->id)->delete();
        return response() -> json([
            'mgs' => 'ลบข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }
}