<?php

namespace App\Http\Resources;

use App\Model\Seller;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeListCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function($data) {
                if ($data->verification_status == 1){
                    $status = 'Verified';
                }else{
                    $status = 'Unverified';
                }
                if ($data->expected_salary){
                    $expected_salary = explode(' - ',$data->expected_salary);
                    $expected_salary_range = getNumberWithCurrencyByBnEn($expected_salary[0]) .' - '. getNumberWithCurrencyByBnEn($expected_salary[1]);
                }else{
                    $expected_salary_range = '';
                }
                return [
                    'id' =>(integer) $data->id,
                    'image' => $data->employee_pic,
                    'name' =>getNameByBnEn($data->user),
                    'experience' => $data->experience,
                    'location' => $data->village_or_area,
                    'expected_salary' => $expected_salary_range,
                    'age' =>(string) getNumberToBangla($data->age) ,
                    'verification_status' => $status,
                    'link'=> [
                        'view_profile' => route('employee.details', $data->id),
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
