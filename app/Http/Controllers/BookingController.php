<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

use Auth;
use Session;
use App\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use App\Models\Location;
use App\Models\Bookings;
use Mail;
use Response;
use App\Models\EmailTemplatesDynamic as EmailTemplate;

class BookingController extends Controller
{
     // Bookings  Management



     public function booking_get(Request $request)
     {   

       //  $booking  = DB::table("booking")->get();
       $supplier_id = $request['supplier_id'];
         $site = getFooterDetails();
         $booking =  DB::table("supplier_services")
         ->where('supplier_services.supplier_id',$supplier_id)
         ->join('services', 'services.id', '=', 'supplier_services.service_id')
         ->join('booking', 'booking.supplier_services_id', '=', 'supplier_services.id')->join('events', 'booking.event_id', '=', 'events.id')
         ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
         ->select('customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*','booking.status as booking_status')
         ->get();   
         foreach ($booking as $key => $value) {
                $date = strtotime($value->booking_date);
                $booking[$key]->book_date = date('d-m-Y',$date);
                $booking[$key]->encoded_id = base64_encode($value->id);

             }
        // $payment_status =  DB::table('payment')->where('booking_id',)
         return Response::json(["booking" => $booking, "symbol" => $site->currency_symbol]);
     }


     public function getCustomerBooking(Request $request)
     {   
       
       //  $booking  = DB::table("booking")->get();
       $customer_id = $request['customer_id'];
       $site = getFooterDetails();
         $booking =  DB::table('supplier_services')
             ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
             ->join('booking', 'supplier_services.id', '=', 'booking.supplier_services_id')
             ->join('events', 'booking.event_id', '=', 'events.id')
             ->join('services', 'supplier_services.service_id', '=', 'services.id')
             ->where('booking.customer_id',$customer_id)
             ->select('supplier_profile.name as sname','events.name as event_name','services.name as service_name','booking.*','booking.id as booking_id','supplier_services.business_name','booking.status as booking_status')
             ->get();
             foreach ($booking as $key => $value) {
                $date = strtotime($value->booking_date);
                $booking[$key]->book_date = date('d-m-Y',$date);
                $booking[$key]->encoded_id = base64_encode($value->id);
             }
         return Response::json(["booking" => $booking, "symbol" => $site->currency_symbol]);
     }

     

     public function booking_add_manual(Request $request)
     {

        $supplier_id = $request['supplier_id'];
        $supplier_services_id = $request['supplier_services_id'];

        $customer_id = null;

        $email = $request->customer_email;
        $customer = Customer::where('email',$email)->first();
        if($customer){
            $customer_id = $customer->id;
        }

        $booking_date = $request['booking_date'];
        $event_id = $request['event_id'];
        $service_id = null;
        $amount = $request['amount'];
        $status = $request['status'];

        
        $event_address = $request['event_address'];


      //   $booking_allready_exist = DB::table("booking")->where("customer_id",$customer_id)->first();
      //   if($booking_allready_exist){
      //       return Response::json(["info"=>"Booking Allready exist for this customer."]);  
      //   }

        $booking = DB::table("booking")->insert([
            "customer_id"=>$customer_id,
            "supplier_id"=>$supplier_id,
            "supplier_services_id"=>$supplier_services_id,
            "booking_date"=>$booking_date,
            "event_id"=>$event_id,
            "service_id"=>$service_id,
            "event_address"=>$event_address,
            "amount"=>$amount,
            "status"=>$status,
            "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
            "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
        ]);

        if($booking){
            return Response::json(["success"=>"Booking added Successfully."]);
            // Session::flash('success', "Booking added Successfully.");
            // return redirect()->back();   
        }
        return Response::json(["error"=>"The booking cannot be added."]);

        // Session::flash('error', "The booking cannot be added.");
        // return redirect()->back(); 
     }


     public function booking_edit($id)
     {   
        // $where = array('id' => $id);
        // $booking  = DB::table("booking")->where($where)->first();
  

         $booking =  DB::table("booking")
         ->where('booking.id',$id)
         ->join('supplier_services', 'supplier_services.id', '=', 'booking.supplier_services_id')
         ->join('services', 'services.id', '=', 'supplier_services.service_id')
         ->join('events', 'booking.event_id', '=', 'events.id')
         ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
         ->select('customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*')
         ->first();


  
         return Response::json($booking);

        // return Response::json($booking);
     }
   
     
     public function booking_update(Request $request)
     {
      
             $booking_id = $request['booking_id'];
             $booking_date = $request['booking_date'];
             $event_id = null;
             $service_id = null;
             $event_address = $request['event_address'];
             $amount = $request['amount'];
             $status = $request['status_edit'];
            

             $booking = DB::table("booking")
              ->where('id',$booking_id)   
              ->update([
                 "booking_date"=>$booking_date,
                 "event_address"=>$event_address,
                 "amount"=>$amount,
                 "status"=>$status,
                 "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
             ]);
              
             
             if($booking){
                return Response::json(["success"=>"Booking Updated Successfully."]);
                //  Session::flash('success', "Booking Updated Successfully.");
                //  return redirect()->back();   
             }
             return Response::json(["error"=>"Booking Updated Successfully."]);
            //  Session::flash('error', "The booking cannot be Updated.");
            //  return redirect()->back();
     }


