<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Details;
use App\Models\Equipment;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
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

    public function index()
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
