<?php
//filter products published
//require 'vendor/autoload.php';
use App\Helpers\UserInfo;
use App\Model\PaymentHistory;
use App\Model\VerificationCode;
use App\Model\Notification;
use App\User;
use App\Model\Seller;
use App\Model\Buyer;
use App\Model\Product;
use App\Model\ProductBid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//unique phone number check
if (! function_exists('phoneNumberCheck')) {
    function phoneNumberCheck($phone) {
        $user = User::where('phone', $phone)->first();
        return response()->json([
            'message' => 'Phone number already exist rocky vai :P!!',
        ], 201);
    }
}

if (! function_exists('imageUpload')) {
    function imageUpload($image, $path,$size) {

        $currentDate = \Illuminate\Support\Carbon::now()->toDateString();
        $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
        if ($size == 0){
            $proImage = Image::make($image)->save($image->getClientOriginalExtension());
        }else{
            $proImage = Image::make($image)->resize($size)->save($image->getClientOriginalExtension());
        }
        Storage::disk('public')->put($path . $imagename, $proImage);
        return $imagename;
    }
}

//otp send after registration
if (! function_exists('mobileVerification')) {
    function mobileVerification($userReg) {
        //return $userReg;
        $verification = VerificationCode::where('phone',$userReg->phone)->first();
        if (!empty($verification)){
            $verification->delete();
        }
        $verCode = new VerificationCode();
        $verCode->phone = $userReg->phone;
        $verCode->code = mt_rand(1111,9999);
        $verCode->status = 0;
        $verCode->save();
        $text = "Dear ".$userReg->name.", Your Fabrics Lagbe OTP is: ".$verCode->code;
        if($userReg->country_code == '+880') {
            UserInfo::smsAPI('880' . $verCode->phone, $text);
            $title = 'Registration';
            RegistrationSmsNotification($userReg->id,$title,$text);
//            return true;
        }else{
            $receiver_email = $userReg->email;
            $receiver_name = $userReg->name;
            $sender_email = 'fabricslagbe@gmail.com';
            $sender_name='Fabric Lagbe';
            $subject='Welcome To Fabric Lagbe';
            $message="<h3>Dear $userReg->name,<br /> welcome to <a href='https://www.fabriclagbe.com/'>fabriclagbe.com</a>!</h3><br /><b>Your OTP is $verCode->code.</b> <br/>
            <br/>
            <p> Best Regards</p>
            <p> Team, Fabric Lagbe LTD </p>";
            send_mailjet_mail1($receiver_email,$receiver_name,$sender_email,$sender_name,$subject,$message);
            $title = 'Registration';
            RegistrationSmsNotification($userReg->id,$title,$text);
        }
    }
}

if (! function_exists('checkMembershipStatus')) {
    function checkMembershipStatus($user_id) {

        return User::where('id',$user_id)
            ->where('membership_package_id','!=',NULL)
            ->where('membership_activation_date','<=',date('Y-m-d'))
            ->where('membership_expired_date','>=',date('Y-m-d'))
            ->pluck('membership_package_id')
            ->first();
    }
}
if (! function_exists('checkProfileCompleteStatus')) {
    function checkProfileCompleteStatus($user_id) {
        return Seller::where('user_id',$user_id)
            ->pluck('profile_complete_status')
            ->first();
    }
}

if (! function_exists('checkMembershipList')) {
    function checkMembershipList() {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $packages = \App\Model\MembershipPackage::select('id','package_name','price')->get();
        }elseif($lang == 'bn') {
            $packages = \App\Model\MembershipPackage::select('id','package_name_bn as package_name','price')->get();
        }else{
            $packages = '';
        }
        return $packages;
    }
}

if (! function_exists('getCountryList')) {
    function getCountryList() {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $countries = \App\Model\Countries::select('id','country_name')->get();
        }elseif($lang == 'bn') {
            $countries = \App\Model\Countries::select('id','country_name_bn as country_name')->get();
        }else{
            $countries = '';
        }
        return $countries;
    }
}

if (! function_exists('checkCurrentMembershipName')) {
    function checkCurrentMembershipName($user_id) {
        $lang = app()->getLocale('locale');
        if($lang == 'en'){
            $package_name = User::join('membership_packages','users.membership_package_id','membership_packages.id')
                ->where('users.id',$user_id)
                ->pluck('membership_packages.package_name')
                ->first();
        }elseif($lang == 'bn') {
            $package_name = User::join('membership_packages','users.membership_package_id','membership_packages.id')
                ->where('users.id',$user_id)
                ->pluck('membership_packages.package_name_bn')
                ->first();
        }else{
            $package_name = '';
        }
        return $package_name;
    }
}
if (! function_exists('checkPackageUpdate')) {
    function checkPackageUpdate($user_id) {
        $user = User::find($user_id);
        if ($user->membership_package_id == 2){

        }

//        return User::join('membership_packages','users.membership_package_id','membership_packages.id')
//            ->where('users.id',$user_id)
//            ->pluck('membership_packages.package_name')
//            ->first();
    }
}