    public function booking_remove(Request $request,$booking_id=null)
    {
        $booking = DB::table("booking")->where('id',$booking_id)->delete();
       if($booking){
        return Response::json(["success"=>"Booking Deleted Successfully."]);
        // Session::flash('success', "Booking Deleted Successfully.");
        // return redirect()->back();   
          }
    Session::flash('error', "The booking cannot be deleted.");
    // return Response::json(["error"=>"The booking cannot be deleted."]);
    // return redirect()->back(); 
    }




       public function booking_payment_info(Request $request,$booking_id)
     {   
     
         $records =  DB::table("supplier_services")
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('booking', 'booking.supplier_services_id', '=', 'supplier_services.id')
        ->join('events', 'booking.event_id', '=', 'events.id')
        ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
        ->where('booking.id',$booking_id)
        ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*')
        ->first();

    $booking_date =  \Carbon\Carbon::parse($records->booking_date)->format('d-m-yy');

       $content ='<div class="card no-padding no-border">
                  <table class="table table-striped mb-0">
                     <tbody>
                       <tr>
                           <td>
                              <strong>Booking date:</strong>
                           </td>
                           <td>
                              <span>'.$booking_date.'</span></td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Supplier service:</strong>
                           </td>
                           <td>
                              <span>'.$records->service_name.'</span>                                                                                                      
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Event:</strong>
                           </td>
                           <td>
                              <span>'.$records->event_name.'</span>                                                                                                      
                           </td>
                        </tr>
                          <tr>
                           <td>
                              <strong>Event venues:</strong>
                           </td>
                           <td>
                              <span>'.$records->event_address.'</span>                                                                                                      
                           </td>
                        </tr>

                        <tr>
                           <td>
                              <strong>Customer:</strong>
                           </td>
                           <td>
                              <span>'.$records->customer_name.'</span></td>
                        </tr>
                          <tr>
                           <td>
                              <strong>Supplier:</strong>
                           </td>
                           <td>
                              <span>'.$records->supplier_name.'</span></td>
                        </tr>  
                        <tr>
                           <td>
                              <strong>Amount:</strong>
                           </td>
                           <td>
                              <span>'.$records->amount.'</span></td>
                        </tr>                      
                    </tbody>
                  </table>
               </div>';

         return Response::json(["content" => $content]);
     }


     public function SendBookingConfirmationEmail(Request $request,$booking_id)
     {
 
            $bookingData =  DB::table("supplier_services")
            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
            ->join('services', 'services.id', '=', 'supplier_services.service_id')
            ->join('booking', 'booking.supplier_services_id', '=', 'supplier_services.id')
            ->join('events', 'booking.event_id', '=', 'events.id')
            ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
            ->where('booking.id',$booking_id)
            ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','customer_profile.email as customer_email','services.name as service_name','events.name as event_name','booking.*')
            ->first();   

            if($bookingData){
 
             $name =$bookingData->customer_name;
             $email =$bookingData->customer_email;
             $booking_date =  \Carbon\Carbon::parse($bookingData->booking_date)->format('d-m-yy');
             $content ='<div class="card no-padding no-border">
             <table class="table table-striped mb-0">
                <tbody>
                  <tr>
                      <td>
                         <strong>Booking date:</strong>
                      </td>
                      <td>
                         <span>'.$booking_date.'</span></td>
                   </tr>
                   <tr>
                      <td>
                         <strong>Supplier service:</strong>
                      </td>
                      <td>
                         <span>'.$bookingData->service_name.'</span>                                                                                                      
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <strong>Event:</strong>
                      </td>
                      <td>
                         <span>'.$bookingData->event_name.'</span>                                                                                                      
                      </td>
                   </tr>
                     <tr>
                      <td>
                         <strong>Event venues:</strong>
                      </td>
                      <td>
                         <span>'.$bookingData->event_address.'</span>                                                                                                      
                      </td>
                   </tr>

                   <tr>
                      <td>
                         <strong>Customer:</strong>
                      </td>
                      <td>
                         <span>'.$bookingData->customer_name.'</span></td>
                   </tr>
                     <tr>
                      <td>
                         <strong>Supplier:</strong>
                      </td>
                      <td>
                         <span>'.$bookingData->supplier_name.'</span></td>
                   </tr>  
                   <tr>
                      <td>
                         <strong>Amount:</strong>
                      </td>
                      <td>
                         <span>'.$bookingData->amount.'</span></td>
                   </tr>                      
               </tbody>
             </table>
          </div>';
             /*
             * @Author: Satish Parmar
             * @ purpose: This helper function use for send dynamic email template from db.
             */
             $template = EmailTemplate::where('name', 'resend-booking-confirmation-mail')->first();
             $to_mail = $email;
             $to_name = $name;
             $view_params = [
                 'name'=>$name, 
                 'email'=>$email,
                 'content' => $content,
                 'base_url' => url('/'),
                 'SupplierLogin_url' => url('/supplier-login')
             ];
             // in DB Html bind data like {{firstname}}
             send_mail_dynamic($to_mail,$to_name,$template,$view_params);
   
             /* @author:Satish Parmar EndCode */
        
             return Response::json(["success"=>"Booking Confirmation mail send Successfully."]);
            }
            return Response::json(["error"=>"something went wrong."]);
     }
 
}
