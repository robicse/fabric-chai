<?php
//namespace App\Http;
use App\Model\Vat;
use Carbon\Carbon;
use App\Model\Product;
use App\Model\Currency;
use Twilio\Rest\Client;
use App\OtpConfiguration;
use App\Model\OnlineCharge;
use App\Model\SubSubCategory;
use App\Model\VisitorCounter;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Session;
use Rakibhstu\Banglanumber\NumberToBangla;

//class Helpers {
//
//    //returns combinations of customer choice options array
//
//   static function combinations($arrays) {
//        $result = array(array());
//        foreach ($arrays as $property => $property_values) {
//            $tmp = array();
//            foreach ($result as $result_item) {
//                foreach ($property_values as $property_value) {
//                    $tmp[] = array_merge($result_item, array($property => $property_value));
//                }
//            }
//            $result = $tmp;
//        }
//        return $result;
//    }
//
//}

## store unique ip address
if (! function_exists('total_visits')) {
    function total_visits()
    {

        $total_visits =  VisitorCounter::sum('count');
        return number_format($total_visits);

    }
}
if (! function_exists('today_visits')) {
    function today_visits()
    {
        $today_visits =  VisitorCounter::whereDate('created_at', Carbon::today())->sum('count');

        return number_format($today_visits);

    }
}
if (! function_exists('permonth_visits')) {
    function permonth_visits()
    {
        $first=VisitorCounter::first()->created_at;
        $last=VisitorCounter::latest()->first()->created_at;
        $date_difference = date_diff(date_create($first),date_create($last));
        $month =($date_difference->days)/30;
        if($month<=1 ){
            $month =2;
        }
        else {
            $month = $month;
        }

        $permonth_visits =  VisitorCounter::sum('count')/$month;

        //   return ($month);
        return number_format($permonth_visits);

    }
}


## store unique ip address
if (! function_exists('store_ip')) {
    function store_ip()
    {
        $ip = request()->ip();
        $is_ip_exist = VisitorCounter::where(['ip' => $ip])->first();
        if(!$is_ip_exist){
            VisitorCounter::create(['ip' =>$ip,'count' => 1]);
        }else{
            $is_ip_exist->update(['count' => $is_ip_exist->count + 1]);
        }
    }
}


//highlights the selected navigation on admin panel
if (! function_exists('sendSMS')) {
    function sendSMS($to, $from, $text)
    {
        $sid = env("TWILIO_SID"); // Your Account SID from www.twilio.com/console
        $token = env("TWILIO_AUTH_TOKEN"); // Your Auth Token from www.twilio.com/console

        $client = new Client($sid, $token);
        try {
            $message = $client->messages->create(
                $to, // Text this number
                array(
                    'from' => env('VALID_TWILLO_NUMBER'), // From a valid Twilio number
                    'body' => $text
                )
            );
        } catch (\Exception $e) {

        }
    }
}

if (! function_exists('convert_to_usd')) {
    function convert_to_usd($amount) {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::find($business_settings->value);
            return floatval($amount) / floatval($currency->exchange_rate);
        }
    }
}

