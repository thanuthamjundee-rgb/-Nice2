<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    use AuthenticatesUsers;

    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }


    protected function redirectTo()
{
    $user = Auth::user();
    $levelID = $user->level_id;

    switch ($levelID) {

        case 1:
            return '/index';

        case 2:
            return '/managers/index';

        case 3:
            return '/employees/index';

        case 4:
            return '/technicians/index';

        case 5:
            return '/visitor/index';

        default:
            return '/login';
    }
}



}
