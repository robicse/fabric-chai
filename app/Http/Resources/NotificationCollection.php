<?php

namespace App\Http\Resources;

use App\Model\Notification;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class NotificationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [

            'data' => $this->collection->map(function($data) {

                return [
                    'id' => (integer) $data->id,
                    'product_id' => (integer) $data->product_id,
                    'sender_name' =>(string) getNameByBnEn($data->sender),
                    'title' => $data->title,
                    'message' => $data->message,
                    'receiver_sidebar_view_status' => (integer) $data->receiver_sidebar_view_status,
                    'admin_sidebar_view_status' => (integer) $data->admin_sidebar_view_status,
                    'receiver_view_status' => (integer) $data->receiver_view_status,
                    'admin_view_status' => (integer) $data->admin_view_status,
                    'date' =>(string) getDateConvertByBnEn($data->created_at),

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