//converts currency to home default currency
if (! function_exists('convert_price')) {
    function convert_price($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::find($business_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }

        $code = Currency::findOrFail(BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        if(Session::has('currency_code')){
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        }
        else{
            $currency = Currency::where('code', $code)->first();
        }

        $price = floatval($price) * floatval($currency->exchange_rate);

        return $price;
    }
}
if (! function_exists('convert_price_new')) {
    function convert_price_new($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::find($business_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }

        $code = Currency::findOrFail(BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        if(Session::has('currency_code')){
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        }
        else{
            $currency = Currency::where('code', $code)->first();
        }

        $price = floatval($price) * floatval($currency->exchange_rate);

        return number_format($price,5,'.', '');
    }
}

if (! function_exists('convert_price_new2')) {
    function convert_price_new2($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::find($business_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }

        $code = Currency::findOrFail(BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        if(Session::has('currency_code')){
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        }
        else{
            $currency = Currency::where('code', $code)->first();
        }

        $price = floatval($price) * floatval($currency->exchange_rate);

        return number_format($price,2,'.', '');
    }
}

//formats currency
if (! function_exists('format_price')) {
    function format_price($price)
    {
        if(BusinessSetting::where('type', 'symbol_format')->first()->value == 1){
            return currency_symbol().number_format($price, BusinessSetting::where('type', 'no_of_decimals')->first()->value);
        }
        return number_format($price, BusinessSetting::where('type', 'no_of_decimals')->first()->value).currency_symbol();
    }
}

//formats price to home default price with convertion
if (! function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

if (! function_exists('currency_symbol')) {
    function currency_symbol()
    {
        $code = Currency::findOrFail(BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        if(Session::has('currency_code')){
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        }
        else{
            $currency = Currency::where('code', $code)->first();
        }
        return $currency->symbol;
    }
}





//Custom Start

// usd to convert bdt
if (! function_exists('convert_to_bdt')) {
    function convert_to_bdt($amount) {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::find($business_settings->value);
            return floatval($amount) * floatval($currency->exchange_rate);
        }
    }
}

//formats currency
if (! function_exists('format_price_without_symbol')) {
    function format_price_without_symbol($price)
    {
        if(BusinessSetting::where('type', 'symbol_format')->first()->value == 1){
            return number_format($price);
        }
        return number_format($price);
    }
}

// default price without convertion
if (! function_exists('single_price_without_symbol')) {
    function single_price_without_symbol($price)
    {
        return format_price_without_symbol(convert_price($price));
    }
}

//formats currency
if (! function_exists('format_price_with_symbol')) {
    function format_price_with_symbol($price)
    {

        $amount =  number_format($price, BusinessSetting::where('type', 'no_of_decimals')->first()->value);
        return floatval($amount);
    }
}

// default price with convertion
if (! function_exists('single_price_with_symbol')) {
    function single_price_with_symbol($price)
    {
        return format_price_with_symbol(convert_price($price));
    }
}

// currency object/row
if (! function_exists('currency')) {
    function currency()
    {
        if(Session::has('currency_code')){
            $currency_code = Session::get('currency_code');
            $currency = Currency::where('code', Session::get('currency_code', $currency_code))->first();
        }
        else{
            $currency_code = Currency::findOrFail(\App\Model\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
            $currency = Currency::where('code', Session::get('currency_code', $currency_code))->first();
        }
        return $currency;
    }
}

// vat calculated percentage
if (! function_exists('vat')) {
    function vat_percentage()
    {
        return Vat::where('id',1)->pluck('vat_percentage')->first();
    }
}

// vat calculated amount
if (! function_exists('vat')) {
    function vat($commission)
    {
        $vat_percentage = Vat::where('id',1)->pluck('vat_percentage')->first();
        $vat = ($commission * $vat_percentage)/100;
        return floatval($vat);
    }
}

// online charge percentage
if (! function_exists('online_charge_percentage')) {
    function online_charge_percentage()
    {
        return OnlineCharge::where('id',1)->pluck('online_charge_percentage')->first();
    }
}

// vat calculated amount
if (! function_exists('online_charge')) {
    function online_charge($commission)
    {
        $online_charge_percentage = OnlineCharge::where('id',1)->pluck('online_charge_percentage')->first();
        $online_charge = ($commission * $online_charge_percentage)/100;
        return floatval($online_charge);
    }
}

//two digit formats price to home default price with convertion
if (! function_exists('two_digit_single_price')) {
    function two_digit_single_price($price)
    {
        return number_format($price, 2);
    }
}
if (! function_exists('two_digit_single_price_new')) {
    function two_digit_single_price_new($price)
    {
        return two_digit_format_price(convert_price($price));
    }
}

//two formats currency
if (! function_exists('two_digit_format_price')) {
    function two_digit_format_price($price)
    {
        if(BusinessSetting::where('type', 'symbol_format')->first()->value == 1){
            return currency_symbol().number_format($price, 2);
        }
        return number_format($price, 2).currency_symbol();
    }
}



////Price in USD Api
//if (! function_exists('price_in_usd')) {
//    function price_in_usd($price)
//    {
//        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
//        if($business_settings!=null){
//            $currency = Currency::find($business_settings->value);
//            $total = floatval($price) / floatval($currency->exchange_rate);
//        }
//        return number_format($total, 5);
//    }
//}

// Custom End









// BN EN Start


if (! function_exists('getAdvertisementByBnEn')) {
    function getAdvertisementByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $title = $data->title;
        }elseif($lang == 'bn') {
            $title = $data->title_bn ? $data->title_bn : $data->title;
        }else{
            $title = '';
        }
        return $title;
    }
}
if (! function_exists('getNameByBnEn')) {
    function getNameByBnEn($data) {
        $lang = app()->getLocale('locale');
        if(!empty($data)){
            if($lang == 'en'){
                $name = $data->name ? $data->name : $data->name_bn;
            }elseif($lang == 'bn') {
                $name = $data->name_bn ? $data->name_bn : $data->name;
            }else{
                $name = '';
            }
        }else{
            $name = '';
        }

        return $name;
    }
}
if (! function_exists('getCountryNameByBnEn')) {
    function getCountryNameByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $name = $data->country_name;
        }elseif($lang == 'bn') {
            $name = $data->country_name_bn ? $data->country_name_bn : $data->country_name;
        }else{
            $name = '';
        }
        return $name;
    }
}

if (! function_exists('getOwnerNameByBnEn')) {
    function getOwnerNameByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $name = $data->owner_name;
        }elseif($lang == 'bn') {
            $name = $data->owner_name_bn ? $data->owner_name_bn : $data->owner_name;
        }else{
            $name = '';
        }
        return $name;
    }
}

