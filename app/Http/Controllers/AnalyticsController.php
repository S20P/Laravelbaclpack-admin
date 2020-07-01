<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class AnalyticsController extends Controller
{


    //analytics  formate demo

        //    [ "customer_id"=>"0",
               //     "analytics_event_type"=>["impressions","photo_view","mobile_view","email_view","message_view","page_view"],
        //     "image_url"=>"image_url",
        //     "page_name"=>"page_name",
        //     "page_url"=>"page_url",
        //     "created_at" => date('Y-m-d H:i:s'), 
        //     "updated_at" => date('Y-m-d H:i:s'), ]


//-------------------------------------------------------------------------------------------------------------------------------

    public function get_analytics()
    {
        $Analytics = DB::table("analytics")->get();
        return $Analytics;
    }

    public function get_analytics_filter($analytics_event_type=null,$supplier_services_id=null)
    {   
        $Analytics = DB::table("analytics")->where('supplier_services_id',$supplier_services_id)->where('analytics_event_type',$analytics_event_type)->get();
        return $Analytics;
    }

    public function create_analytics(Request $request)
    {
        $customer_id = $request->customer_id;
        $supplier_services_id = $request->supplier_services_id;
        $analytics_event_type = $request->analytics_event_type;
        $slug = $request->slug;
        $image_url = $request->image_url;
        $browser_session = $request->browser_session;

      
        
        $check_session = DB::table("analytics")->where('supplier_services_id',$supplier_services_id)->where('analytics_event_type',$analytics_event_type)->where('browser_session',$browser_session)->where('slug',$slug)->first();
      
        if(!$check_session || $check_session==null){
        $Analytics = DB::table("analytics")->insert([
            "customer_id"=>$customer_id,
            "supplier_services_id"=>$supplier_services_id,
            "slug"=>$slug,
            "analytics_event_type"=>$analytics_event_type,
            "image_url"=>$image_url,
            "browser_session"=>$browser_session,
            "date"=>date('Y-m-d'),
            "created_at" => date('Y-m-d H:i:s'), 
            "updated_at" => date('Y-m-d H:i:s'), 
        ]);
        }else{
            if($customer_id!=="null"){
            DB::table("analytics")->where('analytics_event_type',$analytics_event_type)->where('browser_session',$browser_session)->where('slug',$slug)->update([
                "customer_id"=>$customer_id,
            ]);
            }   
        } 
    }
    public function createSearchAnalytics(Request $request){
       $customer_id = $request->customer_id;
       $service_id = $request->service_id;
       $event_id = $request->event_id;
       $location_id = $request->location_id;  
       $browser_session = $request->browser_session;
       $check_session = DB::table("search_analytics")->where('service_id',$service_id)->where('event_id',$event_id)->where('location_id',$location_id)->where('browser_session',$browser_session)->first();
        if($service_id != "" || $event_id != "" || $location_id != "")
        {
            if(!$check_session || $check_session==null){
                $Analytics = DB::table("search_analytics")->insert([
                    "customer_id"=>$customer_id,
                    "service_id"=>$service_id,
                    "event_id"=>$event_id,
                    "location_id"=>$location_id,
                    "date"=>date('Y-m-d'),
                    "browser_session"=>$browser_session,
                    "created_at" => date('Y-m-d H:i:s'), 
                    "updated_at" => date('Y-m-d H:i:s'), 
                ]);
            }else{
                if($customer_id!=="null"){
                    DB::table("search_analytics")->where('browser_session',$browser_session)->update([
                        "customer_id"=>$customer_id,
                    ]);
                }   
            }
        }
    }
}
