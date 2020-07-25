<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Session;
use View;
use DB;
use Mail;
use Response;

//Models
use App\User;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Supplier_services;
use App\Models\Services;
use App\Models\Events;
use App\Models\Location;
use App\Models\SiteDetails;
use App\Models\PriceRange;
use App\Models\Supplier_assign_events;


use App\Http\Controllers\AnalyticsController;
use App\Models\EmailTemplatesDynamic as EmailTemplate;

class supplierController extends Controller
{
    private $AnalyticsAPI;

    public function __construct(AnalyticsController $AnalyticsAPI)
    {
       $this->AnalyticsAPI = $AnalyticsAPI;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function getUserID(){
        return Auth::guard('supplier')->user()->id;
     }

     public function getUserDetails(){
        $user_id = $this->getUserID();
        $user = Supplier::where('id',$user_id)->first();
        return $user;
     }

     public function dashboard(){

        $user =$this->getUserDetails();
        $supplier_id = $user->id;

        $getLocations = Location::get();
        $Services =  Services::orderBy('name', 'ASC')->get();
        $Events = Events::orderBy('name', 'ASC')->get();
        $PriceRange = PriceRange::orderBy('status', 'ASC')->get();
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

        // $booking  = DB::table("booking")->where('booking.supplier_id',$supplier_id)
        //                                 ->join('services', 'services.id', '=', 'booking.service_id')
        //                                 ->join('events', 'events.id', '=', 'booking.event_id')
        //                                 ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id')                                        
        //                                 ->select('customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*')
        //                                 ->get();

        $booking =  DB::table("supplier_services")
        ->where('supplier_services.supplier_id',$supplier_id)
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('supplier_assign_events', 'supplier_services.id', '=', 'supplier_assign_events.supplier_services_id')                                        
        ->join('events', 'supplier_assign_events.event_id', '=', 'events.id')
        ->join('booking', 'booking.supplier_services_id', '=', 'supplier_services.id')
        ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
        ->select('customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*')
        ->get();   


        $customers =  DB::table('supplier_profile')
        ->join('supplier_services', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('customers_inquiry', 'customers_inquiry.supplier_services_id', '=', 'supplier_services.id')
        ->join('customer_profile', 'customers_inquiry.customer_id', '=', 'customer_profile.id')  
        ->join('supplier_assign_events', 'supplier_services.id', '=', 'supplier_assign_events.supplier_services_id')                                        
        ->join('events', 'supplier_assign_events.event_id', '=', 'events.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->where('supplier_services.supplier_id',$supplier_id)
        ->select('customer_id','customer_profile.image','customer_profile.email as customer_email','supplier_services.service_id','services.name as services_name','customer_profile.name as customer_name','events.name as event_name','events.id as event_id','supplier_services.id as supplier_services_id')
       ->whereIn('customers_inquiry.id', function($query){
                    $query->selectRaw('MAX(customers_inquiry.id)')->from('customers_inquiry')->groupBy('customers_inquiry.customer_id');
                })->orderBy('customers_inquiry.created_at','DESC')->get()
        ->toArray(); 
        
        
       $getCustomerProfile = Customer::get();


     
    // PAYMENT INFORMATION ---------------------------------------------------------------------------------------------

      $payment_transfer_info =  DB::table('payment_transfer_info_supplier')->where('supplier_id',$supplier_id)->first();        

      $payment_details = DB::table("booking")->where('payment.supplier_id',$supplier_id)
                            ->join('payment', 'payment.booking_id', '=', 'booking.id')
                            ->join('services', 'services.id', '=', 'booking.service_id')
                            ->join('events', 'events.id', '=', 'booking.event_id')
                            ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id')
                            ->select('booking.*','payment.amount as payment_amount','payment.paid_unpaid','payment.payment_date','payment.booking_id','customer_profile.name as customer_name','services.name as service_name','events.name as event_name')
                            ->get();

        $supplier_service_details =  DB::table("supplier_services")
                                    ->where('supplier_services.supplier_id',$supplier_id)
                                    ->join('services', 'services.id', '=', 'supplier_services.service_id')
                                    ->select('supplier_services.service_id','services.name as service_name','supplier_services.id as supplier_services_id','supplier_services.business_name')
                                    ->get();                   
                                

                                    $currency_symbol = "";
                                    $SiteDetails =  SiteDetails::get()->first();
                                    if($SiteDetails){
                                        $currency_symbol = $SiteDetails->currency_symbol;
                                    }

        return view('supplier.dashboard', ["PriceRange"=>$PriceRange,"currency_symbol"=>$currency_symbol,"supplier_service_details"=>$supplier_service_details,"customer_email_list"=>$getCustomerProfile, "user_details" => $user,'locations' => $getLocations,'Services'=>$Services,'Events'=>$Events,"booking"=>$booking,"payment_details"=>$payment_details,"customers"=>$customers,"CustomerProfile"=>[],"Analytic_record"=>$Analytic_record,"payment_transfer_info"=>$payment_transfer_info]);
     }

    public function account()
    {        
        $Supplier =$this->getUserDetails();
        return view('supplier.account', ["Supplier_details" => $Supplier]);
    }

    public function account_edit(Request $request)
    {   
        $user_id = $this->getUserID();
        $data = [];

        if(isset($request['email'])){
            $current_supplier_email = Supplier::where('id',$user_id)->where('email',$request['email'])->first();
            if($current_supplier_email == ""){
                $check_email = Supplier::where('email',$request['email'])->first();
                if($check_email != ""){
                    return response()->json(["success" => false, "email" => $request['email'], "message" => "This email is already in use."]);
                }
            }
            $email = $request['email'];
            $data['email'] = $email;
        }

        if(isset($request['password'])){
            $password = $request['password'];
            $data['password_string'] = $password;
            $data['password'] = Hash::make($password);
        }

        if(isset($request['phone'])){
            $phone = $request['phone'];
            $data['phone'] = $phone;
        }

        $supplier = Supplier::where('id',$user_id)
                    ->update($data);   

                    
     if(isset($request['email']) && $request['email'] != $request['old_email']){
        
        $email = $request['email'];
        
        $supplier = Supplier::where('id',$user_id)->get()->first();
        $name = $supplier->name;
        $data = array(
            'name'=>$name,
            'email'=>$email
            );            
            // Mail::send("emails.ChangeAcountDetails",$data, function($message) use ($email, $name)
            // {
            //     $message->to($email, $name)->subject('Email Change!');
            // });


               /*
                * @Author: Satish Parmar
                * @ purpose: This helper function use for send dynamic email template from db.
                */
                    $template = EmailTemplate::where('name', 'ChangeAcountDetails')->first();
                    $to_mail = $email;
                    $to_name = $name;
                    $view_params = [
                        'name'=>$name, 
                        'base_url' => url('/'),
                    ];
                    // in DB Html bind data like {{firstname}}
                    send_mail_dynamic($to_mail,$to_name,$template,$view_params);

               /* @author:Satish Parmar EndCode */



        }
//                        Session::flash('success', "Your Account is Successfully Updated.");
//                        return redirect()->back();
        if(isset($request['email'])) {
            return response()->json(["success" => true, "email" => $email, "message" => "Your email is successfully updated."]);
        }
        elseif(isset($request['phone'])) {
            return response()->json(["success" => true, "phone" => $phone, "message" => "Your phone is successfully updated."]);
        }
        elseif(isset($request['password'])) {
            return response()->json(["success" => true, "message" => "Your password is successfully updated."]);
        }
        else{
            return response()->json(["success" => true, "message" => "Your Account is Successfully Updated."]);
        }
     
     //   $this->validator($request->all())->validate();
       
    }   

    public function profile()
    {
        $user_id = $this->getUserID();     
        $Supplier = Supplier::where('id',$user_id)->first();
        $Category =  SupplierCategory::orderBy('name', 'ASC')->get();
        $Category = $Category->pluck('name');
        return view('supplier.profile', ['Category'=>$Category,"Supplier_details" => $Supplier]);
    }

    public function profile_edit(Request $request)
    {

        // $messages = [
        //     'name.required' => 'The Name field is required.',
        //     'email.required' => 'The Email field is required.',
        //     'phone.required' => 'The Phone field is required.',
        //     'service_name.required' => 'The Service Name field is required.',
        //     'business_name.required' => 'The Business Name field is required.',
        //     'category.required' => 'The  category field is required.',
        //     'service_description.required' => 'The  Service description field is required.',
        //     'location.required' => 'The  Location field is required.',
        //     'pricing_category.required' => 'The  Pricing Category field is required.',
        //     'event_type.required' => 'The  Event Type field is required.',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' =>  ['required', 'string', 'email', 'max:255'],
        //     'phone' => ['required', 'numeric'],
        //     'service_name' => 'required',
        //     'business_name' => 'required',
        //     'category' => 'required',
        //     'event_type' => 'required',
        //     'service_description' => 'required',
        //     'location' => 'required',
        //     'pricing_category' => 'required',
        // ], $messages);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

            $user_id = $this->getUserID();
                 
            if($request->file('image')){
            // $image = $request->file('image');
            // $imagename = time().'.'.$image->getClientOriginalExtension();
            // $destinationPath = public_path('/uploads/Supplier/');
            // $image->move($destinationPath, $imagename);

            $file = $request->file('image');
            $destination_path = "/uploads/Supplier";
            $upload_imagename = md5($file->getClientOriginalName().random_int(1, 9999).time()).'.'.$file->getClientOriginalExtension();
            $upload_url = public_path($destination_path).'/'.$upload_imagename;
            $filename = compress_image($_FILES["image"]["tmp_name"], $upload_url, 40);
            $file_path = $destination_path.'/'.$upload_imagename;
            $images_url = $file_path;



            $supplier = Supplier::where('id',$user_id)
            ->update([
                'image' => $images_url,
              ]); 

              //Session::flash('success', "Your Profile  Successfully Updated.");
              return redirect()->back();
            }
            $current_supplier_email = Supplier::where('id',$user_id)->where('email',$request['email'])->first();
            if($current_supplier_email == ""){
                $check_email = Supplier::where('email',$request['email'])->first();
                if($check_email != ""){
                    return response()->json(["success" => false, "email" => $request['email'], "message" => "This email is already in use."]);
                }
            }
            $supplier = Supplier::where('id',$user_id)->update([
               'name' => $request['name'],
               'email' => $request['email'],
               'phone' => $request['phone'],
              ]);  

            //   'business_name' => $request['business_name'],
            //   'service_description' => $request['service_description'],
            //   'facebook_link' => $request['facebook_link'],              
            //   'facebook_title' => $request['facebook_title'],              
            //   'instagram_link' => $request['instagram_link'],              
            //   'instagram_title' => $request['instagram_title'], 

//              Session::flash('success', "Your Profile is Successfully Updated.");
//              return redirect()->back();
        return response()->json(["success" => true, "email" => $request['email'],"name" => $request['name'],"phone" => $request['phone'], "message" => "Your Account is Successfully Updated."]);
    }
            
        public function SendInvoice(Request $request)
        {
           $supplier =$this->getUserDetails();
           $supplier_name = $supplier->name;
           $booking_date = $request['booking_date'];
           $event_id = $request['event_id'];
           $service_id = $request['service_id'];
           $amount = $request['amount'];
           $user_id = $this->getUserID();
           $customer_id = $request['customer_id'];
           $event_address = $request['event_address'];
           $supplier_services_id = $request['supplier_services_id'];

           $booking_id = DB::table("booking")->insertGetId([
               "customer_id"=>$customer_id,
               "supplier_services_id"=>$supplier_services_id,
               "supplier_id"=>$user_id,
               "booking_date"=>$booking_date,
               "event_id"=>$event_id,
               "service_id"=>$service_id,
               "event_address"=>$event_address,
               "amount"=>$amount,
               "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
               "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
           ]);

            $message = "Your Invoice link is : <a href='".url('invoice/')."/".base64_encode($booking_id)."'>view invoice</a>";

           $inquiry_id = DB::table('customers_inquiry')
           ->insertGetId(array(
           'customer_id' =>$customer_id,
           'supplier_services_id' => $supplier_services_id,
           'message' => $message,
           'status'=>1,
           "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
           "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
           ));

           if($booking_id){
            $Customer = Customer::where('id',$customer_id)->first();
            if($Customer){
            $email = $Customer->email;
            $name = $Customer->name;
          
            $data = array(
                'booking_id'=>$booking_id,
                'sname'=>$supplier_name
               );            
              
                // Mail::send("emails.SendInvoice",$data, function($message) use ($email, $name, $supplier_name)
                // {
                //     $message->to($email, $name)->subject('Invoice from '.$supplier_name);
                // });

               /*
                * @Author: Satish Parmar
                * @ purpose: This helper function use for send dynamic email template from db.
               */
                    $template = EmailTemplate::where('name', 'SendInvoice')->first();
                    $to_mail = $email;
                    $to_name = $name;
                    $view_params = [
                        'booking_id'=>$booking_id,
                        'sname'=>$supplier_name,
                        'base_url' => url('/'),
                        'invoice_link' => route('invoice',['booking_id'=>base64_encode($booking_id)])
                    ];
                    // in DB Html bind data like {{firstname}}
                    send_mail_dynamic($to_mail,$to_name,$template,$view_params);
  
               /* @author:Satish Parmar EndCode */


            }
            return Response::json(["success"=>"Invoice Successfully Send."]);
           
           }
           return Response::json(["error"=>"The Invoice cannot be Send."]);
        
        }

        public function addToreply(Request $request){
            if( \Auth::guard('supplier')){
                // $user_id = $this->getUserID();
                $user_details = $this->getUserDetails();
                $user_id = $user_details->id;
                $user_name = $user_details->name;
                $user_email = $user_details->email;
                $inquiry_id = DB::table('customers_inquiry')
                    ->insertGetId(array(
                    'customer_id' =>$request->customer_id,
                    'supplier_services_id' => $request->supplier_service_id,
                    'message' => $request->message,
                    'status'=>1,
                    "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                    "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                    ));
                $get_mail_data =  DB::table('supplier_services')
                                ->join('customers_inquiry', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
                                ->join('customer_profile', 'customers_inquiry.customer_id', '=', 'customer_profile.id')
                                ->join('services', 'supplier_services.service_id', '=', 'services.id')
                                ->where('customers_inquiry.id',$inquiry_id)
                                ->select('supplier_services.*','customer_profile.email as customer_mail','customer_profile.name as customer_name','customers_inquiry.*','services.name as service_name','customers_inquiry.message as inq_message')
                                ->first();
                    // dd($get_mail_data);
                $customer_email = $get_mail_data->customer_mail;
                $customer_name = $get_mail_data->customer_name;
                $supplier_business = $get_mail_data->business_name;
                $supplier_service =  $get_mail_data->service_name;
                $supplier_message = $get_mail_data->inq_message;  
                // dd($customer_message);  
                $data = array(
                'name'=>$customer_name,
                'email'=> $customer_email,
                'business'=> $supplier_business,
                'service'=> $supplier_service,
                'messages'=>$supplier_message,
                'name_from'=> $user_name,
                'email_from'=> $user_email,
                );
                // Mail::send("emails.replyToInquiry_From_Supplier",$data, function($message) use ($customer_email, $customer_name)
                // {
                //     $message->to($customer_email, $customer_name)->subject('Party Perfect - New inquiry message!');
                // }); 

                /*
                * @Author: Satish Parmar
                * @ purpose: This helper function use for send dynamic email template from db.
                */
                $messenger_inbox_link = url('/customer/dashboard/')."#messenger";
                $template = EmailTemplate::where('name', 'replyToInquiry_From_Supplier')->first();
                $to_mail = $customer_email;
                $to_name = $customer_name;
                $view_params = [
                    'name'=>$customer_name,
                    'email'=> $customer_email,
                    'business'=> $supplier_business,
                    'service'=> $supplier_service,
                    'messages'=>$supplier_message,
                    'name_from'=> $user_name,
                    'email_from'=> $user_email,
                    'base_url' => url('/'),
                    'messenger_inbox_link' => $messenger_inbox_link
                ];
                // in DB Html bind data like {{firstname}}
                send_mail_dynamic($to_mail,$to_name,$template,$view_params);

           /* @author:Satish Parmar EndCode */




                    $dd = '<p class="right_ms">
                             <span class="gradient-pink-text">Me : </span> '.$request->message.'
                             <span class="date_time_created">'.date('Y-m-d H:i:s').'</span>
                            </p>';
                    return response()->json(["success"=>true, "html"=>$dd]);
                
            }else{
                return response()->json(["success"=>false, "message"=>""]);
            }
        }


        public function check_customer_exists(Request $request)
        {
               $email = $request->customer_email;
               $customer = Customer::where('email',$email)->first();
               if($customer){
                   return "true";
               }
               return "false";
        }
       
        
        public function payment_transfer_info_update(Request $request)
        {

            $supplier_id = $request->supplier_id;
            $account_holder_name = $request->account_holder_name;
            $account_number = $request->account_number;
            $ifsc = $request->ifsc;
            $bank_name = $request->bank_name;
            $bank_address = $request->bank_address;
            $iban = $request->iban;
            $sortcode = $request->sortcode;

          $payment_details =  DB::table('payment_transfer_info_supplier')
                ->updateOrInsert(
                    ['supplier_id' => $supplier_id],
                    [
                        'account_holder_name' => $account_holder_name,
                        'account_number' => $account_number,
                        'ifsc' => $ifsc,
                        'bank_name' => $bank_name,
                        'bank_address' => $bank_address,
                        'iban' => $iban,
                        'sortcode' => $sortcode,
                        "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                        "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                    ]
                );

                if($payment_details){
                         return Response::json(["success"=>"Payment Details Saved Successfully."]);
               }
                return Response::json(["error"=>"The Payment Details  cannot be Saved."]);
        }


        public function AddSupplierServices(Request $request)
        {
          // dd($request->all());
              
                $Result = $request;
                $supplier_id = $Result->supplier_id;
                $business_name = $Result->business_name;
                $service_description = $Result->service_description;
                $facebook_link  = $Result->facebook_link;
                $instagram_link = $Result->instagram_link;
                $price_range = $Result->price_range;
                $location = $Result->location;
                $event_ids = $Result->event_id;
                $service_id = $Result->service_id;
                
                $supplier_services_data = [ 
                   'supplier_id'=>$supplier_id,
                   'service_id'=>$service_id,
                   'business_name'=>$business_name,
                   'service_description'=>$service_description,
                   'facebook_title' => "Facebook",
                   'facebook_link'=>$facebook_link,
                   'instagram_title' =>"Instagram",
                   'instagram_link'=>$instagram_link,
                   'location'=>$location,
                   'price_range'=>$price_range,
                   'status'=>'Active',
                   'created_at' => date('Y-m-d H:i:s'),
                   'updated_at' => date('Y-m-d H:i:s')
                ];
           
              $supplier_assign_events =  Supplier_services::create($supplier_services_data);

               if($supplier_assign_events && $event_ids){
                   foreach ($event_ids as $event_id){
                       $supplier_assign_category_id =  $supplier_assign_events->id;
                       Supplier_assign_events::create(['supplier_services_id'=>$supplier_assign_category_id,'event_id'=>$event_id]);
                   }
               }
              
                if($supplier_assign_events){
                   return Response::json(["success"=>"Supplier service Added Successfully."]);
               }
                return Response::json(["error"=>"Supplier service Added failed."]);
        }

}




