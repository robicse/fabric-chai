<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\PriorityBuyer;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function getContactBnEn(Request $request)
    {
        $lang = app()->getLocale('locale');
        if($lang == 'en') {
            $data = [
                'company_address'=>'Azad Plaza (4th Floor), TA-98/1, Gulshan, Badda Link Road, Gulshan-1, Dhaka-1212',
                'company_contact_no'=>'09678-236236',
            ];
        }else{
            $data = [
                'company_address'=>trans('website.Azad Plaza (4th Floor), TA-98/1, Gulshan, Badda Link Road, Gulshan-1, Dhaka-1212'),
                'company_contact_no'=> getNumberToBangla('09678').'-'.getNumberToBangla('236236'),
            ];
        }
        return response()->json($data, 200);
    }
    public function priorityBuyers(){
        $priorityBuyers = PriorityBuyer::select('id','image')->get();
        if (!empty($priorityBuyers))
        {
            return response()->json(['success'=>true,'response'=> $priorityBuyers], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
