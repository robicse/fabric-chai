<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\MyEmail;
use App\Model\Blog;
use App\Model\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{
    public function index() {
        $blogs = Blog::latest()->get();

//        send_mailjet_mail();

        return view('frontend.pages.blog',compact('blogs'));
    }
    public function details($slug) {
        $blog = Blog::where('slug',$slug)->first();
        $latestBlogs = Blog::latest()->take(6)->get();
        return view('frontend.pages.blog_details',compact('blog','latestBlogs'));
    }
}
