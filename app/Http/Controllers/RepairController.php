<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Repair;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ================= EMPLOYEE =================
    public function index(Request $request)
    {
        $query = $this->repairQuery($request);
        $data = $query->paginate(10);

        return view('employees.repair', compact('data'));
    }

    // ================= MANAGER =================
    public function manager_repair(Request $request)
    {
        $query = $this->repairQuery($request);
        $data = $query->paginate(10);

        return view('managers.repair', compact('data'));
    }

    // ================= FORM ADD =================
    public function form_add()
    {
        $user = Auth::user();
        $fullName = $user->firstname . ' ' . $user->lastname;

        $equipment = Equipment::all();
        $buildings = Building::all();

        return view('employees.form_repair', compact(
            'fullName',
            'equipment',
            'buildings'
        ));
    }

    // ================= STORE =================
   public function add(Request $request)
{
    $user = Auth::user();

    Repair::create([
        'u_id' => $user->id,
        'eq_id' => $request->eq_id,
        'r_name' => $request->r_name,
        'r_serialnumber' => $request->r_serialnumber,
        'r_detail' => $request->r_detail,
        'build_id' => $request->build_id,
        'floor' => $request->floor,
        'room' => $request->room,
        's_id' => 1,
        'head_id' => null,
        'technician_id' => null,
        'r_date' => now()
    ]);

    // เงื่อนไขตำแหน่ง
    if ($user->level_id == 5) {
        return redirect('visitor/repair')
            ->with('success', 'แจ้งซ่อมสำเร็จ!');
    } elseif ($user->level_id == 3) {
        return redirect('employees/repair')
            ->with('success', 'แจ้งซ่อมสำเร็จ!');
    }

    // เผื่อกรณีตำแหน่งอื่น
    return redirect()->back()->with('success', 'แจ้งซ่อมสำเร็จ!');
}

    // ================= QUERY SHARED =================
    private function repairQuery($request)
    {
        $query = Repair::select(
                'repair.*',
                'users.firstname',
                'users.lastname',
                'equipment.eq_name',
                'building.build_name',
                'status.s_status',
                'technician.firstname AS technician_firstname',
                'technician.lastname AS technician_lastname'
            )
            ->join('users', 'repair.u_id', '=', 'users.id')
            ->join('equipment', 'repair.eq_id', '=', 'equipment.id')
            ->join('building', 'repair.build_id', '=', 'building.id')
            ->join('status', 'repair.s_id', '=', 'status.id')
            ->leftJoin('users as technician', 'repair.technician_id', '=', 'technician.id')
            ->when(Auth::user()->level_id != 2, function ($q) {
                $q->where('repair.u_id', Auth::id());
            })
            ->orderBy('repair.id', 'DESC');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.firstname', 'like', "%$search%")
                  ->orWhere('users.lastname', 'like', "%$search%")
                  ->orWhere('equipment.eq_name', 'like', "%$search%")
                  ->orWhere('repair.r_name', 'like', "%$search%")
                  ->orWhere('repair.r_serialnumber', 'like', "%$search%");
            });
        }

        return $query;
    }

    // ================= DETAIL =================
    public function show_detail($id)
    {
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
            ->where('repair.id', $id);

        if (Auth::user()->level_id != 2) {
            $query->where('repair.u_id', Auth::id());
        }

        $data = $query->firstOrFail();

        return view('managers.repair_detail', compact('data'));
    }

    // ================= ASSIGN =================
    public function assign($id)
    {
        $technicians = User::select(
                'users.*',
                'position.position_name',
                'department.dep_name'
            )
            ->join('position', 'users.p_id', '=', 'position.id')
            ->join('department', 'users.dep_id', '=', 'department.id')
            ->join('user_level', 'users.level_id', '=', 'user_level.id')
            ->where('user_level.level_name', 'technician')
            ->get();

        return view('managers.repair_assign', [
            'technicians' => $technicians,
            'repair_id' => $id
        ]);
    }

    public function assignWork(Request $request)
    {
        $repair = Repair::findOrFail($request->repair_id);

        $repair->update([
            'technician_id' => $request->technician_id,
            's_id' => 2,
            'head_id' => Auth::id()
        ]);

        return redirect('managers/repair')
            ->with('success', 'มอบหมายช่างเรียบร้อยแล้ว!');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        if (Auth::user()->level_id != 2) {
            abort(403);
        }

        $repair = Repair::findOrFail($id);
        $equipment = Equipment::all();
        $buildings = Building::all();

        $user = User::find($repair->u_id);
        $fullName = $user->firstname . ' ' . $user->lastname;

        return view('managers.repair_edit', compact(
            'repair',
            'equipment',
            'buildings',
            'fullName'
        ));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        if (Auth::user()->level_id != 2) {
            abort(403);
        }

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

        return redirect('managers/repair')
            ->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    // ================= DELETE =================
public function destroy(Request $request)
{
    if (Auth::user()->level_id != 2) {
        abort(403);
    }

    $repair = Repair::findOrFail($request->id);
    $repair->delete();

    return response()->json([
        'mgs' => 'ลบข้อมูลสำเร็จ',
        'icon' => 'success'
    ]);
}


}
