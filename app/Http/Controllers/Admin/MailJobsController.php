<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Supplier_services;
use App\Models\Services;
use App\Models\Location;
use Mail;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class MailJobsController extends Controller
{
	// private  $admin_mail;
    public function reportSend(Request $request)
    {
    	$service_id = $request->service;
    	$location_id = $request->location;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
    	$countServiceByLocation = $this->countServiceByLocation($service_id,$location_id,$start_date,$end_date);
    	$countServiceContacted = $this->countServiceContacted($service_id,$location_id,$start_date,$end_date);
    	$countServiceBooked = $this->countServiceBooked($service_id,$location_id,$start_date,$end_date);
        $countServiceSearch = $this->countServiceSearch($service_id,$location_id,$start_date,$end_date);
        $suppliers = $this->countSuppliers($request,$service_id,$location_id,$start_date,$end_date);
      
        $html = "";
        if($service_id != ""){
            $get_service_name = Services::where('id',$service_id)->select('name')->first();
            $stext = $get_service_name->name;
        }else{
            $stext = "services";
        }
        if($location_id != ""){
            $get_location_name = Location::where('id',$location_id)->select('location_name')->first();
            $ltext = $get_location_name->location_name;
        }else{
            $ltext = "this area";
        }

              $countSuppliers =   count($suppliers);

         $html = '<p> Total Searched Suppliers : '. $countSuppliers.'</p>';

             
         
            $html .= '<div class="table-responsive">          
              <table class="table">
                <thead>
                  <tr>
                    <th>Supplier Name</th>
                    <th>Supplier Email</th>
                  </tr>
                </thead>
                <tbody>';
                    for ($i = 0; $i <$countSuppliers; $i++) {
                $html .='<tr>
                    <td><p>'. $suppliers[$i]->name.'</p></td>
                    <td><p>'. $suppliers[$i]->email.'</p></td>
                  </tr>';
              }
             $html .='</tbody>
              </table>
              </div>';
             

         $html .= '<p>The number of <b>'.$stext.'</b> in <b>'.$ltext.'</b> signed up to the service : '.$countServiceByLocation.' </p>
          <p> The number of people who have searched for <b>'.$stext.'</b> in <b>'.$ltext.'</b> : '.$countServiceSearch.'</p>
          <p>The number of people who have contacted <b>'.$stext.'</b> in <b>'.$ltext.'</b> : '.$countServiceContacted.'</p>
          <p>The number of people who have booked <b>'.$stext.'</b> in <b>'.$ltext.'</b>  : '.$countServiceBooked.'</p>';
          return response()->json(["success" => true, "html" => $html, "count" => $countSuppliers]);    
    }
    // public function countSuppliers()
    public function countServiceByLocation($service_id=0,$location_id=0,$start_date,$end_date){
        $count_service_by_location = Supplier_services::where('status','Active');
        if($service_id != ""){
            $count_service_by_location->where('service_id',$service_id);
        }
        if($location_id != ""){
            $count_service_by_location->where([['location','like','%'.$location_id.'%']]);
        }
        if($start_date != "" && $end_date != ""){
            $count_service_by_location->whereBetween('created_at',[$start_date,$end_date]);
        }
        elseif ($start_date != "") {
            $count_service_by_location->where('created_at','>=',$start_date);
        }elseif ($end_date != "") {
            $count_service_by_location->where('created_at','<=',$end_date);
        }
        return $count_service_by_location->count();

    }
    public function countServiceContacted($service_id=0,$location_id=0,$start_date,$end_date){
        $count_service_connected = DB::table('supplier_services')
                                ->join('customers_inquiry', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
                                ->where('customers_inquiry.status',0);
        if($service_id != ""){
            $count_service_connected->where('supplier_services.service_id',$service_id);
        }
        if($location_id != ""){
            $count_service_connected->where([['location','like','%'.$location_id.'%']]);
        }
        if($start_date != "" && $end_date != ""){
            $count_service_connected->whereBetween('customers_inquiry.created_at',[$start_date,$end_date]);
        }
        elseif ($start_date != "") {
            $count_service_connected->where('customers_inquiry.created_at','>=',$start_date);
        }elseif ($end_date != "") {
            $count_service_connected->where('customers_inquiry.created_at','<=',$end_date);
        }
        return $count_service_connected->count();                        

    }
    public function countServiceBooked($service_id=0,$location_id=0,$start_date,$end_date){
        $count_service_booked = DB::table('supplier_services')
                    ->join('booking', 'supplier_services.id', '=', 'booking.supplier_services_id')
                    ->where('booking.status',1);
        if($service_id != ""){
            $count_service_booked->where('supplier_services.service_id',$service_id);
        }
        if($location_id != ""){
            $count_service_booked->where([['location','like','%'.$location_id.'%']]);
        }
        if($start_date != "" && $end_date != ""){
            $count_service_booked->whereBetween('booking.booking_date',[$start_date,$end_date]);
        }
        elseif ($start_date != "") {
            $count_service_booked->where('booking.booking_date','>=',$start_date);
        }elseif ($end_date != "") {
            $count_service_booked->where('booking.booking_date','<=',$end_date);
        }
        return $count_service_booked->count();                 
    }               
    public function countServiceSearch($service_id=0,$location_id=0,$start_date,$end_date){
        $count_service_search = DB::table('search_analytics');
        if($service_id != ""){
            $count_service_search->where('service_id',$service_id);
        }
        if($location_id != ""){
            $count_service_search->where([['location_id','like','%'.$location_id.'%']]);
        }
        if($start_date != "" && $end_date != ""){
            $count_service_search->whereBetween('date',[$start_date,$end_date]);
        }
        elseif ($start_date != "") {
            $count_service_search->where('date','>=',$start_date);
        }elseif ($end_date != "") {
            $count_service_search->where('date','<=',$end_date);
        }
        return $count_service_search->count();  
    }
    public function countSuppliers($request, $service_id=0,$location_id=0,$start_date,$end_date){
        $countSuppliers = DB::table('supplier_services')
                            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                            ->where('supplier_services.status','Active');
        if($service_id != ""){
            $countSuppliers->where('supplier_services.service_id',$service_id);
        }
        if($location_id != ""){
            $countSuppliers->where([['supplier_services.location','like','%'.$location_id.'%']]);
        }
        if($start_date != "" && $end_date != ""){
            $countSuppliers->whereBetween('supplier_services.created_at',[$start_date,$end_date]);
        }
        elseif ($start_date != "") {
            $countSuppliers->where('supplier_services.created_at','>=',$start_date);
        }elseif ($end_date != "") {
            $countSuppliers->where('supplier_services.created_at','<=',$end_date);
        }
        $suppliers = $countSuppliers->select('supplier_profile.email','supplier_profile.name')->get();
        // dd($suppliers);
        $request->session()->put('emails', '');
        $request->session()->put('emails', $suppliers);
      //  return $countSuppliers->count();  

        return $suppliers;

    }
    public function sendReportTemplate(Request $request){
        $template = $request->template;
        $emails = $request->session()->get('emails');
        foreach ($emails as $key=>$email) {
            $supplier_email = $email->email;
            $data = array(
                'template' => $template
            );
            Mail::send("emails.admin.MailJobs",$data, function($message) use ($supplier_email)
            {
                $message->to($supplier_email)->subject('Analytics Party Perfect' );
            });
             \Alert::success('Template sent successfully.')->flash();
              return response()->json(["success" => true]); 
        }
        
    }
}
