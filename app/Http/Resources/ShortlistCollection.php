<?php

namespace App\Http\Resources;

use App\Model\Employee;
use App\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShortlistCollection extends ResourceCollection
{
    public function toArray($request)
    {


        return [
            'data' => $this->collection->map(function($data) {
                $user = User::find($data->employee_user_id);
                $employee_pic = Employee::where('id',$data->employee_id)->pluck('employee_pic')->first();
                $employee = Employee::where('user_id',$data->employee_user_id)->first();
                if ($employee->expected_salary){
                    $expected_salary = explode(' - ',$employee->expected_salary);
                    $expected_salary_range = getNumberWithCurrencyByBnEn($expected_salary[0]) .' - '. getNumberWithCurrencyByBnEn($expected_salary[1]);
                }else{
                    $expected_salary_range = '';
                }
                return [
                    'id' =>(int) $data->id,
                    'employer_user_id' =>(int) $data->employer_user_id,
                    'employee_user_id' =>(int) $data->employee_user_id,
                    'employee_name' => getNameByBnEn($user),
                    'employee_pic' => $employee_pic,
                    'village_or_area' => $data->village_or_area,
                    'experience' => $data->experience,
                    'age' => $data->age,
                    'expected_salary' => $expected_salary_range,
                    'date' => getDateConvertByBnEn($data->created_at),
//                    'link'=> [
//                        'offer_details' => route('offer.details', $data->id),
//                    ]
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
