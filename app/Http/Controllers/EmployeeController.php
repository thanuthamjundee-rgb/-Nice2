<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
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

        return view('employees.index', compact('data'));
    }
}
