<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $data = User::select('users.*','position.position_name','department.dep_name','user_level.level_name')
            ->join('position', 'users.p_id', '=','position.id')
            ->join('department', 'users.dep_id', '=','department.id')
            ->join('user_level', 'users.level_id', '=','user_level.id');

            if (isset($request->search) && $request->search !== '') {
                $data = $data->where(function($query) use ($request) {
                    $query->where('users.firstname', 'like', '%' . $request->search . '%')
                          ->orWhere('users.lastname', 'like', '%' . $request->search . '%')
                          ->orWhere('users.email', 'like', '%' . $request->search . '%')
                          ->orWhere('position.position_name', 'like', '%' . $request->search . '%')
                          ->orWhere('department.dep_name', 'like', '%' . $request->search . '%')
                          ->orWhere('user_level.level_name', 'like', '%' . $request->search . '%');
                });
            }
        $data = $data->orderBy('id', 'DESC')->paginate(10);
        $positions = Position::select('id','position_name')->get();
        $departments = Department::select('id','dep_name')->get();
        $userLevels = Level::select('id','level_name')->get();
        // return $data;
        return view('admins/user', compact('data', 'positions', 'departments', 'userLevels'));
    }
    public function add(Request $request)
{
    $check = User::where('email', $request->email)->first();
    if ($check) {
        return response()->json([
            'mgs' => 'อีเมล์ซ้ำ กรุณากรอกใหม่',
            'icon' => 'error'
        ]);
    }

    $fileNameToStore = null;

    if ($request->hasFile('image')) {
        $file = $request->image;
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $filename . '.' . $extension;
        $file->storeAs('public/images/', $fileNameToStore);
    }


    User::create([
        'email'      => $request->email,
        'password'   => Hash::make($request->password),
        'firstname'  => $request->firstname,
        'lastname'   => $request->lastname,
        'mobile'     => $request->mobile,
        'p_id'       => $request->p_id,
        'dep_id'     => $request->dep_id,
        'level_id'   => $request->level_id,
        'image'      => $fileNameToStore,
    ]);

    return response()->json([
        'mgs' => 'บันทึกข้อมูลสำเร็จ',
        'icon' => 'success'
    ]);
}

    public function edit(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return response()->json([
                'mgs' => 'ไม่พบข้อมูลผู้ใช้นี้',
                'icon' => 'error'
            ]);
        }

        $fileNameToStore = $user->image;
        if ($request->hasFile('image')) { 
            $file = $request->image;
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $filename . '.' . $extension;
            $file->storeAs('public/images/', $fileNameToStore);
        }

        $user->email = $request->email;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->mobile = $request->mobile;
        $user->p_id = $request->p_id;
        $user->dep_id = $request->dep_id;
        $user->level_id = $request->level_id;
        $user->image = $fileNameToStore;
        $user->updated_at = now();
        $user->save();

        return response()->json([
            'mgs' => 'แก้ไขข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }
    public function del(Request $request)
    {
        User::where('id', $request->id)->delete();
        return response() -> json([
            'mgs' => 'ลบข้อมูลสำเร็จ',
            'icon' => 'success'
        ]);
    }
    public function profile(){
        $user = Auth::user();
       return view('admins/profile', compact('user'));
    }
public function updateProfile(Request $request)
{
    $user = User::find($request->id);

    if (!$user) {
        return redirect()->back()
            ->with('mgs', 'ไม่พบข้อมูลผู้ใช้นี้')
            ->with('icon', 'error');
    }

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $fileNameToStore = $user->image;
    if ($request->hasFile('image')) {
        $file = $request->image;
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $filename . '.' . $extension;
        $file->storeAs('public/images/', $fileNameToStore);
    }

    $user->update([
        'email'     => $request->email,
        'firstname' => $request->firstname,
        'lastname'  => $request->lastname,
        'mobile'    => $request->mobile,
        'image'     => $fileNameToStore,
    ]);

    return redirect()->back()
        ->with('mgs', 'แก้ไขข้อมูลเรียบร้อย')
        ->with('icon', 'success');
}

}