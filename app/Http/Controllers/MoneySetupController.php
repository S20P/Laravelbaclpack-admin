<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe;
use App\Models\Supplier;
use App\Models\Services;
use Mail;
use PDF;
use Illuminate\Support\Facades\Hash;
use App\Models\Supplier_services;
use App\Models\Supplier_assign_events;
use App\Models\EmailTemplatesDynamic as EmailTemplate;
use Exception;
use Auth;
use App\Models\Customer;

class MoneySetupController extends Controller
{
    private  $admin_mail;
    public function paymentStripe()
    {
        return view('paymentstripe');
    }


    public function ValidateCouponStripe(Request $request,$coupon_code=null)
    {

        if($coupon_code!=null){
            try{
                $site = getFooterDetails();
                \Stripe\Stripe::setApiKey($site->stripe_secret);
                $coupon = \Stripe\Coupon::retrieve($coupon_code, []);
        

                // $amount_off = ($coupon->amount_off) / 100;
                // $percentage_off = ($coupon->percent_off);
                // $discountType = array();
                // if($amount_off != ""){
                //     $discountType['type'] = "amount";
                //     $discountType['off'] = $amount_off;
                // }else if($percentage_off != ""){
                //     $discountType['type'] = "percentage";
                //     $discountType['off'] = $percentage_off;
                // }

               if ($coupon->valid) {
                    return response()->json(['success'=>true]);
                }else{
                    return response()->json(['success'=>false]);
                }
                
            }catch(Exception $e) {
               // $errArr['error'] = $e->getMessage();
              //  echo json_encode($errArr);

              return response()->json(['success'=>false]);
            }
        }
        
    }

    

