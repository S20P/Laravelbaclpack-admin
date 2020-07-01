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
        $most_viewed_image = [];
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
                    if(count($photo_view)){
                        $total_viewed_photo =  count($photo_view);
                        $viewed_image_url = $photo_view[0]->image_url;
                    array_push($most_viewed_image,$viewed_image_url);

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
        "most_viewed_image"=>$most_viewed_image[0]
        ];


              return response()->json(["success" => true, "html" => $Analytic_record]);    
    }
        
 return response()->json(["success" => false, "html" => $html]); 


    }
       

 


}