if (! function_exists('sellerCurrentCommission')) {
    function sellerCurrentCommission($id) {

        return DB::table('membership_package_details')
            ->join('membership_packages','membership_package_details.membership_package_id','membership_packages.id')
            ->join('users','membership_packages.id','users.membership_package_id')
            ->where('users.id',$id)
            ->pluck('membership_package_details.commission')
            ->first();
    }
}

if (! function_exists('createNotification')) {
    function createNotification($receiver_user_id,$title,$message) {

        $notification = new Notification();
        $notification->sender_user_id = Auth::user()->id;
        $notification->receiver_user_id = $receiver_user_id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->date = Date('Y-m-d');
        $notification->save();
        $insert_id = $notification->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}
if (! function_exists('createWONotification')) {
    function createWONotification($receiver_user_id,$title,$message) {

        $notification = new Notification();
        $notification->sender_user_id = Auth::user()->id;
        $notification->receiver_user_id = $receiver_user_id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->work_order_status = 1;
        $notification->date = Date('Y-m-d');
        $notification->save();
        $insert_id = $notification->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}
if (! function_exists('placedBidNotification')) {
    function placedBidNotification($productId,$receiver_user_id,$title,$message) {

        $notification = new Notification();
        $notification->sender_user_id = Auth::user()->id;
        $notification->receiver_user_id = $receiver_user_id;
        $notification->product_id = $productId;
        $notification->title = $title;
        $notification->message = $message;
        $notification->date = Date('Y-m-d');
        $notification->save();
        $insert_id = $notification->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}
if (! function_exists('workOrderPlacedBidNotification')) {
    function workOrderPlacedBidNotification($productId,$receiver_user_id,$title,$message) {

        $notification = new Notification();
        $notification->sender_user_id = Auth::user()->id;
        $notification->receiver_user_id = $receiver_user_id;
        $notification->work_order_product_id = $productId;
        $notification->title = $title;
        $notification->message = $message;
        $notification->work_order_status = 1;
        $notification->date = Date('Y-m-d');
        $notification->save();
        $insert_id = $notification->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}

if (! function_exists('createNotificationWithProductId')) {
    function createNotificationWithProductId($receiver_user_id,$title,$message,$product_id) {

        $notification = new Notification();
        $notification->sender_user_id = Auth::user()->id;
        $notification->receiver_user_id = $receiver_user_id;
        $notification->product_id = $product_id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->date = Date('Y-m-d');
        $notification->save();
        $insert_id = $notification->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}
if (! function_exists('createWONotificationWithProductId')) {
    function createWONotificationWithProductId($receiver_user_id,$title,$message,$product_id) {

        $notification = new Notification();
        $notification->sender_user_id = Auth::user()->id;
        $notification->receiver_user_id = $receiver_user_id;
        $notification->work_order_product_id = $product_id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->work_order_status = 1;
        $notification->date = Date('Y-m-d');
        $notification->save();
        $insert_id = $notification->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}

if (! function_exists('checkSellerApproved')) {
    function checkSellerApproved($user_id) {

        return Seller::where('user_id',$user_id)->pluck('verification_status')->first();
    }
}

if (! function_exists('checkBuyerApproved')) {
    function checkBuyerApproved($user_id) {

        return Buyer::where('user_id',$user_id)->pluck('verification_status')->first();
    }
}

if (! function_exists('checkProductApproved')) {
    function checkProductApproved($product_id) {

        return Product::where('id',$product_id)->pluck('verification_status')->first();
    }
}
if (! function_exists('checkWOProductApproved')) {
    function checkWOProductApproved($product_id) {
        return \App\Model\WorkOrderProduct::where('id',$product_id)->pluck('verification_status')->first();
    }
}

if (! function_exists('registrationNotification')) {
    function registrationNotification($sender_user_id,$title,$message) {

        $notification = new Notification();
        $notification->sender_user_id = $sender_user_id;
        $notification->receiver_user_id = 9;
        $notification->title = $title;
        $notification->message = $message;
        $notification->date = Date('Y-m-d');
        $notification->save();
        $insert_id = $notification->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}

if (! function_exists('registrationNotificationAdmin')) {
    function registrationNotificationAdmin($receiver_user_id,$title,$message) {

        $notification = new Notification();
        $notification->sender_user_id = 9;
        $notification->receiver_user_id = $receiver_user_id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->date = Date('Y-m-d');
        $notification->save();
        $insert_id = $notification->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}

if (! function_exists('SmsNotification')) {
    function SmsNotification($user_id,$title,$text) {

        $sms = new \App\Model\Message();
        $sms->receiver_user_id = $user_id;
        $sms->sender_user_id = Auth::id();
        $sms->title = $title;
        $sms->message = $text;
        $sms->save();
        $insert_id = $sms->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}
if (! function_exists('RegistrationSmsNotification')) {
    function RegistrationSmsNotification($user_id,$title,$text) {

        $sms = new \App\Model\Message();
        $sms->receiver_user_id = $user_id;
        $sms->sender_user_id = 9;
        $sms->title = $title;
        $sms->message = $text;
        $sms->save();
        $insert_id = $sms->id;

        if($insert_id){
            return true;
        }else{
            return false;
        }
    }
}

if (! function_exists('notViewNotificationCount')) {
    function notViewNotificationCount() {

        return DB::table('notifications')
            ->where('receiver_user_id',Auth::user()->id)
            //->where('receiver_sidebar_view_status',0)
            ->where('receiver_view_status',0)
            ->select(DB::raw('count(id) as count'))
            ->first();
    }
}
if (! function_exists('notViewWONotificationCount')) {
    function notViewWONotificationCount() {

        return DB::table('notifications')
            ->where('receiver_user_id',Auth::user()->id)
            ->where('work_order_status',1)
            ->where('receiver_view_status',0)
            ->select(DB::raw('count(id) as count'))
            ->first();
    }
}

if (! function_exists('notViewAdminNotificationCount')) {
    function notViewAdminNotificationCount() {

        return DB::table('notifications')
            //->where('admin_sidebar_view_status',0)
            ->where('admin_view_status',0)
            ->select(DB::raw('count(id) as count'))
            ->first();
    }
}

if (! function_exists('pendingSellerPaymentCount')) {
    function pendingSellerPaymentCount() {

        return PaymentHistory::where('payment_status','Partial Paid')
            ->select(DB::raw('count(id) as count'))
            ->first();
    }
}

if (! function_exists('bidCount')) {
    function bidCount($id) {
        $bid = \App\Model\ProductBid::where('product_id',$id)->count();
        return $bid;
    }
}
if (! function_exists('workOrderBidCount')) {
    function workOrderBidCount($id) {
        $bid = \App\Model\WorkOrderBid::where('work_order_product_id',$id)->count();
        return $bid;
    }
}
if (! function_exists('Bidder')) {
    function Bidder($id) {
        $senderUser = User::where('id',$id)->first();
        return $senderUser;
    }
}
if (! function_exists('receiverUser')) {
    function receiverUser($id) {
        $receiverUser = User::where('id',$id)->first();
        return $receiverUser;
    }
}

if (! function_exists('productAuthCheck')) {
    function productAuthCheck($id) {
        $product = \App\Model\Product::where('id',$id)->where('user_id',Auth::id())->first();
        return $product;
    }
}

if (! function_exists('checkBuyerAlsoSeller')) {
    function checkBuyerAlsoSeller() {
        return DB::table('users')
            ->leftJoin('sellers','users.id','sellers.user_id')
            ->where('users.id',Auth::id())
            ->pluck('sellers.user_id')
            ->first();

    }
}

if (! function_exists('userChainInformation')) {
    function userChainInformation($id) {
        $userIfo = User::find($id);
        $user['user_id']=$userIfo->id;
        $user['user_type']=$userIfo->user_type;
        $user['name']=$userIfo->name;
        $user['email']=$userIfo->email;
        $user['phone']=$userIfo->phone;
        $user['avatar']=$userIfo->avatar;
        $user['avatar_original']=$userIfo->avatar_original;
        $user['address']=$userIfo->address;
        $user['country']=$userIfo->country;
        $user['city']=$userIfo->city;
        $user['postal_code']=$userIfo->postal_code;
        $user['balance']=$userIfo->balance;
        $user['banned']=$userIfo->banned;
        $user['membership_package_id']=$userIfo->membership_package_id;
        $user['membership_activation_date']=$userIfo->membership_activation_date;
        $user['membership_expired_date']=$userIfo->membership_expired_date;

        $sellerInfo = Seller::where('user_id',$id)->first();
        if($sellerInfo){
            $seller['seller_id'] = $sellerInfo->id;
            $seller['verification_status'] = $sellerInfo->verification_status;
            $seller['company_name'] = $sellerInfo->company_name;
            $seller['company_phone'] = $sellerInfo->company_phone;
            $seller['company_email'] = $sellerInfo->company_email;
            $seller['company_address'] = $sellerInfo->company_address;
            $seller['division_id'] = $sellerInfo->division_id;
            $seller['district_id'] = $sellerInfo->district_id;
            $seller['designation'] = $sellerInfo->designation;
            $seller['selected_category'] = $sellerInfo->selected_category;
            $seller['trade_licence'] = $sellerInfo->trade_licence;
            $seller['nid'] = $sellerInfo->nid;
            $seller['pay_to_admin'] = $sellerInfo->pay_to_admin;
        }else{
            $seller = '';
        }

        $buyerInfo = Buyer::where('user_id',$id)->first();
        if($buyerInfo){
            $buyer['buyer_id'] = $buyerInfo->id;
            $buyer['status'] = $buyerInfo->status;
            $buyer['verification_status'] = $buyerInfo->verification_status;
        }else{
            $buyer = '';
        }

        $sellerProductInfos = Product::where('user_id',$id)->where('user_type','seller')->get();
        if(count($sellerProductInfos) > 0){
            foreach($sellerProductInfos as $sellerProductInfo){
                $sellerProduct['product_id'] = $sellerProductInfo->id;
            }
        }else{
            $sellerProduct = '';
        }

        $totalSellerProductSold = Product::where('user_id',$id)->where('user_type','seller')->where('delivery_status','Completed')->count();;
        $sumSellerProductAmount = ProductBid::where('receiver_user_id',$id)->where('bid_status',1)->select(DB::raw('SUM(unit_bid_price) as total_amount'))->first();
        $totalSellerProductCount = Product::where('user_id',$id)->where('user_type','seller')->count();
        $sellerPayToAdmin = Seller::where('user_id',$id)->pluck('pay_to_admin')->first();


        return [
            'user' => $user,
            'seller' => $seller,
            'buyer' => $buyer,
            'sellerProduct' => $sellerProduct,
            'totalSellerProductSold' => $totalSellerProductSold,
            'sumSellerProductAmount' => $sumSellerProductAmount->total_amount,
            'totalSellerProductCount' => $totalSellerProductCount,
            'sellerPayToAdmin' => $sellerPayToAdmin,
        ];

    }
}

if (! function_exists('adminTotalEarning')) {
    function adminTotalEarning()
    {
        $payment_history = DB::table('payment_histories')
            ->where('payment_status','Paid')
            ->select(DB::raw('SUM(amount) as total_earning'))
            ->first();
        return $payment_history->total_earning;
    }
}

if (! function_exists('getUnit')) {
    function getUnit($id)
    {
        return DB::table('units')
            ->join('products','units.id','products.unit_id')
            ->where('products.id',$id)
            ->pluck('units.name')
            ->first();
    }
}

if (! function_exists('getRatingPerson')) {
    function getRatingPerson($id)
    {
        $reviews = DB::table('reviews')
            ->join('products','reviews.product_id','products.id')
            ->where('products.id',$id)
            ->select(DB::raw('COUNT(reviews.id) as total_row'))
            ->first();
        return $reviews->total_row;
    }
}

if (! function_exists('getTotalSaleAmount')) {
    function getTotalSaleAmount($id)
    {
        $sale_records = DB::table('sale_records')
            ->where('seller_user_id',$id)
            ->select(DB::raw('SUM(amount) as total_sale'))
            ->first();
        return $sale_records->total_sale;
    }
}

if (! function_exists('getTotalCommissionAmount')) {
    function getTotalCommissionAmount($id)
    {
        $sale_records = DB::table('sale_records')
            ->where('seller_user_id',$id)
            ->select(DB::raw('SUM(admin_commission) as total_admin_commission'))
            ->first();
        return $sale_records->total_admin_commission;
    }
}
if (! function_exists('getTotalVatAmount')) {
    function getTotalVatAmount($id)
    {
        $sale_records = DB::table('sale_records')
            ->where('seller_user_id',$id)
            ->select(DB::raw('SUM(vat) as total_vat'))
            ->first();
        return $sale_records->total_vat;
    }
}

if (! function_exists('getTotalCommissionPaidAmount')) {
    function getTotalCommissionPaidAmount($id)
    {
        $payment_histories = DB::table('payment_histories')
            ->where('user_id',$id)
            ->where('payment_status','=','Paid')
            ->select(DB::raw('SUM(amount) as total_commission_paid_amount'),DB::raw('SUM(online_charge) as total_online_charge'))
            ->first();
        return $payment_histories->total_commission_paid_amount - $payment_histories->total_online_charge;
    }
}

if (! function_exists('getTotalSaleAmountDateBetween')) {
    function getTotalSaleAmountDateBetween($id,$from_date, $to_date)
    {
        $sale_records = DB::table('sale_records')
            ->where('seller_user_id',$id)
            ->whereBetween('created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->select(DB::raw('SUM(amount) as total_sale'))
            ->first();
        return $sale_records->total_sale;
    }
}

if (! function_exists('getTotalCommissionAmountDateBetween')) {
    function getTotalCommissionAmountDateBetween($id,$from_date, $to_date)
    {
        $sale_records = DB::table('sale_records')
            ->where('seller_user_id',$id)
            ->whereBetween('created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->select(DB::raw('SUM(admin_commission) as total_admin_commission'))
            ->first();
        return $sale_records->total_admin_commission;
    }
}

if (! function_exists('getTotalCommissionPaidAmountDateBetween')) {
    function getTotalCommissionPaidAmountDateBetween($id,$from_date, $to_date)
    {
        $payment_histories = DB::table('payment_histories')
            ->where('user_id',$id)
            ->whereBetween('created_at', [$from_date." 00:00:00", $to_date." 23:59:59"])
            ->select(DB::raw('SUM(amount) as total_commission_paid_amount'),DB::raw('SUM(online_charge) as total_online_charge'))
            ->first();
        return $payment_histories->total_commission_paid_amount - $payment_histories->total_online_charge;
    }
}

if (! function_exists('getTotalCommissionPaidAmountAdmin')) {
    function getTotalCommissionPaidAmountAdmin()
    {
        $payment_histories = DB::table('payment_histories')
            ->select(DB::raw('SUM(amount) as total_commission_paid_amount'),DB::raw('SUM(online_charge) as total_online_charge'))
            ->first();
        return $payment_histories->total_commission_paid_amount - $payment_histories->total_online_charge;
    }
}

if (! function_exists('getProductRatingSellerGiven')) {
    function getProductRatingSellerGiven($id,$product_id)
    {
        return DB::table('reviews')
            ->where('sender_user_id',$id)
            ->where('product_id',$product_id)
            ->pluck('rating')
            ->first();
    }
}

if (! function_exists('getProductRatingBuyerGiven')) {
    function getProductRatingBuyerGiven($id,$product_id)
    {
        return DB::table('reviews')
            ->where('receiver_user_id',$id)
            ->where('product_id',$product_id)
            ->pluck('rating')
            ->first();
    }
}

if (! function_exists('getInvoiceWiseCommissionAmount')) {
    function getInvoiceWiseCommissionAmount($invoice_code)
    {
        return DB::table('sale_records')
            ->where('invoice_code',$invoice_code)
            ->pluck('admin_commission')
            ->first();
    }
}

if (! function_exists('getMembershipPackageAmount')) {
    function getMembershipPackageAmount($id)
    {
        $user = User::find(Auth::id());
        if ($user->membership_package_id == 2){
            $gold = \App\Model\MembershipPackage::find(2);
            $amount = DB::table('membership_packages')
                ->where('id',$id)
                ->pluck('price')
                ->first();
            return $amount- $gold->price;
        }else{
            return DB::table('membership_packages')
                ->where('id',$id)
                ->pluck('price')
                ->first();
        }

    }
}

if (! function_exists('checkUserType')) {
    function checkUserType($id)
    {
        return DB::table('users')
            ->where('id',$id)
            ->pluck('user_type')
            ->first();
    }
}

if (! function_exists('allCategoryPrint')) {
    function allCategoryPrint($product)
    {
        if(!empty($product->category_ten_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name. ' > ' . $product->subsubcategory->name. ' > ' . $product->subsubchildcategory->name. ' > ' . $product->subsubchildchildcategory->name. ' > ' . $product->categorySix->name. ' > ' .$product->categorySeven->name. ' > ' .$product->categoryEight->name. ' > ' .$product->categoryNine->name. ' > ' .$product->categoryTen->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory). ' > ' .
                getNameByBnEn($product->subsubcategory). ' > ' .
                getNameByBnEn($product->subsubchildcategory). ' > ' .
                getNameByBnEn($product->subsubchildchildcategory). ' > ' .
                getNameByBnEn($product->categorySix). ' > ' .
                getNameByBnEn($product->categorySeven). ' > ' .
                getNameByBnEn($product->categoryEight). ' > ' .
                getNameByBnEn($product->categoryNine). ' > ' .
                getNameByBnEn($product->categoryTen);
        }elseif (!empty($product->category_nine_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name. ' > ' . $product->subsubcategory->name. ' > ' . $product->subsubchildcategory->name. ' > ' . $product->subsubchildchildcategory->name. ' > ' . $product->categorySix->name. ' > ' .$product->categorySeven->name. ' > ' .$product->categoryEight->name. ' > ' .$product->categoryNine->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory). ' > ' .
                getNameByBnEn($product->subsubcategory). ' > ' .
                getNameByBnEn($product->subsubchildcategory). ' > ' .
                getNameByBnEn($product->subsubchildchildcategory). ' > ' .
                getNameByBnEn($product->categorySix). ' > ' .
                getNameByBnEn($product->categorySeven). ' > ' .
                getNameByBnEn($product->categoryEight). ' > ' .
                getNameByBnEn($product->categoryNine);
        }elseif(!empty($product->category_eight_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name. ' > ' . $product->subsubcategory->name. ' > ' . $product->subsubchildcategory->name. ' > ' . $product->subsubchildchildcategory->name. ' > ' . $product->categorySix->name. ' > ' .$product->categorySeven->name. ' > ' .$product->categoryEight->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory). ' > ' .
                getNameByBnEn($product->subsubcategory). ' > ' .
                getNameByBnEn($product->subsubchildcategory). ' > ' .
                getNameByBnEn($product->subsubchildchildcategory). ' > ' .
                getNameByBnEn($product->categorySix). ' > ' .
                getNameByBnEn($product->categorySeven). ' > ' .
                getNameByBnEn($product->categoryEight);

        }
        elseif(!empty($product->category_seven_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name. ' > ' . $product->subsubcategory->name. ' > ' . $product->subsubchildcategory->name. ' > ' . $product->subsubchildchildcategory->name. ' > ' . $product->categorySix->name. ' > ' .$product->categorySeven->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory). ' > ' .
                getNameByBnEn($product->subsubcategory). ' > ' .
                getNameByBnEn($product->subsubchildcategory). ' > ' .
                getNameByBnEn($product->subsubchildchildcategory). ' > ' .
                getNameByBnEn($product->categorySix). ' > ' .
                getNameByBnEn($product->categorySeven);

        }elseif (!empty($product->category_six_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name. ' > ' . $product->subsubcategory->name. ' > ' . $product->subsubchildcategory->name. ' > ' . $product->subsubchildchildcategory->name. ' > ' . $product->categorySix->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory). ' > ' .
                getNameByBnEn($product->subsubcategory). ' > ' .
                getNameByBnEn($product->subsubchildcategory). ' > ' .
                getNameByBnEn($product->subsubchildchildcategory). ' > ' .
                getNameByBnEn($product->categorySix);

        }elseif (!empty($product->sub_sub_child_child_category_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name. ' > ' . $product->subsubcategory->name. ' > ' . $product->subsubchildcategory->name. ' > ' . $product->subsubchildchildcategory->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory). ' > ' .
                getNameByBnEn($product->subsubcategory). ' > ' .
                getNameByBnEn($product->subsubchildcategory). ' > ' .
                getNameByBnEn($product->subsubchildchildcategory);

        }elseif (!empty($product->sub_sub_child_category_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name. ' > ' . $product->subsubcategory->name. ' > ' . $product->subsubchildcategory->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory). ' > ' .
                getNameByBnEn($product->subsubcategory). ' > ' .
                getNameByBnEn($product->subsubchildcategory);
        }elseif (!empty($product->sub_sub_category_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name. ' > ' . $product->subsubcategory->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory). ' > ' .
                getNameByBnEn($product->subsubcategory);

        }elseif (!empty($product->sub_category_id)){
//            $value = $product->category->name. ' > ' . $product->subcategory->name;
            $value = getNameByBnEn($product->category). ' > ' .
                getNameByBnEn($product->subcategory);

        }else{
//            $value = $product->category->name;
            $value = getNameByBnEn($product->category);
        }
        return $value;
    }
}

if (! function_exists('allCategoryForApi')) {
    function allCategoryForApi($data)
    {
        if(!empty($data->category_ten_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],
                [
                    'name' => 'sub_sub_category',
                    'id' => (integer) $data->sub_sub_category_id,
                    'value' => getNameByBnEn($data->subsubcategory),
                ],
                [
                    'name' => 'sub_sub_child_category',
                    'id' => (integer) $data->sub_sub_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildcategory),
                ],
                [
                    'name' => 'sub_sub_child_child_category',
                    'id' => (integer) $data->sub_sub_child_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildchildcategory),
                ],
                [
                    'name' => 'category_six',
                    'id' => (integer) $data->category_six_id,
                    'value' => getNameByBnEn($data->categorySix),
                ],
                [
                    'name' => 'category_seven',
                    'id' => (integer) $data->category_seven_id,
                    'value' => getNameByBnEn($data->categorySeven),
                ],
                [
                    'name' => 'category_eight',
                    'id' => (integer) $data->category_eight_id,
                    'value' => getNameByBnEn($data->categoryEight),
                ],
                [
                    'name' => 'category_nine',
                    'id' => (integer) $data->category_nine_id,
                    'value' => getNameByBnEn($data->categoryNine),
                ],
                [
                    'name' => 'category_ten',
                    'id' => (integer) $data->category_ten_id,
                    'value' => getNameByBnEn($data->categoryTen),
                ],

            ];
        }
        elseif(!empty($data->category_nine_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],
                [
                    'name' => 'sub_sub_category',
                    'id' => (integer) $data->sub_sub_category_id,
                    'value' => getNameByBnEn($data->subsubcategory),
                ],
                [
                    'name' => 'sub_sub_child_category',
                    'id' => (integer) $data->sub_sub_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildcategory),
                ],
                [
                    'name' => 'sub_sub_child_child_category',
                    'id' => (integer) $data->sub_sub_child_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildchildcategory),
                ],
                [
                    'name' => 'category_six',
                    'id' => (integer) $data->category_six_id,
                    'value' => getNameByBnEn($data->categorySix),
                ],
                [
                    'name' => 'category_seven',
                    'id' => (integer) $data->category_seven_id,
                    'value' => getNameByBnEn($data->categorySeven),
                ],
                [
                    'name' => 'category_eight',
                    'id' => (integer) $data->category_eight_id,
                    'value' => getNameByBnEn($data->categoryEight),
                ],
                [
                    'name' => 'category_nine',
                    'id' => (integer) $data->category_nine_id,
                    'value' => getNameByBnEn($data->categoryNine),
                ],
            ];
        }
        elseif(!empty($data->category_eight_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],
                [
                    'name' => 'sub_sub_category',
                    'id' => (integer) $data->sub_sub_category_id,
                    'value' => getNameByBnEn($data->subsubcategory),
                ],
                [
                    'name' => 'sub_sub_child_category',
                    'id' => (integer) $data->sub_sub_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildcategory),
                ],
                [
                    'name' => 'sub_sub_child_child_category',
                    'id' => (integer) $data->sub_sub_child_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildchildcategory),
                ],
                [
                    'name' => 'category_six',
                    'id' => (integer) $data->category_six_id,
                    'value' => getNameByBnEn($data->categorySix),
                ],
                [
                    'name' => 'category_seven',
                    'id' => (integer) $data->category_seven_id,
                    'value' => getNameByBnEn($data->categorySeven),
                ],
                [
                    'name' => 'category_eight',
                    'id' => (integer) $data->category_eight_id,
                    'value' => getNameByBnEn($data->categoryEight),
                ],
            ];
        }
        elseif(!empty($data->category_seven_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],
                [
                    'name' => 'sub_sub_category',
                    'id' => (integer) $data->sub_sub_category_id,
                    'value' => getNameByBnEn($data->subsubcategory),
                ],
                [
                    'name' => 'sub_sub_child_category',
                    'id' => (integer) $data->sub_sub_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildcategory),
                ],
                [
                    'name' => 'sub_sub_child_child_category',
                    'id' => (integer) $data->sub_sub_child_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildchildcategory),
                ],
                [
                    'name' => 'category_six',
                    'id' => (integer) $data->category_six_id,
                    'value' => getNameByBnEn($data->categorySix),
                ],
                [
                    'name' => 'category_seven',
                    'id' => (integer) $data->category_seven_id,
                    'value' => getNameByBnEn($data->categorySeven),
                ],
            ];
        }
        elseif(!empty($data->category_six_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],
                [
                    'name' => 'sub_sub_category',
                    'id' => (integer) $data->sub_sub_category_id,
                    'value' => getNameByBnEn($data->subsubcategory),
                ],
                [
                    'name' => 'sub_sub_child_category',
                    'id' => (integer) $data->sub_sub_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildcategory),
                ],
                [
                    'name' => 'sub_sub_child_child_category',
                    'id' => (integer) $data->sub_sub_child_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildchildcategory),
                ],
                [
                    'name' => 'category_six',
                    'id' => (integer) $data->category_six_id,
                    'value' => getNameByBnEn($data->categorySix),
                ],

            ];
        }
        elseif(!empty($data->sub_sub_child_child_category_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],
                [
                    'name' => 'sub_sub_category',
                    'id' => (integer) $data->sub_sub_category_id,
                    'value' => getNameByBnEn($data->subsubcategory),
                ],
                [
                    'name' => 'sub_sub_child_category',
                    'id' => (integer) $data->sub_sub_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildcategory),
                ],
                [
                    'name' => 'sub_sub_child_child_category',
                    'id' => (integer) $data->sub_sub_child_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildchildcategory),
                ],

            ];
        }
        elseif(!empty($data->sub_sub_child_category_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],
                [
                    'name' => 'sub_sub_category',
                    'id' => (integer) $data->sub_sub_category_id,
                    'value' => getNameByBnEn($data->subsubcategory),
                ],
                [
                    'name' => 'sub_sub_child_category',
                    'id' => (integer) $data->sub_sub_child_category_id,
                    'value' => getNameByBnEn($data->subsubchildcategory),
                ],

            ];
        }
        elseif(!empty($data->sub_sub_category_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],
                [
                    'name' => 'sub_sub_category',
                    'id' => (integer) $data->sub_sub_category_id,
                    'value' => getNameByBnEn($data->subsubcategory),
                ],
            ];
        }
        elseif(!empty($data->sub_category_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
                [
                    'name' => 'sub_category',
                    'id' => (integer) $data->sub_category_id,
                    'value' => getNameByBnEn($data->subcategory),
                ],

            ];
        }
        elseif(!empty($data->category_id)){
            $value = [
                [
                    'name' => 'category',
                    'id' => (integer) $data->category_id,
                    'value' => getNameByBnEn($data->category),
                ],
            ];
        }
        else{
            $value = null;
        }
        return $value;
    }
}

