<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\SalaryRange;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SalaryRangeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:salary-range-list|salary-range-create|salary-range-edit', ['only' => ['index','store']]);
        $this->middleware('permission:salary-range-create', ['only' => ['create','store']]);
        $this->middleware('permission:salary-range-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:salary-range-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $salaryRanges =SalaryRange::all();
        return view('backend.admin.salary_ranges.index',compact('salaryRanges'));
    }

    public function create()
    {
        return view('backend.admin.salary_ranges.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'start'=>'required',
            'end'=>'required',
        ]);
        $salaryRange = new SalaryRange();
        $salaryRange->start = $request->start;
        $salaryRange->end = $request->end;
        $salaryRange->save();
        Toastr::success('Salary Range created successfully');
        return redirect()->route('admin.salary-range.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $salaryRange = SalaryRange::find($id);
        return view('backend.admin.salary_ranges.edit',compact('salaryRange'));
    }

    public function update(Request $request, $id)
    {
        $salaryRange = SalaryRange::find($id);
        $salaryRange->start = $request->start;
        $salaryRange->end = $request->end;
        $salaryRange->save();
        Toastr::success('Salary Range updated successfully');
        return redirect()->route('admin.salary-range.index');
    }

    public function destroy($id)
    {
        $salaryRange = SalaryRange::find($id);
        $salaryRange->delete();

        Toastr::success('Salary Range deleted successfully');
        return back();
    }
}
