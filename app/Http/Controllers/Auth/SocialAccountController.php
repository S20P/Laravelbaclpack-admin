<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\Models\Supplier;
use App\Models\Customer;
use Redirect;
use Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Mail;
use App\Models\EmailTemplatesDynamic as EmailTemplate;

class SocialAccountController extends Controller
{

	use AuthenticatesUsers;

	protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        // $this->middleware('guest');
        // $this->middleware('guest:customer');
        // $this->middleware('guest:supplier');
        // $this->middleware('guest:backpack');
    }
    public  function registerandLogin(Request $request)
    {   
      	$name = $request->name;
        $email = $request->email;
        
        if($request->email==null){
            $email = "testfacke@gmail.com";
        }

    	if (Customer::where('email', $email)->exists()) {
            // Login
            
    		$customer_profile = Customer::select('status','email','id','password_string')->where('email', $email)->first();
            if($customer_profile){
                $profile_status =  $customer_profile->status;
                $password =  $customer_profile->password_string;
                if($profile_status=="Disapproved"){
                         return response()->json(["success" => true, "approved"=> false,"message" => "Your Profile is under Review."]);
                }
                else{
                     if (Auth::guard('customer')->attempt(['email' => $email, 'password' => 123456], true)) {
                        return response()->json(["success"=>true,"flag"=>1, "approved"=> true, "route"=> route('customer.dashboard')]);
                         // return redirect()->route('customer.dashboard');
                    } else {
                        return response()->json(["error"=>true,"role"=>"invalid", "approved"=> false ,"message"=>"Email already in use! Try other method of login."]);
                    }
                }
            }

    	}else{
            $check_mail = Customer::where('email',$email)->first();
            if($check_mail){
               return response()->json(['error'=>'Email already in use! Try other method of login.']);
            }
       else{

            if($request->email==null){
                $email = "testfacke@gmail.com";
            }

    		// Register and Login
    		$Customer = Customer::insertGetId([
            'user_id' => 0,
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('123456'),
            'password_string' => 123456,
            'image' => '/images/avtar.png', 
            'status'=>'Approved'
           ]);
           $data = array(
            'name'=>$name,
           );
	   		if($Customer){

                if (Auth::guard('customer')->attempt(['email' => $email, 'password' => 123456], true)) {
                    return response()->json(["success"=>true,"flag"=>1, "approved"=> true, "route"=> route('customer.dashboard')]);
                     // return redirect()->route('customer.dashboard');
                } else {
                    return response()->json(["error"=>true,"role"=>"invalid", "approved"=> false ,"message"=>"Email already in use! Try other method of login."]);
                }


                /*
                * @Author: Satish Parmar
                * @ purpose: This helper function use for send dynamic email template from db.
                */

                // $customer_id = $Customer;
                // $verificationLink = route('customer-verificationLink',base64_encode($customer_id));

                //     $template = EmailTemplate::where('name', 'Customer-VerificationLink')->first();
                //     $to_mail = $email;
                //     $to_name = $name;
                //     $view_params = [
                //         'name'=>$name, 
                //         'base_url' => url('/'),
                //         'verificationLink' => $verificationLink
                //     ];
                    // in DB Html bind data like {{firstname}}
                  //  send_mail_dynamic($to_mail,$to_name,$template,$view_params);
                /* @author:Satish Parmar EndCode */
               // return response()->json(["success" => true, "message" => "Thank you! Please check your email for next steps."]);
               // return response()->json(["success" => true, "message" => "Your Profile is Successfully Register"]);

            }
            return response()->json(["error" => true, "message" => "Something went wrong."]);
        }
	        
    	}
    }
}
