<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\About;
use App\Model\DynamicPage;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about_us(){
        $about_us = About::first();
        $data['id']=$about_us->id;
        $data['image']=$about_us->image;
        $data['description']= getDescriptionByBnEn($about_us);
        $data['created_at']= $about_us->created_at;
        $data['updated_at']= $about_us->updated_at;

        if (!empty($data)){
            return response()->json(['success'=>true,'response'=> $data], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
    public function dynamic_pages(){
        $pages = DynamicPage::all();
        $nestedData = [];
        foreach ($pages as $page){
            $data['id']=$page->id;
            $data['name']= getNameByBnEn($page);
            $data['slug']=$page->slug;
            $data['description']= getDescriptionByBnEn($page);
            $data['created_at']= $page->created_at;
            $data['updated_at']= $page->updated_at;
            array_push($nestedData,$data);
        }
        if (!empty($nestedData)){
            return response()->json(['success'=>true,'response'=> $nestedData], 200);
        }else{
            return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
        }
    }
}
