<?php

namespace App\Http\Controllers\Admin;


use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Services;
use App\Models\Location;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Supplier_services;
use App\Models\PriceRange;



/**
 * Class Analytic_emailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class IndustryStatsReportController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/reports/industry_stats_report');
        $this->crud->setEntityNameStrings('Industry stats Reports', 'Industry stats Reports');
    }
    protected function dashbord(){
           $this->data['crud'] = $this->crud; 
          // return view('crud::IndustryStatsReport',$this->data);

        $PriceRange = PriceRange::select('range','symbol','status')->get();
        $locations = Location::select('id','location_name')->get();
        $this->data['PriceRange'] = $PriceRange;
        $this->data['locations'] = $locations;
        return view('crud::Reports.IndustryStatsReport',$this->data);
    }

     public function generate_report(Request $request)
    {
        $report_type = $request->report_type;
        $report_by = $request->report_by;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

    $html = "";
    if($report_type!=null && $report_by!=null){

            //<--reportQ1 code start--->

           if($report_type=="reportQ1"){
                if($report_by=="location"){
                    $countSuppliersBylocation = $this->countSuppliersBylocation($start_date,$end_date);
                    $html = $countSuppliersBylocation;            
                }
                if($report_by=="price"){
                    $countSuppliersByprice = $this->countSuppliersByprice($start_date,$end_date);
                       $html = $countSuppliersByprice; 
                 }
           }
            //<--reportQ1 code end--->


            //<--reportQ2 code start--->

            if($report_type=="reportQ2"){
                if($report_by=="location"){
                    $countBylocation = $this->countViewedBylocation($start_date,$end_date);
                    $html = $countBylocation;            
                    }                    
                if($report_by=="price"){
                        $countByprice = $this->countViewedByprice($start_date,$end_date);
                        $html = $countByprice;          
                    }
             }           
            //<--reportQ2 code end--->


            
            //<--reportQ3 code start--->

            if($report_type=="reportQ3"){
               
               if($report_by=="location"){
                    $countBylocation = $this->countServiceContactedBylocation($start_date,$end_date);
                    $html = $countBylocation;            
                    }                    
                if($report_by=="price"){
                    $countByprice = $this->countServiceContactedByprice($start_date,$end_date);
                    $html = $countByprice;          
                    }
          }
            //<--reportQ3 code end--->


            //<--reportQ4 code start--->

            if($report_type=="reportQ4"){
                if($report_by=="location"){
                    $countBylocation = $this->countServiceBookedBylocation($start_date,$end_date);
                    $html = $countBylocation;            
                }
                if($report_by=="price"){
                    $countByprice = $this->countServiceBookedByprice($start_date,$end_date);
                    $html = $countByprice;          
                }
           }

               return response()->json(["success" => true, "html" => $html]); 

            //<--reportQ4 code end--->                  
      }
          return response()->json(["success" => false, "html" => $html]);    
    }
  

       //<--reportQ1 functions start--->

    public function countSuppliersByprice($start_date,$end_date){

       $supplierWidget = '<p>The number of supplier by Price type on PP.</p>';
        $PriceRange = PriceRange::get();
        foreach($PriceRange as $range){

            $status = $range->status;
            $symbol = $range->symbol;
            $range =  $range->range;

        $countSuppliers = DB::table('supplier_services')
                            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                             ->where('supplier_services.price_range',$status);
           
        if($start_date !=null && $end_date !=null){
            $countSuppliers->whereBetween('supplier_services.created_at',[$start_date,$end_date]);
        }
        elseif ($start_date !=null) {
            $countSuppliers->where('supplier_services.created_at','>=',$start_date);
        }elseif ($end_date !=null) {
            $countSuppliers->where('supplier_services.created_at','<=',$end_date);
        }
      
        $countSuppliers =  $countSuppliers->count();       

        $supplierWidget .= '<div><b>'.$symbol." - ".$range." price".'</b>:'.$countSuppliers.'</div> <br/>';
        
        }
        return $supplierWidget;


    }

    public function countSuppliersBylocation($start_date,$end_date){
        $supplierWidget = '<p>The number of supplier by Location type on PP.</p>';
    
      $locations = Location::get();
      foreach($locations as $location){
                    $location_id = $location->id;
                    $location_name = $location->location_name;

                $countSuppliers = DB::table('supplier_services')
                                        ->where([['location','like','%'.$location_id.'%']]);                                        
                if($start_date !=null && $end_date !=null){
                    $countSuppliers->whereBetween('created_at',[$start_date,$end_date]);
                }
                elseif ($start_date !=null) {
                    $countSuppliers->where('created_at','>=',$start_date);
                }elseif ($end_date !=null) {
                    $countSuppliers->where('created_at','<=',$end_date);
                }
                $countSuppliers =  $countSuppliers->distinct('supplier_id')->count();

                $supplierWidget .= '<div><b>'.$location_name.'</b>:'.$countSuppliers.'</div> <br/>';
        }
        return $supplierWidget;
    }

   //<--reportQ1 functions end--->



   //<--reportQ2 functions start--->

        public function countViewedBylocation($start_date,$end_date){

        $supplierWidget = '<p>The number of people viewed a Supplier Type by Location type on PP.</p>';
        $locations = Location::get();
        foreach($locations as $location){
            $location_id = $location->id;
            $location_name = $location->location_name;
          
             $TotalViewedSupplierByLocation = [];
    
    $supplierServicesList = Supplier_services::select('id','location')->get();    

               if(count($supplierServicesList))
                 {
                for($i=0;$i<count($supplierServicesList);$i++)
                   {
                     $locations = $supplierServicesList[$i]->location;
                     $analytics = [];
                        foreach($locations as $location)
                            {
                                if($location==$location_id)
                                    {
                                    $count_service_viewed = DB::table('analytics')
                                                        ->where('supplier_services_id',$supplierServicesList[$i]->id)
                                                        ->where('analytics_event_type',"clicks_view");

                                    if($start_date !=null && $end_date !=null){
                                        $count_service_viewed->whereBetween('created_at',[$start_date,$end_date]);
                                    }
                                    elseif ($start_date !=null) {
                                        $count_service_viewed->where('created_at','>=',$start_date);
                                    }elseif ($end_date !=null) {
                                        $count_service_viewed->where('created_at','<=',$end_date);
                                    }
                                   $total_analytics =  $count_service_viewed->distinct('customer_id')->count();

                                          array_push($TotalViewedSupplierByLocation, $total_analytics);
                                    }  
                            }
                }
            }

        $countSuppliers =array_sum($TotalViewedSupplierByLocation);
        $supplierWidget .= '<div><b>'.$location_name.'</b>:'.$countSuppliers.'</div> <br/>';
        }
        return $supplierWidget;
    }

      public function countViewedByprice($start_date,$end_date){
        $supplierWidget = '<p>The number of people viewed a Supplier Type by Price type on PP.</p>';
        $PriceRange = PriceRange::get();
        foreach($PriceRange as $range){

            $status = $range->status;
            $symbol = $range->symbol;
            $range =  $range->range;

        $count_service_viewed = DB::table('supplier_services')
                            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                            ->join('analytics', 'supplier_services.id', '=', 'analytics.supplier_services_id')
                             ->where('analytics.analytics_event_type',"clicks_view")
                             ->where('supplier_services.price_range',$status);
           
         if($start_date !=null && $end_date !=null){
                                        $count_service_viewed->whereBetween('supplier_services.created_at',[$start_date,$end_date]);
                                    }
                                    elseif ($start_date !=null) {
                                        $count_service_viewed->where('supplier_services/created_at','>=',$start_date);
                                    }elseif ($end_date !=null) {
                                        $count_service_viewed->where('supplier_services.created_at','<=',$end_date);
                                    }
                                   $count_service_viewed =  $count_service_viewed->distinct('analytics.customer_id')->count();
      
              

        $supplierWidget .= '<div><b>'.$symbol." - ".$range." price".'</b>:'.$count_service_viewed.'</div> <br/>';
        
        }
        return $supplierWidget;
    }


   //<--reportQ2 functions end--->

  

   //<--reportQ3 functions start--->

        public function countServiceContactedBylocation($start_date,$end_date){

             
        $supplierWidget = '<p>The number of people Contacted a Supplier Type by Location type on PP.</p>';

    
      $locations = Location::get();
      foreach($locations as $location){
                    $location_id = $location->id;
                    $location_name = $location->location_name;
        $count_service_connected = DB::table('supplier_services')
                                ->join('customers_inquiry', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
                                ->where('customers_inquiry.status',0)
                                ->where([['supplier_services.location','like','%'.$location_id.'%']]);
        
        if($start_date !=null && $end_date !=null){
            $count_service_connected->whereBetween('customers_inquiry.created_at',[$start_date,$end_date]);
        }
        elseif ($start_date !=null) {
            $count_service_connected->where('customers_inquiry.created_at','>=',$start_date);
        }elseif ($end_date !=null) {
            $count_service_connected->where('customers_inquiry.created_at','<=',$end_date);
        }
        $countSuppliers =  $count_service_connected->count(); 
        
                $supplierWidget .= '<div><b>'.$location_name.'</b>:'.$countSuppliers.'</div> <br/>';
        }
        return $supplierWidget;                       

    }

          public function countServiceContactedByprice($start_date,$end_date){
                $supplierWidget = '<p>The number of people Contacted a Supplier Type by Price type on PP.</p>';

    $PriceRange = PriceRange::get();
        foreach($PriceRange as $range){

            $status = $range->status;
            $symbol = $range->symbol;
            $range =  $range->range;

        $count_service_connected = DB::table('supplier_services')
                                ->join('customers_inquiry', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
                                ->where('customers_inquiry.status',0)
                                ->where('supplier_services.price_range',$status);
        if($start_date !=null && $end_date !=null){
            $count_service_connected->whereBetween('customers_inquiry.created_at',[$start_date,$end_date]);
        }
        elseif ($start_date !=null) {
            $count_service_connected->where('customers_inquiry.created_at','>=',$start_date);
        }elseif ($end_date !=null) {
            $count_service_connected->where('customers_inquiry.created_at','<=',$end_date);
        }
        $countSuppliers =  $count_service_connected->count(); 
        
               
  $supplierWidget .= '<div><b>'.$symbol." - ".$range." price".'</b>:'.$countSuppliers.'</div> <br/>';
        }
        return $supplierWidget;            

    }

    
   //<--reportQ3 functions end--->



    //<--reportQ4 functions start--->

      public function countServiceBookedBylocation($start_date,$end_date){

           $supplierWidget = '<p>The number of people Booked a Supplier Type by Location type on PP.</p>';

    
      $locations = Location::get();
      foreach($locations as $location){
                    $location_id = $location->id;
                    $location_name = $location->location_name;

         $count_service_booked = DB::table('supplier_services')
                    ->join('booking', 'supplier_services.id', '=', 'booking.supplier_services_id')
                    ->where('booking.status',1)
                    ->where([['supplier_services.location','like','%'.$location_id.'%']]);

   if($start_date !=null && $end_date !=null){
            $count_service_booked->whereBetween('booking.booking_date',[$start_date,$end_date]);
        }
        elseif ($start_date !=null) {
            $count_service_booked->where('booking.booking_date','>=',$start_date);
        }elseif ($end_date !=null) {
            $count_service_booked->where('booking.booking_date','<=',$end_date);
        }
        
         $count_service_booked =  $count_service_booked->count(); 
        
                $supplierWidget .= '<div><b>'.$location_name.'</b>:'.$count_service_booked.'</div> <br/>';
        }
        return $supplierWidget;                    

    }

          public function countServiceBookedByprice($start_date,$end_date){
              $supplierWidget = '<p>The number of people Booked a Supplier Type by Price type on PP.</p>';

    $PriceRange = PriceRange::get();
        foreach($PriceRange as $range){

            $status = $range->status;
            $symbol = $range->symbol;
            $range =  $range->range;
          $count_service_booked = DB::table('supplier_services')
                    ->join('booking', 'supplier_services.id', '=', 'booking.supplier_services_id')
                    ->where('booking.status',1)
                    ->where('supplier_services.price_range',$status);
                       
       if($start_date !=null && $end_date !=null){
            $count_service_booked->whereBetween('booking.booking_date',[$start_date,$end_date]);
        }
        elseif ($start_date !=null) {
            $count_service_booked->where('booking.booking_date','>=',$start_date);
        }elseif ($end_date !=null) {
            $count_service_booked->where('booking.booking_date','<=',$end_date);
        }
        $count_service_booked =  $count_service_booked->count();

        $supplierWidget .= '<div><b>'.$symbol." - ".$range." price".'</b>:'.$count_service_booked.'</div> <br/>';
        }
        return $supplierWidget;    


    }


    
   //<--reportQ4 functions end--->


}
