<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeOfferDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'sender_name' => getNameByBnEn($data),
                    'sender_image' => $data->avatar_original,
                    'company_address' => getCompanyAddressByBnEn($data),
                    'company_phone' => $data->company_phone,
                    'company_email' => $data->company_email,
                    'message' => $data->message,
                    'no_of_employee' =>$data->no_of_employee,
                    'established_year' =>(string) getNumberToBangla($data->established_year),
                    'owner_name' => $data->owner_name,
                    'salary_type' => $data->salary_type,
                    'date' => getDateConvertByBnEn($data->created_at),
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
