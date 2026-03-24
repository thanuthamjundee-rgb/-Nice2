<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class VisitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = User::select(
                'users.*',
                'position.position_name',
                'department.dep_name',
                'user_level.level_name'
            )
            ->leftJoin('position', 'users.p_id', '=', 'position.id')
            ->leftJoin('department', 'users.dep_id', '=', 'department.id')
            ->leftJoin('user_level', 'users.level_id', '=', 'user_level.id')
            ->where('users.id', Auth::id())
            ->firstOrFail();

        return view('visitor.index', compact('data'));
    }

    // ✅ หน้าแจ้งซ่อม
    public function form_repair()
    {
        return view('visitor.form_repair');
    }

    // ✅ หน้ารายการแจ้งซ่อม
   public function repair()
{
    $userId = Auth::id();

    $data = DB::table('repair')
    ->leftJoin('equipment', 'repair.eq_id', '=', 'equipment.id')
    ->leftJoin('users', 'repair.u_id', '=', 'users.id') // 👈 แก้ตรงนี้
    ->leftJoin('building', 'repair.build_id', '=', 'building.id')
    ->leftJoin('status', 'repair.s_id', '=', 'status.id') // 👈 จากรูปคือ s_id
    ->select(
        'repair.*',
        'equipment.eq_name',
        'users.firstname',
        'users.lastname',
        'building.build_name',
        'status.s_status'
    )
    ->paginate(10); 


    return view('visitor.repair', compact('data'));
}

}
