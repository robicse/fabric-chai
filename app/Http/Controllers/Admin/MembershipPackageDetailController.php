<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\MembershipPackage;
use App\Model\MembershipPackageDetail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MembershipPackageDetailController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:membership-package-details-list|membership-package-details-create|membership-package-details-edit', ['only' => ['index','store']]);
        $this->middleware('permission:membership-package-details-create', ['only' => ['create','store']]);
        $this->middleware('permission:membership-package-details-edit', ['only' => ['edit','update']]);

    }
    public function index()
    {
        $membership_package_details = MembershipPackageDetail::all();
        return view('backend.admin.membership_package_details.index', compact('membership_package_details'));
    }

    public function create()
    {
        $membership_packages = MembershipPackage::all();
        return view('backend.admin.membership_package_details.create', compact('membership_packages'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'membership_package_id'=> 'required',
        ]);

        $membership_package_detail = new MembershipPackageDetail();
        $membership_package_detail->membership_package_id = $request->membership_package_id;
        $membership_package_detail->buy = $request->buy;
        $membership_package_detail->sell = $request->sell;
        $membership_package_detail->commission = $request->commission;
        $membership_package_detail->job = $request->job;
        $membership_package_detail->free_sms = $request->free_sms;
        $membership_package_detail->work_order = $request->work_order;
        $membership_package_detail->save();
        Toastr::success('Membership Package Detail Created Successfully');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $membership_packages = MembershipPackage::all();
        $membership_package_detail = MembershipPackageDetail::find($id);
        return view('backend.admin.membership_package_details.edit',compact('membership_packages','membership_package_detail'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'membership_package_id'=> 'required',
        ]);

        $membership_package_detail = MembershipPackageDetail::find($id);
        $membership_package_detail->membership_package_id = $request->membership_package_id;
        $membership_package_detail->buy = $request->buy;
        $membership_package_detail->sell = $request->sell;
        $membership_package_detail->commission = $request->commission;
        $membership_package_detail->job = $request->job;
        $membership_package_detail->free_sms = $request->free_sms;
        $membership_package_detail->work_order = $request->work_order;
        $membership_package_detail->save();
        Toastr::success('Membership Package Detail Updated Successfully');
        return back();
    }

    public function destroy($id)
    {
        MembershipPackageDetail::find($id)->delete();
        Toastr::success('Membership Package Detail Deleted Successfully');
        return back();
    }
}
