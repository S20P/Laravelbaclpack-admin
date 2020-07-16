<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Requests\AnalyticsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;
use App\Models\Supplier;
use Response;
use App\Models\Supplier_services;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Http\Request;

/**
 * Class AnalyticsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AnalyticsReportController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/reports/analytics');
        $this->crud->setEntityNameStrings('analytics Report', 'analytics Report');
    }

    private $AnalyticsAPI;

    public function __construct(AnalyticsController $AnalyticsAPI)
    {
       $this->AnalyticsAPI = $AnalyticsAPI;
    }

    protected function dashbord(){

           $this->data['crud'] = $this->crud; 
          // return view('crud::IndustryStatsReport',$this->data);

        $Supplier = Supplier::select('id','name')->get();
     
        $this->data['Supplier'] = $Supplier;
      
        return view('crud::Reports.AnalyticsReport',$this->data);
    }



 public function AnalyticsDetailsBySupplierAjex(Request $request,$supplier_id=null)
    {


     $html = "";
        if($supplier_id!=null){

  $Supplier_services = Supplier_services::where('supplier_id',$supplier_id)->get();
    
        $supplier_services_impressions = [];
        $supplier_services_clicks_view = [];
        $supplier_services_photo_view = [];
        $supplier_services_inquirey = [];
        $supplier_services_mobile_view = [];
        $supplier_services_email_view = [];
        $supplier_services_viewed_photos = [];
       
        if(count($Supplier_services)){            

            foreach($Supplier_services as $assign_service){
            //    Analytics--------------------------------------------------------------------------------------------------
                    
                    $supplier_services_id =  $assign_service->id;

                    // impressions
                    $impressions = $this->AnalyticsAPI->get_analytics_filter("impressions",$supplier_services_id);
                    if(count($impressions)){
                    $total_impressions =  count($impressions);
                    }else{
                        $total_impressions = 0;
                    }  

                    array_push($supplier_services_impressions,$total_impressions);

                    //clicks----------------------------

                    $clicks = $this->AnalyticsAPI->get_analytics_filter("clicks_view",$supplier_services_id);
                    if(count($clicks)){
                    $total_clicks =  count($clicks);
                    }else{
                        $total_clicks = 0;
                    }  
                    array_push($supplier_services_clicks_view,$total_clicks);

                    
                    //Most viewed photo-------------------

                    $photo_view = $this->AnalyticsAPI->get_analytics_filter("photo_view",$supplier_services_id);

                    $total_viewed_photo = 0;

                    if(count($photo_view)){
                        

                        $supplier_services_details =  DB::table('supplier_services')
                        ->join('analytics', 'supplier_services.id', '=', 'analytics.supplier_services_id')  
                        ->join('customer_profile', 'analytics.customer_id', '=', 'customer_profile.id')  
                        ->join('supplier_assign_events', 'supplier_services.id', '=', 'supplier_assign_events.supplier_services_id')                                        
                        ->join('events', 'supplier_assign_events.event_id', '=', 'events.id')
                        ->join('services', 'services.id', '=', 'supplier_services.service_id')
                        ->where('supplier_services.id',$supplier_services_id)
                        ->select('services.name as services_name','customer_profile.name as customer_name','events.name as event_name')
                        ->first(); 
                         
                         $services_name = "";
                         $customer_name = "";
                         $event_name = "";

                         if($supplier_services_details){
                            $services_name = $supplier_services_details->services_name;
                            $customer_name = $supplier_services_details->customer_name;
                            $event_name = $supplier_services_details->event_name;
                         }
                         $total_viewed_photo = count($photo_view);
                       
                        
                        $key = "slug";
                        $temp_array = array();
                        $i = 0;
                        $key_array = array();
                        foreach($photo_view  as $val) {
                            $count = $i  + 1;
                            if (!in_array($val->$key, $key_array)) {
                                
                                $key_array[$i] = $val->$key;
                                $temp_array[$i] = $val;
                                $photo_view_element = [
                                                "count" => $count,
                                                "image_url" => $val->image_url,
                                                "customer_name" => $customer_name,
                                                "services_name" => $services_name,
                                                "event_name" => $event_name
                                             ];
                                array_push($supplier_services_viewed_photos,$photo_view_element);
                            } 
                            
                            $i++;
                        }   
                                             
                      
                    }else{
                        $total_viewed_photo = 0;
                    }
                    
                    array_push($supplier_services_photo_view,$total_viewed_photo);

                    //enquiries---------------------------

                    $enquiries = DB::table('customers_inquiry')->where('supplier_services_id',$supplier_services_id)->get()->unique('customer_id');
                    if(count($enquiries)){
                        $total_enquiries =  count($enquiries);
                    }else{
                        $total_enquiries = 0;
                    }
                    
                    array_push($supplier_services_inquirey,$total_enquiries);

                    //mobile_view

                    $mobile_view = $this->AnalyticsAPI->get_analytics_filter("mobile_view",$supplier_services_id);
                    if(count($mobile_view)){
                        $total_viewed_mobile =  count($mobile_view);
                    }else{
                        $total_viewed_mobile = 0;
                    }

                    array_push($supplier_services_mobile_view,$total_viewed_mobile);

                    //email_view 
                    $email_view = $this->AnalyticsAPI->get_analytics_filter("email_view",$supplier_services_id);
                    if(count($email_view)){
                        $total_viewed_email =  count($email_view);
                    }else{
                        $total_viewed_email = 0;
                    }
                    array_push($supplier_services_email_view,$total_viewed_email);
                  
                //    Analytics end--------------------------------------------------------------------------------------------------
        }
    }

    $Analytic_record = [
        "total_impressions"=> array_sum($supplier_services_impressions),
        "total_clicks"=>array_sum( $supplier_services_clicks_view),
        "total_viewed_photo"=>array_sum($supplier_services_photo_view),
        "total_enquiries"=>array_sum($supplier_services_inquirey),
        "total_viewed_mobile"=>array_sum($supplier_services_mobile_view),
        "total_viewed_email"=>array_sum($supplier_services_email_view),
        "supplier_services_viewed_photos" =>$supplier_services_viewed_photos
        ];


              return response()->json(["success" => true, "html" => $Analytic_record]);    
    }
        
 return response()->json(["success" => false, "html" => $html]); 


    }
       

 


}