if (! function_exists('commissionValue')) {
    function commissionValue($id)
    {
        $commissionValue = \App\Model\MembershipPackageDetail::where('membership_package_id',$id)->first();
        return $commissionValue->commission;
    }
}

if (! function_exists('checkEmployeePic')) {
    function checkEmployeePic($user_id)
    {
        return \App\Model\Employee::where('user_id',$user_id)->pluck('employee_pic')->first();
    }
}

if (! function_exists('getSellerIdByUserId')) {
    function getSellerIdByUserId($user_id)
    {
        return \App\Model\Seller::where('user_id',$user_id)->pluck('id')->first();
    }
}

if (! function_exists('getEmployerIdByUserId')) {
    function getEmployerIdByUserId($user_id)
    {
        return \App\Model\Employer::where('user_id',$user_id)->pluck('id')->first();
    }
}

if (! function_exists('getEmployeeUserIdByEmployeeId')) {
    function getEmployeeUserIdByEmployeeId($id)
    {
        return \App\Model\Employee::where('id',$id)->pluck('user_id')->first();
    }
}

if (! function_exists('checkAlreadyShortlisted')) {
    function checkAlreadyShortlisted($employer_id, $employee_id)
    {
        return \App\Model\Shortlist::where('employer_id',$employer_id)->where('employee_id',$employee_id)->first();
    }
}