if (! function_exists('getPackageNameByBnEn')) {
    function getPackageNameByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $name = $data->package_name;
        }elseif($lang == 'bn') {
            $name = $data->package_name_bn ? $data->package_name_bn : $data->package_name;
        }else{
            $name = '';
        }
        return $name;
    }
}
if (! function_exists('getAuthorByBnEn')) {
    function getAuthorByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $author = $data->author;
        }elseif($lang == 'bn') {
            $author = $data->author_bn ? $data->author_bn : $data->author;
        }else{
            $author = '';
        }
        return $author;
    }
}
if (! function_exists('getTitleByBnEn')) {
    function getTitleByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $title = $data->title;
        }elseif($lang == 'bn') {
            $title = $data->title_bn ? $data->title_bn : $data->title;
        }else{
            $title = '';
        }
        return $title;
    }
}
if (! function_exists('getShortDescriptionByBnEn')) {
    function getShortDescriptionByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $short_description = $data->short_description;
        }elseif($lang == 'bn') {
            $short_description = $data->short_description_bn ? $data->short_description_bn : $data->short_description;
        }else{
            $short_description = '';
        }
        return $short_description;
    }
}
if (! function_exists('getLongDescriptionByBnEn')) {
    function getLongDescriptionByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $long_description = $data->long_description;
        }elseif($lang == 'bn') {
            $long_description = $data->long_description_bn ? $data->long_description_bn : $data->long_description;
        }else{
            $long_description = '';
        }
        return $long_description;
    }
}
if (! function_exists('getYesNoValue')) {
    function getYesNoValue($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $value = $data;
        }elseif($lang == 'bn') {
            if ($data == 'Yes'){
                $value = 'হ্যাঁ';
            }else{
                $value = 'না';
            }
        }else{
            $value = '';
        }
        return $value;
    }
}

if (! function_exists('getAddressByBnEn')) {
    function getAddressByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $title = $data->title;
        }elseif($lang == 'bn') {
            $title = $data->title_bn ? $data->title_bn : $data->title_bn;
        }else{
            $title = '';
        }
        return $title;
    }
}

