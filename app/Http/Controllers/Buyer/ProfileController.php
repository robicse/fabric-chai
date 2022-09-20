<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Model\ProductBid;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function viewProfile(){
        return view('frontend.buyer.view_profile');
    }
    public function editProfile(){
        return view('frontend.buyer.edit_profile');
    }

    public function updateProfile(Request $request) {


        $user = User::find(Auth::id());

        $bid_check = ProductBid::where('sender_user_id',Auth::id())->orWhere('receiver_user_id',Auth::id())->first();
        if (!empty($bid_check)){
            if($request->hasFile('avatar_original')){
                $user->avatar_original = $request->avatar_original->store('uploads/profile');
                $user->update();
                Toastr::success('Profile Picture Updated successfully.');
            }
            Toastr::error('You can not change your profile because you have placed bid. ');
            return redirect()->back();
        }
        $user->name = $request->name;
        $user->name_bn = $request->name_bn;
        $user->email = $request->email;
        if($request->hasFile('avatar_original')){
            $user->avatar_original = $request->avatar_original->store('uploads/profile');
        }
        $user->save();
        Toastr::success('Profile Updated Successfully');
        return redirect()->route('buyer.view-profile');
    }
    public function editPassword(){
        return view('frontend.buyer.edit_password');
    }
    public function updatePassword(Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ]);
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                if ($request->confirm_password == $request->password) {
                    $user = \App\User::find(Auth::id());
                    $user->password = Hash::make($request->password);
                    $user->save();
                    Toastr::success('Password Updated Successfully','Success');
                    Auth::logout();
                    return redirect()->route('login');
                }else{
                    Toastr::error('New password does not match with confirm password.', 'Error');
                    return redirect()->back();
                }
//                $user = \App\User::find(Auth::id());
//                $user->password = Hash::make($request->password);
//                $user->save();
//                Toastr::success('Password Updated Successfully','Success');
//                Auth::logout();
//                return redirect()->route('login');
            } else {
                Toastr::error('New password cannot be the same as old password.', 'Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match.', 'Error');
            return redirect()->back();
        }
    }
}