if (! function_exists('checkTotalFreeSMSSent')) {
    function checkTotalFreeSMSSent($id)
    {
        return \App\Model\Offer::where('sender_user_id',$id)
            ->where('message_charge_status','Free')
            ->groupBy('sender_user_id')
            ->selectRaw('sum(total_sms_sent) as sum_total_sms_sent')
            ->pluck('sum_total_sms_sent')
            ->first();
    }
}
if (! function_exists('totalFreeSMS')) {
    function totalFreeSMS($id)
    {
        $user = User::find($id);
        $totalFreeSMS = \App\Model\MembershipPackageDetail::where('membership_package_id',$user->membership_package_id)->pluck('free_sms')->first();
        return $totalFreeSMS;
    }
}
if (! function_exists('totalSMSSend')) {
    function totalSMSSend($id)
    {
        $message = \App\Model\Message::where('sender_user_id',$id)->where('offer_id','!=',null)->count();
        return $message;
    }
}
if (! function_exists('checkTotalChargeSMSSent')) {
    function checkTotalChargeSMSSent($id)
    {
        return \App\Model\Offer::where('sender_user_id',$id)
            ->where('message_charge_status','Charge Include')
            ->groupBy('sender_user_id')
            ->selectRaw('sum(total_sms_sent) as sum_total_sms_sent')
            ->pluck('sum_total_sms_sent')
            ->first();
    }
}

