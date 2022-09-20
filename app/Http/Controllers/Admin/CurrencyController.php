<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Currency;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CurrencyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:currencies-list|currencies-create|currencies-edit', ['only' => ['index','store']]);
        $this->middleware('permission:currencies-create', ['only' => ['create','store']]);
        $this->middleware('permission:currencies-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
        $currencies = Currency::where('status',1)->get();
        return view('backend.admin.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('backend.admin.currencies.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|unique:currencies,name',
        ]);

        $currency = new Currency;
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->save();
        Toastr::success('Currency Created Successfully');
        return back();


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $currency = Currency::find($id);
        return view('backend.admin.currencies.edit',compact('currency'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=> 'required|unique:currencies,name,'.$id,
        ]);

        $currency = Currency::find($id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->save();
        Toastr::success('Currency updated successfully','Success');
        return back();
    }

    public function destroy($id)
    {
        $currency = Currency::find($id);
        $currency->delete();
        Toastr::success('Currency deleted successfully','Success');
        return back();
    }
}
