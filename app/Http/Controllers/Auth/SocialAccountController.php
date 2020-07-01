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
        $this->middleware('guest');
        $this->middleware('guest:customer');
        $this->middleware('guest:supplier');
        $this->middleware('guest:backpack');
    }
    public  function registerandLogin(Request $request)
    {
    	$name = $request->name;
    	$email = $request->email;
    	if (Customer::where('email', $email)->exists()) {
    		// Login
    		$customer_profile = Customer::select('status','email','id')->where('email', $email)->first();
            if($customer_profile){
                $profile_status =  $customer_profile->status;
                if($profile_status=="Disapproved"){
                        // Session::flash('info', "Your Profile is under Review.");
                        // return Redirect::back();
                         return response()->json(["success" => true, "approved"=> false,"message" => "Your Profile is under Review."]);

                }
                else{

                	 if (Auth::guard('customer')->attempt(['email' => $email, 'password' => '123'],true)) {
 						
 						Customer::where('email', $email)
				            ->update(['remember_token' => null]);
				   //          dd('hii');
 						 return response()->json(["success" => true,"approved"=> true]);
			           
			         }
                	// Auth::login($customer_profile, true);


            //     	$validator = $request->validate(['email' => 'required']);
            //     	if (Auth::attempt($validator)) {
		          // 		dd('hiii');
		          //    	return redirect()->route('customer.dashboard');
	         		// }
	         		// else{
	         		// 	dd('esle');
	         		// }
                }
            }

    	}else{
    		// Register and Login
    		$Customer = Customer::create([
            'user_id' => 0,
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('123'),
            'image' => '/images/avtar.png', 
           ]);
           $data = array(
            'name'=>$name,
           );
	   		if($Customer){
	            // Mail::send("emails.Customer_Profile_Register_Welcome",$data, function($message) use ($email, $name)
	            // {
	            //     $message->to($email, $name)->subject('Welcome!');
                // });
                
                /*
                * @Author: Satish Parmar
                * @ purpose: This helper function use for send dynamic email template from db.
                */
                    $template = EmailTemplate::where('name', 'CustomerProfile-Register')->first();
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
	        return response()->json(["success" => true, "message" => "Your Profile is Successfully Register."]);

    	}
    }
    
}