if (! function_exists('checkTotalCostSMS')) {
    function checkTotalCostSMS($id)
    {
        return \App\Model\Offer::where('sender_user_id',$id)
            ->groupBy('sender_user_id')
            ->selectRaw('sum(total_cost_sms) as sum_total_cost_sms')
            ->pluck('sum_total_cost_sms')
            ->first();
    }
}

if (! function_exists('checkTotalFreeSMSLimit')) {
    function checkTotalFreeSMSLimit($id,$membership_package_id)
    {
        return \App\Model\MembershipPackageDetail::join('users','membership_package_details.membership_package_id','users.membership_package_id')
            ->where('users.id',$id)
            ->where('users.membership_package_id',$membership_package_id)
            ->pluck('membership_package_details.free_sms')
            ->first();
    }
}

if (! function_exists('checkTotalSmsCostSentAmount')) {
    function checkTotalSmsCostSentAmount($id)
    {
        return \App\Model\SmsCostPaymentHistory::where('user_id',$id)
            ->where('payment_status','Paid')
            ->groupBy('user_id')
            ->selectRaw('sum(amount) as sum_total_amount')
            ->pluck('sum_total_amount')
            ->first();
    }
}

if (! function_exists('checkTotalSmsCostSentAmountOnlineCharge')) {
    function checkTotalSmsCostSentAmountOnlineCharge($id)
    {
        return \App\Model\SmsCostPaymentHistory::where('user_id',$id)
            ->where('payment_status','Paid')
            ->groupBy('user_id')
            ->selectRaw('sum(online_charge) as sum_total_online_charge_amount')
            ->pluck('sum_total_online_charge_amount')
            ->first();
    }
}