    public function postPaymentStripe(Request $request)
    {
        
        // dd($request->all());
        $site = getFooterDetails();
        if(isset($request->service_id) && isset($site) &&  $site != ''){

            $services =  Services::select('name')->where('id',$request->service_id)->first();
            $service_name = $services->name;
            // $getServices =  DB::table('supplier_services')
            //     ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
            //     ->join('services', 'supplier_services.service_id', '=', 'services.id')
            //     ->where('supplier_services.supplier_id',$request->supplier_id)
            //     ->where('supplier_services.service_id',$request->service_id)
            //    	->select('services.name as service_name','supplier_profile.name as supplier_name','supplier_profile.email as supplier_email','supplier_services.*')
            //     ->first();
               
            try {
            Stripe\Stripe::setApiKey($site->stripe_secret);


            $plan = Stripe\Plan::create(array(
                "product" => [
                    "name" => $request->payer_name.'-'.$service_name,
                    "type" => "service"
                ],
                "nickname" => $request->payer_name.'_'.$service_name,
                "interval" => "month",
                "interval_count" => "1",
                "currency" => $site->currency_code,
                "amount" => $request->service_amount * 100,
            ));
            $customer = Stripe\Customer::create([
                'email' => $request->email,
                'source' => $request->stripeToken,
                'name' => $request->payer_name,
            ]);
            $subscription = Stripe\Subscription::create(array(
                "customer" => $customer->id,
                "items" => array(
                    array(
                        "plan" => $plan->id,
                    ),
                ),
            ));
            $array_response = $subscription->jsonSerialize();
            $json_response = json_encode($array_response,true);

            
            if ($subscription['status'] == 'active')
            {
                $totalLocation = count($request->location);
                $location = array();
                if($totalLocation > 0){

                    foreach ($request->location as $key=>$value){
                        $location[] = $value;
                    }
                }
                $service_id =  $request->service_id;
                $event_ids =  $request->events;
                $supplier = Supplier::create([
                    'user_id' => 0,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'password_string' => $request->password,
                    'phone' => $request->phone,
                   ]);
              
                if($supplier && $service_id){
                    $supplier_id = $supplier->id;
                    $supplier_assign_events =  Supplier_services::create(['supplier_id'=>$supplier_id,'service_id'=>$service_id,'business_name'=>$request->business_name,'service_description'=>$request->service_description,'location' => $request->location,'status'=>'Active','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                    if($supplier_assign_events && $event_ids){
                        foreach ($event_ids as $event_id){
                            $supplier_assign_category_id =  $supplier_assign_events->id;
                            Supplier_assign_events::create(['supplier_services_id'=>$supplier_assign_category_id,'event_id'=>$event_id]);
                        }
                    }
                }
                $pay_id = DB::table('payment_service')
                    ->insertGetId(array(
                        'service_id' => $request->service_id,
                        'supplier_id' => $supplier_id,
                        'subscribe_id' => $array_response['id'],
                        'payment_date' => date('Y-m-d H:i:s'),
                        "response" => $json_response,
                        'amount' => $request->service_amount,
                        "payment_status" =>  $subscription['status'],
                        "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                        "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                    ));
                // $update_data = DB::table('supplier_profile')->where('id', $request->supplier_id)->update(['user_id' => 1,'status' => 'Approved']);
                $supplier_name = $request->name;
                $supplier_email = $request->email;
                $data_supplier =  array(
                	'business_name'=> $request->business_name,
                );
                // $admin_email = $site->contact_email;
                // $admin_name = 'Admin';
                // $data_supplier = array(
                //     'sname'=> $supplier_name,
                //     'mail_type' => 'supplier',
                //     'service'=> $services['name'],
                //     'amount' => $request->service_amount,
                // );
                // $data_admin = array(
                //     'admin_name'=>$admin_name,
                //     'sname'=> $supplier_name,
                //     'mail_type' => 'admin',
                //     'service'=> $services['name'],
                //     'amount' => $request->service_amount,
                // );
              
                 if($pay_id){
                
                    // Mail::send("emails.Profile_Register_Welcome",$data_supplier, function($message) use ($supplier_name, $supplier_email)
		            // {
		            //     $message->to($supplier_email, $supplier_name)->subject('Party Perfect Supplier Application');
                    // });

                    /*
                    * @Author: Satish Parmar
                    * @ purpose: This helper function use for send dynamic email template from db.
                    */
                    $template = EmailTemplate::where('name', 'Profile_Register_Welcome')->first();
                    $to_mail = $supplier_email;
                    $to_name = $supplier_name;
                    $view_params = [
                        'business_name'=> $request->name,
                        'base_url' => url('/'),
                    ];
                    // in DB Html bind data like {{firstname}}
                    send_mail_dynamic($to_mail,$to_name,$template,$view_params);

                /* @author:Satish Parmar EndCode */


                    // Mail::send("emails.ServicePaymentMail",$data_supplier, function($message) use ($supplier_name,$supplier_email)
                    // {
                    //     $message->to($supplier_email, $supplier_name)->subject('Payment Success!');
                    // });
                    // Mail::send("emails.ServicePaymentMail",$data_admin, function($message) use ($admin_name,$admin_email)
                    // {
                    //     $message->to($admin_email,$admin_name)->subject('Payment Success!');
                    // });
                }
                return redirect('Subscribed');

                // return view('thankyou')->with(['message'=>'Your account is successfully created.']);
            }
            else
            {
                return redirect()->route('payerror');
            }


        } catch(\Stripe\Exception\CardException $e) {

            return redirect()->route('payerror');
            
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            // echo 'Status is:' . $e->getHttpStatus() . '\n';
            // echo 'Type is:' . $e->getError()->type . '\n';
            // echo 'Code is:' . $e->getError()->code . '\n';
            // // param is '' in this case
            // echo 'Param is:' . $e->getError()->param . '\n';
            // echo 'Message is:' . $e->getError()->message . '\n';
          } catch (\Stripe\Exception\RateLimitException $e) {
            return redirect()->route('payerror');
            // Too many requests made to the API too quickly
          } catch (\Stripe\Exception\InvalidRequestException $e) {
            return redirect()->route('payerror');
            // Invalid parameters were supplied to Stripe's API
          } catch (\Stripe\Exception\AuthenticationException $e) {
            return redirect()->route('payerror');
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
          } catch (\Stripe\Exception\ApiConnectionException $e) {
            return redirect()->route('payerror');
            // Network communication with Stripe failed
          } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->route('payerror');
            // Display a very generic error to the user, and maybe send
            // yourself an email
          } catch (Exception $e) {
            return redirect()->route('payerror');
            // Something else happened, completely unrelated to Stripe
          }

        } elseif(isset($request->booking_id) && isset($site) &&  $site != ''){
            $getBooking =  DB::table('supplier_services')
                ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                ->join('booking', 'supplier_services.id', '=', 'booking.supplier_services_id')
                ->join('events', 'booking.event_id', '=', 'events.id')
                ->join('services', 'supplier_services.service_id', '=', 'services.id')
                ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id')
                ->where('booking.id',$request->booking_id)
                ->select('booking.id as booking_id','services.name as service_name','supplier_profile.name as sname','customer_profile.name as cname','supplier_profile.*','booking.*','events.name as event_name','supplier_services.*','supplier_profile.id as supplier_id')
                ->first();
                
            // $admin_data = DB::table('customer_profile')->select('customer_profile.user_id')->where('customer_profile.id',$request->customer_id)->first();
//            $admin_email_get = DB::table('users')->select('name','email')->where('id',$admin_data->user_id)->first();

         //return redirect()->route('payerror-booking',["booking_id"=>$request->booking_id]);

            try {

              //  dd("TRY");
                Stripe\Stripe::setApiKey($site->stripe_secret);
                $customer = Stripe\Customer::create([
                    'email' => $request->customer_email,
                    'source' => $request->stripeToken,
                    'name' => $request->payer_name,
                ]);
                // Use Stripe's library to make requests...

                  $booking_amount = $request->booking_amount;

                  if(isset($request->coupon_code) && $request->coupon_code!=null){
                try{

                   // $stripe = new \Stripe\StripeClient($site->stripe_secret);

                    $coupon_code = $request->coupon_code;

                    $coupon = \Stripe\Coupon::retrieve($coupon_code, []);
            
                    $amount_off = ($coupon->amount_off) / 100;
                    $percentage_off = ($coupon->percent_off);
                    // $discountType = array();
                    // if($amount_off != ""){
                    //     $discountType['type'] = "amount";
                    //     $discountType['off'] = $amount_off;
                    // }else if($percentage_off != ""){
                    //     $discountType['type'] = "percentage";
                    //     $discountType['off'] = $percentage_off;
                    // }

                    $booking_amount = $booking_amount - ($request->booking_amount * $percentage_off / 100);
                    
                  
                }catch(Exception $e) {
                    return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                }
            }
            
            
            $charge = Stripe\Charge::create([
                "amount" => $booking_amount * 100,
                "currency" => $site->currency_code,
                "customer" =>$customer->id,
                "description" => "Test payment from PartyPerfect.com."
            ]);
               
                
                $getBooking = (array) $getBooking;
                $array_response = $charge->jsonSerialize();
                $json_response = json_encode($array_response,true);
                if ($charge['status'] == 'succeeded')
                {
                    $pay_id = DB::table('payment')
                        ->insertGetId(array(
                            'booking_id' => $request->booking_id,
                            'supplier_id' => $getBooking['supplier_id'],
                            'amount' => $booking_amount,
                            'payment_date' => date('Y-m-d H:i:s'),
                            "payment_status" =>  $charge['status'],
                            "response" => $json_response,
                            "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                            "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                        ));
                    $update_data = DB::table('booking')->where('id', $request->booking_id)->update(['status' => "complete"]);
                    $supplier_name = $getBooking['name'];
                    $supplier_email = $getBooking['email'];
                    $admin_name = 'Admin';
                    $admin_email = $site->contact_email;
                    $customer_name = $request->customer_name;
                    $customer_email = $request->customer_email;
                    $data_supplier = array(
                        'cname'=> $customer_name,
                        'type' => 'suppliers',
                        'sname'=> $supplier_name,
                    );
                    $data_admin = array(
                        'cname'=> $customer_name,
                        'type' => 'admin',
                        'sname'=> $supplier_name,
                    );
                    $data_customer = array(
                      "getBooking"  => $getBooking,
                      "type" => "customers",
                      'sname'=> $supplier_name,
                    );
                    view()->share('getBooking',$getBooking);
                    $pdf = PDF::loadView('emails.Order_Complete_User');
                    if($pay_id){
                        // Mail::send("emails.Order_Complete",$data_customer, function($message) use ($customer_name, $customer_email, $supplier_name, $pdf)
                        // {
                        //     $message->to($customer_email, $customer_name)->subject($supplier_name.' Payment Complete')->attachData($pdf->output(), "invoice.pdf");
                        // });
                        // Mail::send("emails.Order_Complete",$data_supplier, function($message) use ($supplier_name, $supplier_email, $pdf)
                        // {
                        //     $message->to($supplier_email, $supplier_name)->subject('Party Perfect Payment Complete')->attachData($pdf->output(), "invoice.pdf");
                        // });
                        // Mail::send("emails.Order_Complete",$data_admin, function($message) use ($admin_name, $admin_email, $pdf)
                        // {
                        //     $message->to($admin_email, $admin_name)->subject('Payment complete')->attachData($pdf->output(), "invoice.pdf");
                        // });
    
    
            // Order_Complete type  customers---------------------------
                        /*
                        * @Author: Satish Parmar
                        * @ purpose: This helper function use for send dynamic email template from db.
                        */
                        $template = EmailTemplate::where('name', 'Order-Complete-Customers')->first();
                        $to_mail = $customer_email;
                        $to_name = $customer_name;
                        $view_params = [    
                            'sname'=> $supplier_name,
                            'base_url' => url('/'),
                        ];
                        // in DB Html bind data like {{firstname}}
                        send_mail_dynamic($to_mail,$to_name,$template,$view_params,$pdf->output(), "invoice.pdf");
    
                    /* @author:Satish Parmar EndCode */
    
            // Order_Complete type  customers end---------------------------
    
    
            // Order_Complete type  suppliers---------------------------
                        /*
                        * @Author: Satish Parmar
                        * @ purpose: This helper function use for send dynamic email template from db.
                        */
                        $template = EmailTemplate::where('name', 'Order-Complete-Suppliers')->first();
                        $to_mail = $supplier_email;
                        $to_name = $supplier_name;
                        $view_params = [    
                            'cname'=> $customer_name,
                            'base_url' => url('/'),
                        ];
                        // in DB Html bind data like {{firstname}}
                        send_mail_dynamic($to_mail,$to_name,$template,$view_params,$pdf->output(), "invoice.pdf");
    
                    /* @author:Satish Parmar EndCode */
    
            // Order_Complete type  suppliers end---------------------------
            
             // Order_Complete type  admin---------------------------
                            /*
                            * @Author: Satish Parmar
                            * @ purpose: This helper function use for send dynamic email template from db.
                            */
                            $template = EmailTemplate::where('name', 'Order-Complete-Admin')->first();
                            $to_mail = $admin_email;
                            $to_name = $admin_name;
                            $view_params = [    
                                'cname'=> $customer_name,
                                'sname'=> $supplier_name,
                                'base_url' => url('/'),
                            ];
                            // in DB Html bind data like {{firstname}}
                            send_mail_dynamic($to_mail,$to_name,$template,$view_params,$pdf->output(), "invoice.pdf");
    
                        /* @author:Satish Parmar EndCode */
    
                // Order_Complete type  admin end---------------------------
    
    
                    }
                    return redirect()->route('thankyou');
                }
                else
                {
                    return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                }


              } catch(\Stripe\Exception\CardException $e) {

                return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                
                // Since it's a decline, \Stripe\Exception\CardException will be caught
                // echo 'Status is:' . $e->getHttpStatus() . '\n';
                // echo 'Type is:' . $e->getError()->type . '\n';
                // echo 'Code is:' . $e->getError()->code . '\n';
                // // param is '' in this case
                // echo 'Param is:' . $e->getError()->param . '\n';
                // echo 'Message is:' . $e->getError()->message . '\n';
              } catch (\Stripe\Exception\RateLimitException $e) {
                return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                // Too many requests made to the API too quickly
              } catch (\Stripe\Exception\InvalidRequestException $e) {
                return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                // Invalid parameters were supplied to Stripe's API
              } catch (\Stripe\Exception\AuthenticationException $e) {
                return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
              } catch (\Stripe\Exception\ApiConnectionException $e) {
                return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                // Network communication with Stripe failed
              } catch (\Stripe\Exception\ApiErrorException $e) {
                return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                // Display a very generic error to the user, and maybe send
                // yourself an email
              } catch (Exception $e) {
                return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
                // Something else happened, completely unrelated to Stripe
              }
        }
        else{
            return view('PaymentFailedBooking',["booking_id"=>$request->booking_id]);
        }
    }
    public function getDetails(){
        return DB::table('site_details')->first();
    }
    public function cancelSubscription(Request $request){
        $site = getFooterDetails();
        $subsription = file_get_contents('php://input');
        $subsription_data = json_decode($subsription, true);
        $subscribe_id= $subsription_data['data']['object']['id'];
        // $subscribe_id = "sub_H9l4upLy9SYnIS";
        $get_supplier = DB::table('supplier_profile')
                        ->join('payment_service', 'supplier_profile.id', '=', 'payment_service.supplier_id')
                        ->select('supplier_profile.*')
                        ->where('payment_service.subscribe_id',$subscribe_id)
                        ->first();
        $update_data = DB::table('supplier_profile')->where('id', $get_supplier->id)->update(['user_id' => 0,'status' => 'Disapproved']);
        // dd($customers);
        $supplier_email = $get_supplier->email;
        $supplier_name = $get_supplier->name;
        $data = array(
            'sname' => $supplier_name
        );

        //  Mail::send("emails.Profile_disapprove_supplier",$data, function($message) use ($supplier_email, $supplier_name)
        // {
        //     $message->to($supplier_email, $supplier_name)->subject($supplier_name.' - Subscription disapproved');
        // });

      // Order_Complete type  admin---------------------------
                        /*
                        * @Author: Satish Parmar
                        * @ purpose: This helper function use for send dynamic email template from db.
                        */
                        $template = EmailTemplate::where('name', 'Profile-Disapprove-Supplier')->first();
                        $to_mail = $supplier_email;
                        $to_name = $supplier_name;
                        $view_params = [    
                            'sname'=> $supplier_name,
                            'base_url' => url('/'),
                        ];
                        // in DB Html bind data like {{firstname}}
                        send_mail_dynamic($to_mail,$to_name,$template,$view_params);

                    /* @author:Satish Parmar EndCode */

            // Order_Complete type  admin end---------------------------


    	
        // dd($request->all());
    }
   
}
