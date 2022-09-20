<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\DynamicPage;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DynamicPageController extends Controller
{
    public function privacy_and_policy(){
        $privacy_and_policy = DynamicPage::where('slug','privacy-policy')->first();
        return view('frontend.pages.privacy_and_policy',compact('privacy_and_policy'));
    }

    public function terms_and_conditions(){
        $terms_and_conditions = DynamicPage::where('slug','terms-and-conditions')->first();
        return view('frontend.pages.terms_and_conditions',compact('terms_and_conditions'));
    }

    public function return_refund_policy(){
        $return_refund_policy = DynamicPage::where('slug','return-refund-policy')->first();
        return view('frontend.pages.return_refund_policy',compact('return_refund_policy'));
    }

    public function cookies_policy(){
        $cookies_policy = DynamicPage::where('slug','cookies-policy')->first();
        return view('frontend.pages.cookies_policy',compact('cookies_policy'));
    }

    public function faq(){
        $faq = DynamicPage::where('slug','faq')->first();
        return view('frontend.pages.faq',compact('faq'));
    }
    public function staySafe(){
        $staySafe = DynamicPage::where('slug','stay-safe')->first();
        return view('frontend.pages.stay_safe',compact('staySafe'));
    }

    public function about_us(){
        $about_us = DynamicPage::where('slug','about-us')->first();
        return view('frontend.pages.about_us',compact('about_us'));
    }
    public function contact_us(){
        return view('frontend.pages.contact_us');
    }
}