if (! function_exists('checkSellerCurrentCommissionDueStatus')) {
    function checkSellerCurrentCommissionDueStatus($id)
    {
        return \App\Model\SaleRecord::where('seller_user_id',$id)
            ->where('payment_status','Pending')
            ->get();
    }

    if (! function_exists('returnDates')) {
        function returnDates($fromdate, $todate)
        {
            $fromdate = \DateTime::createFromFormat('Y-m-d', $fromdate);
            $todate = \DateTime::createFromFormat('Y-m-d', $todate);
            return new \DatePeriod(
                $fromdate,
                new \DateInterval('P1D'),
                $todate->modify('+1 day')
            );
        }
    }

    function send_mailjet_mail()
    {
        $mj = new \Mailjet\Client('f5865d79ae66a5f2161f1f38d2de3c59', 'fed576498b5b43492cfe1626bfa42b00', true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "sayka.starit@gmail.com",
                        'Name' => "Robeul Islam"
                    ],
                    'To' => [
                        [
                            'Email' => "sayka.starit@gmail.com",
                            'Name' => "Sayka Islam"
                        ]
                    ],
                    'Subject' => "Welcome To Fabric Lagbe",
                    'TextPart' => "",
                    'HTMLPart' => "<h3>Dear User,<br /> welcome to <a href='https://www.fabriclagbe.com/'>fabriclagbe.com</a>!</h3><br /><b>Your OTP is 1234.</b> <br/>
            <br/>
            <p> Best Regards</p>
            <p> Team, Fabric Lagbe LTD </p>",
                    'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];

        $response = $mj->post(\Mailjet\Resources::$Email, ['body' => $body]);
//        $response->success() && var_dump($response->getData());
    }
    function send_mailjet_mail1($receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
    {
        //Nstar
        $mj = new \Mailjet\Client('4694fdc13b0f5010df585524e8069170', '969ce1dee8bad3e174317febc6df7507', true, ['version' => 'v3.1']);

        //Sayka
//       $mj = new \Mailjet\Client('f5865d79ae66a5f2161f1f38d2de3c59', 'fed576498b5b43492cfe1626bfa42b00', true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $sender_email,
                        'Name' => $sender_name,
                    ],
                    'To' => [
                        [
                            'Email' => $receiver_email,
                            'Name' => $receiver_name,
                        ]
                    ],
                    'Subject' => $subject,
                    'TextPart' => "",
                    'HTMLPart' => $message,
                ]
            ]
        ];
        $response = $mj->post(\Mailjet\Resources::$Email, ['body' => $body]);
    }
}

