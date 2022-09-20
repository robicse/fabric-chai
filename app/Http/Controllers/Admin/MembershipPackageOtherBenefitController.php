<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\MembershipPackage;
use App\Model\MembershipPackageOtherBenefit;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MembershipPackageOtherBenefitController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:membership-package-other-benefit-list|membership-package-other-benefit-create|membership-package-other-benefit-edit', ['only' => ['index','store']]);
        $this->middleware('permission:membership-package-other-benefit-create', ['only' => ['create','store']]);
        $this->middleware('permission:membership-package-other-benefit-edit', ['only' => ['edit','update']]);

    }
    public function index()
    {
        $membership_packages_other_benefits = MembershipPackageOtherBenefit::latest()->get();
        return view('backend.admin.membership_packages_other_benefit.index', compact('membership_packages_other_benefits'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $membership_packages = MembershipPackage::all();
        $membership_packages_other_benefit = MembershipPackageOtherBenefit::find($id);
        return view('backend.admin.membership_packages_other_benefit.edit',compact('membership_packages','membership_packages_other_benefit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'membership_package_id'=> 'required',
        ]);

        $membership_packages_other_benefit = MembershipPackageOtherBenefit::find($id);
        $membership_packages_other_benefit->membership_package_id = $request->membership_package_id;
//        $membership_packages_other_benefit->buy = $request->buy;
//        $membership_packages_other_benefit->sell = $request->sell;
//        $membership_packages_other_benefit->commission = $request->commission;
//        $membership_packages_other_benefit->job = $request->job;
//        $membership_package_detail->free_sms = $request->free_sms;
//        $membership_package_detail->work_order = $request->work_order;
        $membership_packages_other_benefit->market_strategic = $request->market_strategic;
        $membership_packages_other_benefit->rd_facilities = $request->rd_facilities;
        $membership_packages_other_benefit->costing_facilities = $request->costing_facilities;
        $membership_packages_other_benefit->promotion_facilities = $request->promotion_facilities;
        $membership_packages_other_benefit->bank_loan_facilities = $request->bank_loan_facilities;
        $membership_packages_other_benefit->customer_acquisition_facilities = $request->customer_acquisition_facilities;
        $membership_packages_other_benefit->discount_offers = $request->discount_offers;
        $membership_packages_other_benefit->training_facility = $request->training_facility;
        $membership_packages_other_benefit->ad_discounts = $request->ad_discounts;
        $membership_packages_other_benefit->credit_facilities = $request->credit_facilities;
        $membership_packages_other_benefit->loyalty_program = $request->loyalty_program;
        $membership_packages_other_benefit->yarn_price_update = $request->yarn_price_update;
        $membership_packages_other_benefit->save();
        Toastr::success('Membership Package Other Benefits Updated Successfully');
        return redirect()->route('admin.membership-package-other-benefit.index');
    }

    public function destroy($id)
    {
        //
    }
}