if (! function_exists('getCompanyNameByBnEn')) {
    function getCompanyNameByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $company_name = $data->company_name;
        }elseif($lang == 'bn') {
            $company_name = $data->company_name_bn ? $data->company_name_bn : $data->company_name;
        }else{
            $company_name = '';
        }
        return $company_name;
    }
}

if (! function_exists('getCountryNameByBnEn')) {
    function getCountryNameByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $country_name = $data->country_name;
        }elseif($lang == 'bn') {
            $country_name = $data->country_name_bn ? $data->country_name_bn : $data->country_name;
        }else{
            $country_name = '';
        }
        return $country_name;
    }
}

if (! function_exists('getCompanyAddressByBnEn')) {
    function getCompanyAddressByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $company_address = $data->company_address;
        }elseif($lang == 'bn') {
            $company_address = $data->company_address_bn ? $data->company_address_bn : $data->company_address;
        }else{
            $company_address = '';
        }
        return $company_address;
    }
}

if (! function_exists('getCommentByBnEn')) {
    function getCommentByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $comment = $data->comment;
        }elseif($lang == 'bn') {
            $comment = $data->comment_bn ? $data->comment_bn : $data->comment;
        }else{
            $comment = '';
        }
        return $comment;
    }
}

if (! function_exists('getMembershipPackageNameByBnEn')) {
    function getMembershipPackageNameByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $package_name = $data->package_name;
        }elseif($lang == 'bn') {
            $package_name = $data->package_name_bn ? $data->package_name_bn : $data->package_name;
        }else{
            $package_name = '';
        }
        return $package_name;
    }
}

if (! function_exists('getDescriptionByBnEn')) {
    function getDescriptionByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $description = $data->description ? $data->description : $data->description_bn;
        }elseif($lang == 'bn') {
            $description = $data->description_bn ? $data->description_bn : $data->description;
        }else{
            $description = '';
        }
        return $description;
    }
}

if (! function_exists('getShortDescriptionByBnEn')) {
    function getShortDescriptionByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $short_description = $data->short_description;
        }elseif($lang == 'bn') {
            $short_description = $data->short_description_bn ? $data->short_description_bn : $data->short_description;
        }else{
            $short_description = '';
        }
        return $short_description;
    }
}

if (! function_exists('getInvoiceByBnEn')) {
    function getInvoiceByBnEn($invoice) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $name = $invoice;
        }elseif($lang == 'bn') {
            $str = $invoice;
            list($title, $dynamic_num) = explode('-', $str);
            $replace_title = str_replace("FLL","","$title");
            $name = 'এফএলএল'.getNumberToBangla($replace_title).'-'.getNumberToBangla($dynamic_num);
        }else{
            $name = '';
        }
        return $name;
    }
}

if (! function_exists('getQuestionByBnEn')) {
    function getQuestionByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $question = $data->question;
        }elseif($lang == 'bn') {
            $question = $data->question_bn ? $data->question_bn : $data->question;
        }else{
            $question = '';
        }
        return $question;
    }
}

if (! function_exists('getAnswerByBnEn')) {
    function getAnswerByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $answer = $data->answer;
        }elseif($lang == 'bn') {
            $answer = $data->answer_bn ? $data->answer_bn : $data->answer;
        }else{
            $answer = '';
        }
        return $answer;
    }
}

if (! function_exists('getPaidStatusByBnEn')) {
    function getPaidStatusByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $status = $data;
        }elseif($lang == 'bn') {
            if($data == 'Paid'){
                $status = trans('website.Paid');
            }else{
                $status = trans('website.Partial Paid');
            }
        }else{
            $status = '';
        }
        return $status;
    }
}

if (! function_exists('getPaymentByBnEn')) {
    function getPaymentByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $status = $data;
        }elseif($lang == 'bn') {
            if($data == 'Pay Manually'){
                $status = trans('website.Pay Manually');
            }else{
                $status = '';
            }
        }else{
            $status = '';
        }
        return $status;
    }
}

