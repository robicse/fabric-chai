<?php

namespace App\Http\Resources;

use App\Model\Employee;
use App\Model\Seller;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OfferEmployeeListCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function($data) {
                $employee = \App\Model\Employee::where('user_id',$data->receiver_user_id)->first();
                if ($employee->verification_status == 1){
                    $status = 'Verified';
                }else{
                    $status = 'Unverified';
                }
                return [
                    'id' =>(integer) $employee->id,
                    'image' => $employee->employee_pic,
                    'name' => getNameByBnEn($employee->user),
                    'experience' => $employee->experience,
                    'location' => $employee->village_or_area,
                    'expected_salary' => $employee->expected_salary,
                    'age' =>(string) getNumberToBangla($employee->age) ,
                    'verification_status' => $status,
                    'link'=> [
                        'view_profile' => route('employee.details', $employee->id),
                    ]
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
