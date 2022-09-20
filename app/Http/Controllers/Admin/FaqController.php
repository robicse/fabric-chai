<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Faq;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:faqs-list|faqs-create|faqs-edit', ['only' => ['index','store']]);
        $this->middleware('permission:faqs-create', ['only' => ['create','store']]);
        $this->middleware('permission:faqs-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:faqs-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $faqs = Faq::all();
        return view('backend.admin.faqs.index',compact('faqs'));
    }

    public function create()
    {
        return view('backend.admin.faqs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           'question' =>'required',
           'answer' =>'required',
        ]);

        $faq = new Faq();
        $faq->question = $request->question;
        $faq->question_bn = $request->question_bn;
        $faq->answer = $request->answer;
        $faq->answer_bn = $request->answer_bn;
        $faq->save();
        Toastr::success('FAQ created Successfully');
        return redirect()->route('admin.faqs.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        return view('backend.admin.faqs.edit',compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);
        $faq->question = $request->question;
        $faq->question_bn = $request->question_bn;
        $faq->answer = $request->answer;
        $faq->answer_bn = $request->answer_bn;
        $faq->save();
        Toastr::success('FAQ updated Successfully');
        return redirect()->route('admin.faqs.index');
    }

    public function destroy($id)
    {
        $faq = Faq::find($id);
        $faq->delete();
        Toastr::success('FAQ Deleted Successfully');
        return back();
    }
}