if (! function_exists('getCashByBnEn')) {
    function getCashByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $status = $data;
        }elseif($lang == 'bn') {
            if($data == 'Cash'){
                $status = trans('website.Cash');
            }else{
                $status = '';
            }
        }else{
            $status = '';
        }
        return $status;
    }
}

if (! function_exists('getCountryCodeByBnEn')) {
    function getCountryCodeByBnEn($data) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $country_code = $data;
        }elseif($lang == 'bn') {
            $country_code = '+৮৮০';
        }else{
            $country_code = '';
        }
        return $country_code;
    }
}

if (! function_exists('getNumberToBangla')) {
    function getNumberToBangla($num) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $text = $num;
        }elseif($lang == 'bn') {
            $numto = new NumberToBangla();

            // If you want to convert any number (Integer of Float) into Bangla Word
            //$text = $numto->bnWord(13459);    // Output:  তেরো হাজার চার শত ঊনষাট
            //$text = $numto->bnWord(1345.05);  // Output:  এক হাজার তিন শত পঁয়তাল্লিশ দশমিক শূন্য পাঁচ

            // Integer
            //$text = $numto->bnWord(13459);    // Output:  তেরো হাজার চার শত ঊনষাট

            // Float
            //$text = $numto->bnWord(1345.05);    // Output: এক হাজার তিন শত পঁয়তাল্লিশ দশমিক শূন্য পাঁচ
            //$text = $numto->bnWord(345675.105); // Output: তিন লক্ষ পঁয়তাল্লিশ হাজার ছয় শত পঁচাত্তর দশমিক এক শূন্য পাঁচ

            //$text = $numto->bnMoney(13459);     // Output:  তেরো হাজার চার শত ঊনষাট টাকা
            //$text = $numto->bnMoney(13459.05);  // Output:  তেরো হাজার চার শত ঊনষাট টাকা পাঁচ পয়সা
            //$text = $numto->bnMoney(13459.5);   // Output:  তেরো হাজার চার শত ঊনষাট টাকা পঞ্চাশ পয়সা

            $text = $numto->bnNum($num);    // Output:  ১৩৪৫৯
            //$text = $numto->bnNum(2334.768); // Output:  ২৩৩৪.৭৬৮

            //$text = $numto->bnMonth(1);    // Output:  জানুয়ারি
            //$text = $numto->bnMonth(4);    // Output:  এপ্রিল

            //$text = $numto->bnCommaLakh(12121212);    // Output:  ১,২১,২১,২১২
            //dd($text);
        }else{
            $text = '';
        }

        return $text;
    }
}

if (! function_exists('getNumberWithCurrencyByBnEn')) {
    function getNumberWithCurrencyByBnEn($num) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            if(currency()->code == 'BDT'){
                $update_num = two_digit_single_price($num);
            }else{
                $update_num = single_price($num);
            }
        }elseif($lang == 'bn') {
            if(currency()->code == 'BDT'){
                //$update_num = '৳'.getNumberToBangla($num).'.০০';
                //$update_num = '৳'.getNumberToBangla($num);
                $update_num = '৳'.getNumberToBangla(convert_price_new2($num));
            }else{
                $update_num = '$'.getNumberToBangla(convert_price_new($num));
            }
        }else{
            $update_num = '';
        }
        return $update_num;
    }
}

if (! function_exists('getDateConvertByBnEn')) {
    function getDateConvertByBnEn($date) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $convertedDATE = date('j M Y h:i A',strtotime($date));
        }elseif($lang == 'bn') {
//            $currentDate = date("j M Y h:i A");
            $currentDate = date('j M Y h:i A',strtotime($date));
//            $engDATE = array('1','2','3','4','5','6','7','8','9','0','January','February','March','April',
//                'May','June','July','August','September','October','November','December','Saturday','Sunday',
//                'Monday','Tuesday','Wednesday','Thursday','Friday');
            $engDATE = array('1','2','3','4','5','6','7','8','9','0','Jan','Feb','Mar','Apr',
                'May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Sat','Sun',
                'Mon','Tue','Wed','Thu','Fri','AM','PM');
            $bangDATE = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে',
                'জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
বুধবার','বৃহস্পতিবার','শুক্রবার','এএম','পিএম'
            );
            $convertedDATE = str_replace($engDATE, $bangDATE, $currentDate);
        }else{
            $convertedDATE = '';
        }

        return $convertedDATE;
    }
}

