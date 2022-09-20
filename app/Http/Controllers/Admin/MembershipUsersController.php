<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipUsersController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:membership-users-list|', ['only' => ['index']]);
    }
    public function index(){
        $users = User::where('id','!=',Auth::id())->where('user_type','!=','staff')->latest()->get();
        return view('backend.admin.membership_users.index',compact('users'));

    }
}
