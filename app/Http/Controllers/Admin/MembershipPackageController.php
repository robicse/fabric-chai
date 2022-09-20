<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\MembershipPackage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MembershipPackageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:membership-packages-list|membership-packages-create|membership-packages-edit', ['only' => ['index','store']]);
        $this->middleware('permission:membership-packages-create', ['only' => ['create','store']]);
        $this->middleware('permission:membership-packages-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $membership_packages = MembershipPackage::all();
        return view('backend.admin.membership_packages.index', compact('membership_packages'));
    }

    public function create()
    {
        return view('backend.admin.membership_packages.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'package_name'=> 'required|unique:membership_packages,package_name',
        ]);

        $membership_package = new MembershipPackage;
        $membership_package->package_name = $request->package_name;
        $membership_package->package_name_bn = $request->package_name_bn;
        $membership_package->price = $request->price;
        $membership_package->status = 1;
        $membership_package->save();
        Toastr::success('Membership Package Created Successfully');
        return back();


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $membership_package = MembershipPackage::find($id);
        return view('backend.admin.membership_packages.edit',compact('membership_package'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'package_name'=> 'required|unique:membership_packages,package_name,'.$id,
        ]);

        $membership_package = MembershipPackage::find($id);
        $membership_package->package_name = $request->package_name;
        $membership_package->package_name_bn = $request->package_name_bn;
        $membership_package->price = $request->price;
        $membership_package->status = 1;
        $membership_package->save();

        Toastr::success('Membership Package Created Successfully');
        return back();
    }

    public function destroy($id)
    {
        $membership_package = MembershipPackage::find($id);
        $membership_package->delete();
        Toastr::success('Membership Package deleted successfully','Success');
        return back();
    }
}