if (! function_exists('categoryTwo')) {
    function categoryTwo($id)
    {
        $nestedData = [];
        $subCategories = \App\Model\SubCategory::where('category_id', $id)->get();
        foreach ($subCategories as $subCategory){
            $data['id']= $subCategory->id;
            $data['name']=getNameByBnEn($subCategory);
            $data['category_three']= categoryThree($subCategory->id);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}
if (! function_exists('categoryThree')) {
    function categoryThree($id)
    {
        $nestedData = [];
        $subSubCategories = \App\Model\SubSubCategory::where('sub_category_id', $id)->get();
        foreach ($subSubCategories as $subSubCategory){
            $data['id']= $subSubCategory->id;
            $data['name']= getNameByBnEn($subSubCategory);
            $data['category_four']= categoryFour($subSubCategory->id);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}
if (! function_exists('categoryFour')) {
    function categoryFour($id)
    {
        $nestedData = [];
        $subSubChildCategories = \App\Model\SubSubChildCategory::where('sub_sub_category_id', $id)->get();
        foreach ($subSubChildCategories as $subSubChildCategory){
            $data['id']= $subSubChildCategory->id;
            $data['name']= getNameByBnEn($subSubChildCategory);
            $data['category_five']= categoryFive($subSubChildCategory->id);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}
if (! function_exists('categoryFive')) {
    function categoryFive($id)
    {
        $nestedData = [];
        $subSubChildChildCategories = \App\Model\SubSubChildChildCategory::where('sub_sub_child_cat_id', $id)->get();
        foreach ($subSubChildChildCategories as $subSubChildChildCategory){
            $data['id']= $subSubChildChildCategory->id;
            $data['name']= getNameByBnEn($subSubChildChildCategory);
            $data['category_six']= categorySix($subSubChildChildCategory->id);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}
if (! function_exists('categorySix')) {
    function categorySix($id)
    {
        $nestedData = [];
        $categories = \App\Model\CategorySix::where('sub_sub_child_child_cat_id', $id)->get();
        foreach ($categories as $category){
            $data['id']= $category->id;
            $data['name']= getNameByBnEn($category);
            $data['category_seven']= categorySeven($category->id);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}
if (! function_exists('categorySeven')) {
    function categorySeven($id)
    {
        $nestedData = [];
        $categories = \App\Model\CategorySeven::where('category_six_id', $id)->get();
        foreach ($categories as $category){
            $data['id']= $category->id;
            $data['name']= getNameByBnEn($category);
            $data['category_eight']= categoryEight($category->id);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}
if (! function_exists('categoryEight')) {
    function categoryEight($id)
    {
        $nestedData = [];
        $categories = \App\Model\CategoryEight::where('category_seven_id', $id)->get();
        foreach ($categories as $category){
            $data['id']= $category->id;
            $data['name']= getNameByBnEn($category);
            $data['category_nine']= categoryNine($category->id);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}
if (! function_exists('categoryNine')) {
    function categoryNine($id)
    {
        $nestedData = [];
        $categories = \App\Model\CategoryNine::where('category_eight_id', $id)->get();
        foreach ($categories as $category){
            $data['id']= $category->id;
            $data['name']= getNameByBnEn($category);
            $data['category_ten']= categoryTen($category->id);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}
if (! function_exists('categoryTen')) {
    function categoryTen($id)
    {
        $nestedData = [];
        $categories = \App\Model\CategoryTen::where('category_nine_id', $id)->get();
        foreach ($categories as $category){
            $data['id']= $category->id;
            $data['name']= getNameByBnEn($category);
            array_push($nestedData,$data);
        }
        return $nestedData;
    }
}

// BN EN End


?>
