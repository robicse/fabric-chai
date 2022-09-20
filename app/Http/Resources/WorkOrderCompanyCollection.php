<?php

namespace App\Http\Resources;

use App\Model\WorkOrderQuotationRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class WorkOrderCompanyCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $user = \App\User::find($data->user_id);
                $factory = \App\Model\WorkorderFactory::where('user_id',$user->id)->first();
                return [
                    'user_id' =>(integer) $user->id,
                    'company_image' =>(string) $factory->factory_image,
                    'company_name' =>(string) $factory->seller ? $factory->seller->company_name : null,
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
