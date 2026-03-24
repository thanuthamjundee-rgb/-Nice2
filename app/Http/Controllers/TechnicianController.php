<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Repair;
use App\Models\Status;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $data = User::select('users.*', 'position.position_name', 'department.dep_name', 'user_level.level_name')
                    ->leftJoin('position', 'users.p_id', '=', 'position.id') 
                    ->leftJoin('department', 'users.dep_id', '=', 'department.id')
                    ->leftJoin('user_level', 'users.level_id', '=', 'user_level.id') 
                    ->where('users.id', $userId)
                    ->first();

        // ดึงจำนวนงานแจ้งซ่อมของช่างที่ล็อกอิน พร้อมชื่อสถานะ
        $repairStatusCounts = Repair::select('status.s_status', Repair::raw('count(*) as total'))
        ->join('status', 'repair.s_id', '=', 'status.id') 
        ->where('technician_id', $userId)
        ->groupBy('status.s_status')
        ->get();

         return view('technicians.index', compact('data', 'repairStatusCounts'));
    }


    public function technician_repair(Request $request)
    {
        $technicianId = auth()->user()->id; // ดึง ID ของช่างที่ล็อกอินอยู่

        $query = Repair::select(
            'repair.*', 
            'users.firstname', 
            'users.lastname', 
            'equipment.eq_name',  
            'building.build_name', 
            'status.s_status'
        )
        ->join('users', 'repair.u_id', '=', 'users.id')
        ->join('equipment', 'repair.eq_id', '=', 'equipment.id')
        ->join('building', 'repair.build_id', '=', 'building.id')
        ->join('status', 'repair.s_id', '=', 'status.id')
        ->where('repair.technician_id', $technicianId) // เพิ่มเงื่อนไขให้กรองเฉพาะงานซ่อมที่มอบหมายให้ช่างคนนี้
        ->orderBy('repair.id', 'DESC'); 

        // ตรวจสอบว่ามีการค้นหาหรือไม่
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.firstname', 'like', '%' . $search . '%')
                ->orWhere('users.lastname', 'like', '%' . $search . '%')
                ->orWhere('equipment.eq_name', 'like', '%' . $search . '%')
                ->orWhere('repair.r_name', 'like', '%' . $search . '%')
                ->orWhere('repair.r_serialnumber', 'like', '%' . $search . '%');
            });
        }

        $data = $query->paginate(10);
        $statuses = Status::all(); 
        return view('technicians/repair', compact('data',  'statuses'));
    }


    public function updateStatus(Request $request)
    {
        // ตรวจสอบค่าที่ส่งมา
        $validated = $request->validate([
            'item_id' => 'required|integer', // ไอดีของการซ่อม
            'status' => 'required|integer', // ไอดีของสถานะ
        ]);
    
        // ค้นหา Repair ที่ตรงกับ item_id
        $repair = Repair::find($validated['item_id']);
    
        // ถ้าพบข้อมูลการซ่อม ให้ทำการอัปเดตสถานะ
        if ($repair) {
            $repair->s_id = $validated['status']; 
            $repair->save(); // บันทึกการเปลี่ยนแปลง
    
            return redirect()->back()->with('success', 'ปรับสถานะเรียบร้อยแล้ว');
        }
    
        // หากไม่พบข้อมูล
        return redirect()->back()->with('error', 'ไม่พบข้อมูลการซ่อม');
    }
    
    

}