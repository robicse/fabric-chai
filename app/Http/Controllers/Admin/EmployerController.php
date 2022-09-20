<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Employer;
use App\Model\MembershipPackage;
use App\Model\Seller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:employer-list|employer-create|employer-profile-edit', ['only' => ['index','store']]);
        $this->middleware('permission:employer-create', ['only' => ['create','store']]);
        $this->middleware('permission:employer-profile-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:employer-password-edit', ['only' => ['editPassword','updatePassword']]);
//        $this->middleware('permission:employer-verification', ['only' => ['verification']]);
    }
    public function index()
    {
        $employers = Employer::latest()->get();
        return view('backend.admin.employer.index',compact('employers'));
    }
    public function employerListAjax(){
        return Employer::ajaxEmployerList();
    }
    public function create()
    {
        return view('backend.admin.employer.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name'=> 'required',
        ]);
        $phn1 = (int)$request->phone;
        $check = User::where('phone',$phn1)->first();
        if (!empty($check)){
            Toastr::error('This phone number already exist');
            return back();
        }
        if($request->countyCodePrefix == +880){
            $phn = (int)$request->phone;
        }else{
            $phn = $request->phone;
        }
        $membership_package_id = MembershipPackage::where('package_name','General')->pluck('id')->first();
        $default_password = '123456';
        $user = new User();
        $user->name = $request->name;
        $user->country_code= $request->countyCodePrefix;
        $user->phone= $phn;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->password = Hash::make($default_password);
        $user->user_type = 'seller';
        $user->multiple_user_types = json_encode(["seller","employer"]);
        $user->membership_package_id = $membership_package_id;
        $user->membership_activation_date = date('Y-m-d');
        $user->membership_expired_date = date('Y-m-d', strtotime('+1 year'));
        $user->banned = 0;

        $insert_id = $user->save();
        if($insert_id){
            $seller = new Seller();
            $seller->user_id = $user->id;
            $seller->company_name = $request->company_name;
            $seller->company_phone = $request->company_phone;
            $seller->company_email = $request->company_email;
            $seller->company_address = $request->company_address;
            $seller->verification_status= 1;
            $seller->division_id= $request->division_id;
            $seller->district_id= $request->district_id;

            if($request->hasFile('trade_licence')){
                $seller->trade_licence = $request->trade_licence->store('uploads/seller_info/trade_licence');
            }

            $seller_insert_id = $seller->save();
            if($seller_insert_id){
                $title = 'Seller Registration';
                $message = $user->name .' Registered as a new seller';
                registrationNotification($user->id,$title,$message);

                $employer = new Employer();
                $employer->user_id = $user->id;
                $employer->seller_id = $seller->id;
                $employer->owner_name = $request->owner_name;
                $employer->industry_category_id = json_encode($request->industry_category_id);
                $employer->no_of_employee = $request->no_of_employee;
                $employer->salary_type = $request->salary_type;
                $employer->established_year = $request->established_year;

                if($request->hasFile('owner_nid_front')){
                    $employer->owner_nid_front = $request->owner_nid_front->store('uploads/employer_info/nid');
                }
                if($request->hasFile('owner_nid_back')){
                    $employer->owner_nid_back = $request->owner_nid_back->store('uploads/employer_info/nid');
                }
                if($request->hasFile('vat')){
                    $employer->vat = $request->vat->store('uploads/employer_info/vat');
                }
                if($request->hasFile('factory_certificate')){
                    $employer->factory_certificate = $request->factory_certificate->store('uploads/employer_info/factory_certificate');
                }
                if($request->hasFile('fire_licence')){
                    $employer->fire_licence = $request->fire_licence->store('uploads/employer_info/fire_licence');
                }
                if($request->hasFile('membership_image')){
                    $employer->membership_image = $request->membership_image->store('uploads/employer_info/membership_image');
                }
                $employer->save();
                Toastr::success('Employer created Successfully');
                return redirect()->route('admin.employer.index');
            }else{
                Toastr::error('Seller Information Something Went Wrong. Please Try Again!');
                User::find($insert_id)->delete();
                return back();
            }
        }else{
            Toastr::error('Something Went Wrong. Please Try Again!');
            User::find($insert_id)->delete();
            return back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {

        $employer = Employer::find(decrypt($id));
        return view('backend.admin.employer.edit',compact('employer'));
    }

    public function update(Request $request, $id)
    {
        $employer = Employer::find($id);
        $user = User::find($employer->user_id);
        $phn1 = (int)$request->phone;

        $check = User::where('id','!=',$user->id)->where('phone',$phn1)->first();
        if (!empty($check)){
            Toastr::error('This phone number already exist');
            return back();
        }
        if($request->countyCodePrefix == +880){
            $phn = (int)$request->phone;
        }else{
            $phn = $request->phone;
        }
        $user->name = $request->name;
        $user->country_code= $request->countyCodePrefix;
        $user->phone= $phn;
        $user->email = $request->email;
        $user->address = $request->address;


        $seller = Seller::find($employer->seller_id);
        $seller->company_name = $request->company_name;
        $seller->company_phone = $request->company_phone;
        $seller->company_address = $request->company_address;
        if($request->hasFile('trade_licence')){
            $seller->trade_licence = $request->trade_licence->store('uploads/seller_info/trade_licence');
        }

        $employer->owner_name = $request->owner_name;
        $employer->industry_category_id = json_encode($request->industry_category_id);
        $employer->no_of_employee = $request->no_of_employee;
        $employer->salary_type = $request->salary_type;
        $employer->established_year = $request->established_year;

        if($request->hasFile('owner_nid_front')){
            $employer->owner_nid_front = $request->owner_nid_front->store('uploads/employer_info/nid');
        }
        if($request->hasFile('owner_nid_back')){
            $employer->owner_nid_back = $request->owner_nid_back->store('uploads/employer_info/nid');
        }
        if($request->hasFile('vat')){
            $employer->vat = $request->vat->store('uploads/employer_info/vat');
        }
        if($request->hasFile('factory_certificate')){
            $employer->factory_certificate = $request->factory_certificate->store('uploads/employer_info/factory_certificate');
        }
        if($request->hasFile('fire_licence')){
            $employer->fire_licence = $request->fire_licence->store('uploads/employer_info/fire_licence');
        }
        if($request->hasFile('membership_image')){
            $employer->membership_image = $request->membership_image->store('uploads/employer_info/membership_image');
        }
        $user->save();
        $seller->save();
        $employer->save();
        Toastr::success('Employer Updated Successfully');
        return redirect()->route('admin.employer.index');
    }

    public function destroy($id)
    {
        //
    }
    public function detailsModal(Request $request){
        $employer = Employer::find($request->id);
        return view('backend.admin.employer.details_modal',compact('employer'));
    }
    public function editPassword($id){
        $employer = Employer::find(decrypt($id));
        $user = User::find($employer->user_id);
        return view('backend.admin.employer.edit_password',compact('user'));
    }

    public function updatePassword(Request $request, $id){

        $this->validate($request, [
            'password' =>  'required|min:8',
        ]);
        $user = User::find($id);
        if ($request->confirm_password == $request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
            Toastr::success('Password Updated Successfully','Success');
            return redirect()->route('admin.employer.index');
        }else{
            Toastr::error('New password does not match with confirm password.', 'Error');
            return redirect()->back();
        }
    }

    public function unApproveEmployerList(){
        return view('backend.admin.employer.unapproved_employer_list');
    }

    public function unApproveEmployerListAjax(){
        return Employer::ajaxUnApproveEmployerList();
    }

}
