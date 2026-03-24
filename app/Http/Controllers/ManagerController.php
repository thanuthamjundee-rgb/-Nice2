<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use App\Models\Equipment;
use App\Models\Level;
use App\Models\Repair;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

public function index(Request $request)
{
    $userId = Auth::user()->id;

    $data = User::select(
            'users.*',
            'position.position_name',
            'department.dep_name',
            'user_level.level_name'
        )
        ->leftJoin('position', 'users.p_id', '=', 'position.id')
        ->leftJoin('department', 'users.dep_id', '=', 'department.id')
        ->leftJoin('user_level', 'users.level_id', '=', 'user_level.id')
        ->where('users.id', $userId)
        ->first();

    $repairStatusCounts = Status::leftJoin('repair', 'repair.s_id', '=', 'status.id')
        ->selectRaw('status.s_status, COUNT(repair.id) as total')
        ->groupBy('status.s_status')
        ->get();

    return view('managers.index', compact('data', 'repairStatusCounts'));
}
    public function edit($id)
    {
        $repair = Repair::findOrFail($id);
        $equipment = Equipment::all();    
        $buildings = Building::all();     
        $user = User::findOrFail($repair->u_id); 
        $fullName = $user->firstname . ' ' . $user->lastname;
    
        return view('managers.repair_edit', compact('repair', 'equipment', 'buildings', 'fullName'));
    }
    public function update(Request $request, $id)
    {
        $repair = Repair::findOrFail($id);
        $repair->update([
            'eq_id' => $request->eq_id,
            'r_name' => $request->r_name,
            'r_serialnumber' => $request->r_serialnumber,
            'r_detail' => $request->r_detail,
            'build_id' => $request->build_id,
            'floor' => $request->floor,
            'room' => $request->room,
        ]);
        return redirect(url('managers/repair'))->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
    public function del(Request $request)
    {
        $repair = Repair::findOrFail($request->id);
        $repair->delete();

        return response()->json([
            'mgs' => 'ข้อมูลถูกลบเรียบร้อยแล้ว',
            'icon' => 'success'
        ]);
    }

     public function dashboard()
    {
        // ดึงข้อมูลประเภทอุปกรณ์
        $equipmentData = Equipment::selectRaw('eq_name, COUNT(r.id) as total')
            ->leftJoin('repair as r', 'equipment.id', '=', 'r.eq_id')  // ใช้ LEFT JOIN กับตาราง repair โดยเชื่อมกับ eq_id
            ->groupBy('eq_name')
            ->get();
        
       // ดึงข้อมูลสถานะการซ่อม รวมสถานะที่ไม่มีการแจ้งซ่อมด้วย
        $statusData = Status::leftJoin('repair', 'repair.s_id', '=', 'status.id')
            ->selectRaw('status.s_status, COUNT(repair.id) as total')
            ->groupBy('status.s_status')
            ->get();


        // ดึงข้อมูลแผนก
        $departmentData = User::join('department', 'users.dep_id', '=', 'department.id')
            ->selectRaw('department.dep_name, COUNT(*) as total')
            ->groupBy('department.dep_name')
            ->get();
    
        return view('managers.dashboard', compact('equipmentData', 'statusData', 'departmentData'));
    }

}
