<?php 
use
    Illuminate\Support\Facades\DB;
use App\Models\Location;
use App\Models\Events;
use App\Models\Services;
use App\Mail\TestEmail;

if (! function_exists('wishExist')) {
    function wishExist($supplier_services_id=null,$user_id=null) {
    	 if( \Auth::guard('customer')){

             $w_id = DB::table('customers_wishlist')->where('supplier_services_id',$supplier_services_id)->where('customer_id',$user_id)->where('status',1)->first();
             if($w_id != null){
             	return "wishlist-active";
             }
             else
             {
             	return "";
             }
        	// return true;
        }else{
            return "";
        }
    	// dd($supplier_id);
      // return $key;
    }
}
if (! function_exists('wishExistDetails')) {
    function wishExistDetails($supplier_services_id=null,$user_id=null) {
        if( \Auth::guard('customer')){

            $w_id = DB::table('customers_wishlist')->where('supplier_services_id',$supplier_services_id)->where('customer_id',$user_id)->where('status',1)->first();
            if($w_id != null){
                return "wishlist-active";
            }
            else
            {
                return "";
            }
            // return true;
        }else{
            return "";
        }
        // dd($supplier_id);
        // return $key;
    }
}
if (! function_exists('displayMessages')) {
    function displayMessages($supplier_service_id=null,$customer_id=null) {
        return $selmessages =  DB::table('supplier_services')
            ->join('customers_inquiry', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
            ->where('customers_inquiry.supplier_services_id',$supplier_service_id)
            ->where('customers_inquiry.customer_id',$customer_id)
            ->orderBy('customers_inquiry.id','asc')->get()->toArray();
    }
}
if (! function_exists('getLocations')) {
    function getLocations() {
        return $getLocations = Location::get();
    }
}
if (! function_exists('getEventList')) {
    function getEventList() {
        return $getEventList = Events::get();
    }
}
if (! function_exists('getServiceList')) {
    function getServiceList() {
        return $getServiceList = Services::get();
    }
}
if (! function_exists('getFooterDetails')) {
    function getFooterDetails() {
        return DB::table('site_details')->first();
    }
}
if (! function_exists('getSocialDetails')) {
    function getSocialDetails() {
        return DB::table('social_media_module')->get()->toArray();
    }
}
if (! function_exists('getEvents')) {
    function getEvents() {
        return Events::limit(4)->get()->toArray();
    }
}
if (! function_exists('getServices')) {
    function getServices() {
        return Services::limit(4)->get()->toArray();
    }
}
if (! function_exists('getEventsById')) {
    function getEventsById($id) {
        if($id != ''){
            return Services::where('id',$id)->first()->toArray();
        }else{
            return '';
        }

    }
}
if (! function_exists('getRatings')) {
    function getRatings($supplier_service_id) {
        $count = DB::table('supplier_reviews')
            ->where('supplier_services_id',$supplier_service_id)
            ->where('status',1)
            ->count();
        $sum = DB::table('supplier_reviews')
            ->where('supplier_services_id',$supplier_service_id)
            ->where('status',1)
            ->sum('rates');
        if($sum != 0){
            $supplier_rates = $sum/$count;
            return $supplier_rate = round($supplier_rates);
        }else{
            return 0;
        }
    }
}
// if (! function_exists('getPricerange')) {
//     function getPricerange($price) {
//         $price_range = DB::table('category_price_tiers')->first();
//         if($price <= $price_range->low_price_range){
//             return 1;
//         }elseif ($price <= $price_range->medium_price_range){
//             return 2;
//         }elseif ($price <= $price_range->high_price_range){
//             return 3;
//         }
//     }
// }

if (! function_exists('getLocationName')) {
    function getLocationName($loc_id) {
        $loc_ids =  (int) $loc_id;
        $location_name = Location::where('id',$loc_id)->first();
        return $location_name->location_name;
    }
}
if (! function_exists('getEventName')) {
    function getEventName($event_id) {
        $event_ids =  (int) $event_id;
        $event_name = Events::where('id',$event_ids)->first();
        return $event_name->name;
    }
}


function rudr_instagram_api_curl_connect( $api_url ){
	$connection_c = curl_init(); // initializing
	curl_setopt( $connection_c, CURLOPT_URL, $api_url ); // API URL to connect
	curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
	curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
	$json_return = curl_exec( $connection_c ); // connect and get json data
	curl_close( $connection_c ); // close connection
	return json_decode( $json_return ); // decode and return
}

function get_instagram(){
	$site = getFooterDetails();
    $result = array();

    
     /*
    * @Author: Satish parmar
    */
  
    // $access_token = "3164004994.aff5dfd.6b455858ac8d4d5c8d3e86eb591dfa49";
    // $user_id = 3164004994;
    // $url = "https://graph.instagram.com/me/media?fields=id,caption&access_token=".$access_token;
    // $jsonData = json_decode((file_get_contents($url)));

    //  dd($jsonData);

    //@Author: Satish parmar end Code


  //  $url = 'https://api.instagram.com/v1/users/'.$site->instagram_user_id.'/media/recent/?access_token='.$site->instagram_secret.'&count='.$site->number_of_feeds;
    // Also Perhaps you should cache the results as the instagram API is slow
  


    // $cache = './'.sha1($url).'.json';
    // if(file_exists($cache) && filemtime($cache) > time() - 60*60){
    //     // If a cache file exists, and it is newer than 1 hour, use it
    //     $jsonData = json_decode(file_get_contents($cache));
    // } else {
      
    //     if(file_get_contents($url)){
    //     $jsonData = json_decode((file_get_contents($url)));
    //     }
    // }
    
  
    // foreach ($jsonData->data as $key=>$value) {
    //     $result[$key]['image'] = $value->images->low_resolution->url;
    //     $result[$key]['link'] = $value->link;
    // }
    return $result;


  

    



}
/**
* @author:Mitesh
* Common send mail function :
*/ 
if (! function_exists('send_mail')) {
    function send_mail($to_email,$to_name,$subject,$view_params = array(),$view_name,$attach_data = null,$attachFileName = null) {
        $data = array(
        'subject' => $subject,
        'view_name' => $view_name,
        'message' => $view_params,
        'attach_data' => $attach_data,
        'attach_name' => $attachFileName,
        );
        if($attach_data != ''){
            Mail::to($to_email,$to_name)->send(new TestEmail($data));
        } else {
            Mail::to($to_email,$to_name)->send(new TestEmail($data));
        }
    }
}

    /*
    * @Author: Satish Parmar
    * @ purpose: This function use for send mail template for dynamic data and manage by admin to save content to database.
    */
if (! function_exists('send_mail_dynamic')) {
    function send_mail_dynamic($to_mail,$to_name=null,$template,$view_params,$attach_data = null,$attachFileName = null) {
        Mail::send([], [], function($message) use ($to_mail,$to_name,$template,$view_params,$attach_data,$attachFileName)
        {
            $data = $view_params;

            if($attach_data != ''){
                $message->to($to_mail, $to_name)->attachData($attach_data, $attachFileName)
                ->subject($template->parseSubject($data),'text/html')
                ->setBody($template->parse($data),'text/html');
            } else {
                $message->to($to_mail, $to_name)
                ->subject($template->parseSubject($data),'text/html')
                ->setBody($template->parse($data),'text/html');
            }
        });
    }
}

 //  @author:Satish Parmar EndCode


    /*
    * @Author: Satish parmar
    * @ purpose: Image size compress in php
    * @params:
    * source_url,
    * destination_url,
    * quality : 40,
    */

    if (! function_exists('compress_image')) {

        function compress_image($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg') 
        {
            $image = imagecreatefromjpeg($source_url);
        }
        elseif ($info['mime'] == 'image/gif') 
        {
            $image = imagecreatefromgif($source_url);
        }
        elseif ($info['mime'] == 'image/png') 
        {
            $image = imagecreatefrompng($source_url);
            imagepng($image1, $destination_url, 5);
        }
        if(isset($image)){
            imagejpeg($image, $destination_url, $quality);
        }
        return $destination_url;
    }

    }
    //@Author: Satish parmar end Code
