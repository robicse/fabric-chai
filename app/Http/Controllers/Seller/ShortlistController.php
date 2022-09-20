<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Shortlist;
use Illuminate\Support\Facades\Auth;

class ShortlistController extends Controller
{
    public function index(){
        $shortlists = Shortlist::join('employees','shortlists.employee_id','employees.id')
            ->where('employees.current_job_status',0)
            ->where('shortlists.employer_user_id',Auth::user()->id)
            ->orderBy('shortlists.created_at','DESC')
            ->get();
//        $shortlists = Shortlist::where('employer_user_id',Auth::id())->latest()->get();

        return view('frontend.seller.employer.shortlist',compact('shortlists'));
    }

}
