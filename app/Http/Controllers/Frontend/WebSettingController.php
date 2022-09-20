<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Model\WebSetting;
use Lang;
use Config;
use App;
use Session;

class WebSettingController extends Controller
{
	public function changeLanguage(Request $request){
		$settings = new WebSetting();
        if($request->ajax()){
            $request->session()->put('locale', $request->locale);
            //set language
            $language =	 $settings->getLanguage($request->id);
            $request->session()->put('locale', $language->code);
            if(Session::has('locale')){
                $locale = Session::get('locale', Config::get('app.locale'));
            }else{
                $locale = $language->code;
            }
            App::setLocale($locale);
            echo 'success';
        }
    }
}
