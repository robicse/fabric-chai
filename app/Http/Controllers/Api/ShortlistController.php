<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShortlistCollection;
use App\Model\Shortlist;
use Illuminate\Support\Facades\Auth;

class ShortlistController extends Controller
{
    public $successStatus = 201;
    public $failStatus = 401;

    public function shortlist(){
        $shortlists = Shortlist::join('employees','shortlists.employee_id','employees.id')
            ->where('shortlists.employer_user_id', Auth::user()->id)
            ->where('employees.current_job_status',0)
            ->select('shortlists.id','shortlists.employer_user_id','shortlists.employee_user_id','shortlists.employee_id','employees.village_or_area','employees.experience','employees.age','employees.expected_salary','employees.employee_pic','shortlists.created_at')
            ->latest()
            ->get();

        return new ShortlistCollection($shortlists);
    }

}
