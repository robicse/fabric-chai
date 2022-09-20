<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Advertisement;
use App\Model\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public  function getSliders()
    {
        $sliders= Slider::where('date_duration','>=',date('Y-m-d'))->select('id','image','url')->get();
        if (!empty($sliders))
        {
            return response()->json(['success'=>true,'response'=> $sliders], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public  function getHomeAds()
    {
        $ads= Advertisement::where('position',1)->select('id','title','image')->get();
        if (!empty($ads))
        {
            return response()->json(['success'=>true,'response'=> $ads], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public  function getEmployerAds()
    {
        $ads= Advertisement::where('position',2)->select('id','image')->get();
        if (!empty($ads))
        {
            return response()->json(['success'=>true,'response'=> $ads], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
