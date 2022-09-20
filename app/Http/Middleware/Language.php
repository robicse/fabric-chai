<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Config;
use App;
use DB;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // only for web
//        if(Session::has('locale')){
//            $locale = Session::get('locale', Config::get('app.locale'));
//            App::setLocale($locale);
//        }else{
//            $languages = DB::table('languages')->where('is_default','=','1')->get();
//            $request->session()->put('locale', $languages[0]->code);
//            $locale = $languages[0]->code;
//            App::setLocale($locale);
//        }


        // https://stackcoder.in/posts/localization-in-laravel-rest-api
        // web and app same middleware
        if ($request->hasHeader("lang")) {
            // for api
            App::setLocale($request->header("lang"));
        }else{
            // for web
            if(Session::has('locale')){
                $locale = Session::get('locale', Config::get('app.locale'));
                App::setLocale($locale);
            }else{
                $languages = DB::table('languages')->where('is_default','=','1')->get();
                $request->session()->put('locale', $languages[0]->code);
                $locale = $languages[0]->code;
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}
