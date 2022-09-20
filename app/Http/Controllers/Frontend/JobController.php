<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return view('frontend.pages.jobs');
    }
    public function becomeEmployee(){
        return view('frontend.pages.become_an_employee');
    }
}
