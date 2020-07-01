<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Mail;
use Response;
use App\Models\EmailTemplatesDynamic as EmailTemplate;

class customerController extends Controller
{
    public function __construct()
    {
        
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }   

    public function getUserID(){
        return Auth::guard('customer')->user()->id;
     }

     public function getUserDetails(){
        $user_id = $this->getUserID();
        $user = Customer::where('id',$user_id)->first();
        return $user;
     }
     public function dashboard(){
        $user =$this->getUserDetails();
        $user_id = $this->getUserID();
        // $inquiry = DB::table('customers_inquiry')
        // ->join('supplier_services', 'customers_inquiry.supplier_services_id', '=', 'supplier_services.id')
        // ->groupBy('customers_inquiry.supplier_services_id')
        // ->where('customers_inquiry.customer_id',$user_id)
        // ->orderBy('customers_inquiry.created_at','DESC')
        // ->distinct('supplier_services_id')
        // ->get();
        // dd($inquiry);
        // ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION

        // $services =  DB::table('supplier_services')
        // 					->join('customers_inquiry', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
        //                     ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        //                     ->join('services', 'supplier_services.service_id', '=', 'services.id')
        //                     ->where('customers_inquiry.customer_id',$user_id)
        //                     ->select('supplier_services.supplier_id','supplier_profile.image','business_name','services.name','services.id as service_id','supplier_services.*')
        //                     ->distinct('supplier_services_id')
        //                     ->get();
$services =  DB::table('supplier_services')
				->join('customers_inquiry', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
				->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                ->join('services', 'supplier_services.service_id', '=', 'services.id')
                ->where('customers_inquiry.customer_id',$user_id)
                ->select('supplier_services.supplier_id','supplier_profile.image','business_name','services.name','services.id as service_id','supplier_services.*')
                ->whereIn('customers_inquiry.id', function($query){
                    $query->selectRaw('MAX(customers_inquiry.id)')->from('customers_inquiry')->groupBy('customers_inquiry.supplier_services_id');
                })->orderBy('customers_inquiry.created_at','DESC')->get();
                            // dd($services);
        if($services != ''){
            $services = $services->toArray();
        }
         $wishlist =  DB::table('supplier_services')
             ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
             ->join('services', 'supplier_services.service_id', '=', 'services.id')
             ->join('customers_wishlist', 'supplier_services.id', '=', 'customers_wishlist.supplier_services_id')
             ->where('customers_wishlist.customer_id',$user_id)
             ->where('customers_wishlist.status',1)
             ->select('supplier_profile.name as sname','customers_wishlist.*','services.name as service_name','supplier_services.*','customers_wishlist.id as wish_id','supplier_services.business_name')
             ->get();

         if($wishlist != ''){
             $wishlist = $wishlist->toArray();
         }

         $booking =  DB::table('supplier_services')
             ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
             ->join('booking', 'supplier_services.id', '=', 'booking.supplier_services_id')
             ->join('events', 'booking.event_id', '=', 'events.id')
             ->join('services', 'supplier_services.service_id', '=', 'services.id')
             ->where('booking.customer_id',$user_id)
             ->select('supplier_profile.name as sname','events.name as event_name','services.name as service_name','booking.*','booking.id as booking_id')
             ->get();

         if($booking != ''){
             $booking = $booking->toArray();
         }
//         dd($wishlist);
        return view('customer.dashboard')->with(["user_details" => $user,'services'=>$services,'booking'=>$booking,'wishlist'=>$wishlist]);
     }
    public function wishlist(){
         $user =$this->getUserDetails();
        $user_id = $this->getUserID();
        $getinquiry =  DB::table('customers_inquiry')
                            ->join('supplier_profile', 'customers_inquiry.supplier_id', '=', 'supplier_profile.id')
                            ->join('supplier_categories_events', 'customers_inquiry.event_id', '=', 'supplier_categories_events.id')
                            ->select('supplier_categories_events.name','customers_inquiry.updated_at','supplier_profile.business_name','customers_inquiry.message')
                            ->where('customer_id',$user_id)->groupBy('supplier_id')->get()->toArray();

            return view('customer.wishlist')->with(["user_details" => $user]);
       }  
    public function payment(Request $request){
        if(!empty($request->all())){
            $booking_data =  DB::table('booking')->where('id',$request->booking_id)->first();
            return view('customer.PaymentStripe',["booking_data" => $booking_data,"customer_details" => $user =$this->getUserDetails()]);
        } else {
            return redirect()->back();
        }
    }

    public function account()
    {        
        $Supplier =$this->getUserDetails();
        return view('customer.account', ["Customer_details" => $Supplier]);
    }

    public function account_edit(Request $request)
    {
        $user_id = $this->getUserID();
        $data = [];

        if(isset($request['email'])){
            $current_cus_email = Customer::where('id',$user_id)->where('email',$request['email'])->first();
            if($current_cus_email == ""){
                $check_email = Customer::where('email',$request['email'])->first();
                if($check_email != ""){
                    return response()->json(["success" => false, "email" => $request['email'], "message" => "This email is already in use."]);
                }
            }
            $email = $request['email'];
            $data['email'] = $email;
        }

        if(isset($request['password'])){
            $password = $request['password'];
            $data['password'] = Hash::make($password);
        }

        if(isset($request['phone'])){
            $phone = $request['phone'];
            $data['phone'] = $phone;
        }

        $Customer = Customer::where('id',$user_id)
                    ->update($data);
//                        Session::flash('success', "Your Account is Successfully Updated.");
//                        return redirect()->back();
        if(isset($request['email'])) {
            return response()->json(["success" => true, "email" => $email, "message" => "Your email is successfully updated."]);
        }
        elseif(isset($request['phone'])) {
            return response()->json(["success" => true, "phone" => $phone, "message" => "Your phone is successfully updated."]);
        }elseif(isset($request['password'])) {
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
        $Customer = Customer::where('id',$user_id)->first();
        return view('customer.profile', ["Customer_details" => $Customer]);
    }

    public function profile_edit(Request $request)
    {

        // $messages = [
        //     'name.required' => 'The Name field is required.',
        //     'email.required' => 'The Email field is required.',
        //     'phone.required' => 'The Phone field is required.',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' =>  ['required', 'string', 'email', 'max:255'],
        //     'phone' => ['required', 'numeric'],
        // ], $messages);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

        $user_id = $this->getUserID();
                 
            if($request->file('image')){
            $image = $request->file('image');
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/Customer/');
            $image->move($destinationPath, $imagename);

            $Customer = Customer::where('id',$user_id)
            ->update([
                'image' => "/uploads/Customer/".$imagename,
              ]); 
            return redirect()->back();
            }
            $current_cus_email = Customer::where('id',$user_id)->where('email',$request['email'])->first();
            if($current_cus_email == ""){
                $check_email = Customer::where('email',$request['email'])->first();
                if($check_email != ""){
                    return response()->json(["success" => false, "email" => $request['email'], "message" => "This email is already in use."]);
                }
            }
            $Customer = Customer::where('id',$user_id)->update([
               'name' => $request['name'],
               'email' => $request['email'],
               'phone' => $request['phone'],
              ]);

            return response()->json(["success" => true, "email" => $request['email'],"name" => $request['name'],"phone" => $request['phone'], "message" => "Your Account is Successfully Updated."]);
//            Session::flash('success', "Your Profile is Successfully Updated.");
//            return redirect()->back();
    }
    public function sendInquiry(Request $request){
//        dd($request->all());
        if(\Auth::guard('customer')){
            $user =$this->getUserDetails()->toArray();
            $inquiry_data = $request->all();
            $supplieremail = $inquiry_data['supplier_email'];
            $suppliername = $inquiry_data['supplier_name'];
            $suppliermessage = $inquiry_data['message'];
            $supplier_id = $inquiry_data['supplier_id'];
            $service_name = $inquiry_data['service_name'];
            if($user){
                $inquiry_id = DB::table('customers_inquiry')
                ->insertGetId(array(
                'customer_id' => $user['id'],
                'supplier_services_id' => $inquiry_data['supplier_service_id'],
                'message' => $suppliermessage,
                "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                ));
                $data = array(
                'supplier_name'=>$suppliername,
                'customer_name'=> $user['name'],
                'customer_email'=> $user['email'],
                'event_name'=> $service_name,
                'suppliermessage'=>$suppliermessage,
                );
                if($inquiry_id){
                   
                    // Mail::send("emails.Customer_Inquiry",$data, function($message) use ($supplieremail, $suppliername)
                    // {
                    //     $message->to($supplieremail, $suppliername)->subject('Customer Inqury!');
                    // }); 

                    /*
                    * @Author: Satish Parmar
                    * @ purpose: This helper function use for send dynamic email template from db.
                    */
                    $messenger_inbox_link = url('/supplier/dashboard/')."#messenger";
                    $template = EmailTemplate::where('name', 'Customer-Inquiry')->first();
                    $to_mail = $supplieremail;
                    $to_name = $suppliername;
                    $view_params = [
                        'supplier_name'=>$suppliername,
                        'customer_name'=> $user['name'],
                        'customer_email'=> $user['email'],
                        'event_name'=> $service_name,
                        'suppliermessage'=>$suppliermessage,
                        'base_url' => url('/'),
                        'messenger_inbox_link' => $messenger_inbox_link
                    ];
                    // in DB Html bind data like {{firstname}}
                    send_mail_dynamic($to_mail,$to_name,$template,$view_params);

                   /* @author:Satish Parmar EndCode */


                }
                return response()->json(["success"=>true, "message"=>"Your inquiry is submitted successfully."]);
                
            }else{
                return response()->json(["success"=>false, "message"=>"Something went to wrong!"]);
               
            }
        }else{
                return response()->json(["success"=>false, "message"=>"Something went to wrong!"]);
               
        }
    }
    public function putSupplierReviews(Request $request){
        if( \Auth::guard('customer')){
            if($request->rate == ''){
                $rate = 0;
            }else{
                $rate = $request->rate;
            }
            $user_id = $this->getUserID();
            $review_id = DB::table('supplier_reviews')
            ->insertGetId(array(
            'customer_id' => $user_id,
            'supplier_services_id' => $request->supplier_service_id,
            'content_review' => $request->text_reviews,
            "rates" =>  $rate,
            "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
            "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
        ));
        return response()->json(["success"=>true, "message"=>"Your review is submitted successfully."]);
        }else{
            return response()->json(["success"=>false, "message"=>"Please login first with customer account!"]);
        }
    }
    public function addToWishlist(Request $request){

        if( \Auth::guard('customer')){
            $user_id = $this->getUserID();
            $w_id = DB::table('customers_wishlist')->where('supplier_services_id',$request->supplier_service_id)->where('customer_id',$user_id)->where('status',0)->first();
            if($w_id == null){
                $wish_id = DB::table('customers_wishlist')
                ->insertGetId(array(
                'customer_id' => $user_id,
                'supplier_services_id' => $request->supplier_service_id,
                "status" =>  1,
                "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                ));
            }else{
                  DB::table('customers_wishlist')
                ->where('customer_id', $user_id)
                ->where('supplier_services_id', $request->supplier_service_id  )
                ->where('status', 0)
                ->update(['status' => 1]);
            }
            return response()->json(["success"=>true, "message"=>"This is added into wishlist."]);
        }else{
            return response()->json(["success"=>false, "message"=>"Please login first with customer account!"]);
        }
    }
    public function removeToWishlist(Request $request){
        if( \Auth::guard('customer')){
            $user_id = $this->getUserID();
             DB::table('customers_wishlist')
                ->where('customer_id', $user_id)
                ->where('supplier_services_id', $request->supplier_service_id)
                ->where('status', 1)
                ->update(['status' => 0]);

            return response()->json(["success"=>true, "message"=>"This is removed from wishlist."]);
        }else{
            return response()->json(["success"=>false, "message"=>"Please login first with customer account!"]);
        }
    }
    public function addToreply(Request $request){
        if( \Auth::guard('customer')){
            // $user_id = $this->getUserID();
            $user_details = $this->getUserDetails();
            $user_id = $user_details->id;
            $user_name = $user_details->name;
            $user_email = $user_details->email;
            $inquiry_id = DB::table('customers_inquiry')
                ->insertGetId(array(
                'customer_id' => $user_id,
                'supplier_services_id' => $request->supplier_service_id,
                'message' => $request->message,
                "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                ));
                $get_mail_data =  DB::table('supplier_services')
                                    ->join('customers_inquiry', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
                                    ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                                    ->join('services', 'supplier_services.service_id', '=', 'services.id')
                                    ->where('customers_inquiry.id',$inquiry_id)
                                    ->select('supplier_services.*','supplier_profile.email as supplier_mail','supplier_profile.name as supplier_name','customers_inquiry.*','services.name as service_name','customers_inquiry.message as inq_message')
                                    ->first();
                                   
                $supplier_email = $get_mail_data->supplier_mail;
                $supplier_name = $get_mail_data->supplier_name;
                $supplier_business = $get_mail_data->business_name;
                $supplier_service =  $get_mail_data->service_name;
                $customer_message = $get_mail_data->inq_message;  
                // dd($customer_message);  
                $data = array(
                'name'=>$supplier_name,
                'email'=> $supplier_email,
                'business'=> $supplier_business,
                'service'=> $supplier_service,
                'messages'=>$customer_message,
                'name_from'=> $user_name,
                'email_from'=> $user_email,
                );
                // Mail::send("emails.replyToInquiry",$data, function($message) use ($supplier_email, $supplier_name)
                // {
                //     $message->to($supplier_email, $supplier_name)->subject('Party Perfect - New inquiry message!');
                // }); 

                /*
                * @Author: Satish Parmar
                * @ purpose: This helper function use for send dynamic email template from db.
                */
                $messenger_inbox_link = url('/supplier/dashboard/')."#messenger";
                $template = EmailTemplate::where('name', 'replyToInquiry')->first();
                $to_mail = $supplier_email;
                $to_name = $supplier_name;
                $view_params = [
                    'name'=>$supplier_name,
                    'email'=> $supplier_email,
                    'business'=> $supplier_business,
                    'service'=> $supplier_service,
                    'messages'=>$customer_message,
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
                         <span class="date_time_created">'.date('d-m-y H:i:s').'</span>
                        </p>';
                return response()->json(["success"=>true, "html"=>$dd]);
            
        }else{
            return response()->json(["success"=>false, "message"=>""]);
        }
    }
    public function wish_remove(Request $request,$wish_id=null){

        if( \Auth::guard('customer')) {
            if (\Auth::guard('customer')) {
                $user_id = $this->getUserID();
                DB::table('customers_wishlist')
                    ->where('id', $wish_id)
                    ->update(['status' => 0]);

              //  return response()->json(["success" => true, "message" => "This is removed from wishlist"]);
//                Session::flash('success', "This is removed from wishlist.");
                return Response::json(["success"=>"Wish removed Successfully."]);
//                return redirect()->back();
            } else {
                return Response::json(["success"=>"Something went to wrong!."]);
              //  return response()->json(["success" => false, "message" => "Please login first with customer account!"]);
//                Session::flash('info', "Please login first with customer account!");
//                return redirect()->back();
            }
        }
    }

    public function getCustomerWish(Request $request){
        $customer_id = $request['customer_id'];
        $wishlist =  DB::table('supplier_services')
            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
            ->join('services', 'supplier_services.service_id', '=', 'services.id')
            ->join('customers_wishlist', 'supplier_services.id', '=', 'customers_wishlist.supplier_services_id')
            ->where('customers_wishlist.customer_id',$customer_id)
            ->where('customers_wishlist.status',1)
            ->select('supplier_profile.name as sname','customers_wishlist.*','services.name as service_name','supplier_services.*','customers_wishlist.id as wish_id','supplier_services.business_name','customers_wishlist.created_at')
            ->get();
            foreach ($wishlist as $key => $value) {
                $date = strtotime($value->created_at);
                $wishlist[$key]->created_at = date('d-m-Y H:i:s',$date);
             }
        return Response::json($wishlist);
    }
}
