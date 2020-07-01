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
use Mail;
use App\Models\EmailTemplatesDynamic as EmailTemplate;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('guest:customer')->except('logout');
        /*$this->middleware('guest:supplier')->except('logout');
        $this->middleware('guest:backpack')->except('logout');*/
      //auth('admin')->logout();
    }

 
    public function ProfileLogin(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        //Checkk Profile Status
        $profile_type = $request->profile_type;
        $email = $request->email;
        if($profile_type=="supplier"){

            $Supplier_profile = Supplier::select('status')->where('email', $email)->first();
            if($Supplier_profile){
                $profile_status =  $Supplier_profile->status;
                if($profile_status=="Disapproved"){
                    return response()->json(["success"=>false,"role"=>"review","message"=>"Your profile is under review."]);
                        // Session::flash('info', "Your Profile is under Review.");
                        // return Redirect::back();
                }
            }
         
            if (Auth::guard('supplier')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                 return response()->json(["success"=>true,"flag"=>1,"route"=> route('supplier.dashboard') ]);
                // return redirect()->route('supplier.dashboard');
            } else {
                return response()->json(["success"=>false,"role"=>"invalid","message"=>"Login failed! Wrong user credentials."]);
            }

            // Session::flash('error', "Login Failed Wrong User Credentials");
            // return Redirect::back();

        }
        if($profile_type=="customer"){
            // dd($request->all());
            $customer_profile = Customer::select('status')->where('email', $email)->first();
            if($customer_profile){
                $profile_status =  $customer_profile->status;
                if($profile_status=="Disapproved"){
                        return response()->json(["success"=>false,"role"=>"review","message"=>"Your profile is under review."]);
                }
            }
         
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                return response()->json(["success"=>true,"flag"=>1,"route"=> route('customer.dashboard')]);
                 // return redirect()->route('customer.dashboard');
            } else {
                return response()->json(["success"=>false,"role"=>"invalid","message"=>"Login failed! Wrong user credentials."]);
            }

             Session::flash('error', "Login Failed Wrong User Credentials");
             return Redirect::back();
        }
       
        return back()->withInput($request->only('email', 'remember'));
    }
    public function ProfileLoginCustomer(Request $request)
    {
        // dd($request->all());
        Auth::guard('supplier')->logout();
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        //Checkk Profile Status
        $email = $request->email;
        $Customer_profile = Customer::select('status')->where('email', $email)->first();
        if($Customer_profile){
            $profile_status =  $Customer_profile->status;
            if($profile_status=="Disapproved"){
                    // Session::flash('info', "Your Profile is under Review.");
                    // return Redirect::back();
                    return response()->json(["success"=>false,"role"=>"review","message"=>"Your Profile is under Review."]);
            }
        }
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            $user_id = Auth::guard('customer')->user()->id;
            if($request->customer_action == "add_wish"){
                $w_id_check = $w_id = DB::table('customers_wishlist')->where('supplier_services_id',$request->supplier_service_id_popup)->where('customer_id',$user_id)->first();
                if($w_id_check == null){
                     $wish_id = DB::table('customers_wishlist')
                    ->insertGetId(array(
                    'customer_id' => $user_id,
                    'supplier_services_id' => $request->supplier_service_id_popup,
                    "status" =>  1,
                    "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                    "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                    ));
                    return response()->json(["success"=>true,"type"=>"add_wish","flag"=>1]);
                }else{
                    $w_id = DB::table('customers_wishlist')->where('supplier_services_id',$request->supplier_service_id_popup)->where('customer_id',$user_id)->where('status',0)->first();
                    if($w_id != null){
                        DB::table('customers_wishlist')
                        ->where('customer_id', $user_id)
                        ->where('supplier_services_id', $request->supplier_service_id_popup)
                        ->where('status', 0)
                        ->update(['status' => 1]);
                        return response()->json(["success"=>true,"type"=>"add_wish","flag"=>1]);
                    }else{
                        return response()->json(["success"=>true,"type"=>"add_wish","flag"=>2]);
                    }
                    
                }
            }
            if($request->customer_action == "add_review"){
                if(isset($request->rate) && $request->rate != ''){
                    $rate = $request->rate;
                }else{
                    $rate = 0;
                }
                $review_id = DB::table('supplier_reviews')
                ->insertGetId(array(
                'customer_id' => $user_id,
                'supplier_services_id' => $request->supplier_service_id_popup,
                'content_review' => $request->text_reviews,
                "rates" =>  $rate,
                "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
            ));
            return response()->json(["success"=>true,"type"=>"add_review","flag"=>1]);
                // return response()->json(["success"=>true, "message"=>"Your review is submitted successfully."]);
            }
            if($request->customer_action == "add_inquiry"){
                // $user =$this->getUserDetails()->toArray();
                $user = Customer::where('id',$user_id)->first();
                $supplieremail = $request['supplier_email'];
                $suppliername = $request['supplier_name'];
                $suppliermessage = $request['message'];
                $supplier_id = $request['supplier_id'];
                $service_name = $request['service_name'];
                if($user){
                    $inquiry_id = DB::table('customers_inquiry')
                    ->insertGetId(array(
                    'customer_id' => $user->id,
                    'supplier_services_id' => $request['supplier_service_id_popup'],
                    'message' => $suppliermessage,
                    "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                    "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                    ));
                    $data = array(
                    'supplier_name'=>$suppliername,
                    'customer_name'=> $user->name,
                    'customer_email'=> $user->email,
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
                    $template = EmailTemplate::where('name', 'Customer-Inquiry')->first();
                    $to_mail = $supplieremail;
                    $to_name = $suppliername;
                    $messenger_inbox_link = url('/supplier/dashboard/')."#messenger";
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
                    return response()->json(["success"=>true,"type"=>"add_inquiry","flag"=>1]);
                    // return response()->json(["success"=>true, "message"=>"Your inquiry is submitted successfully."]);
                    
                }
            }
            // return redirect()->route('customer.dashboard');
        }else{
            return response()->json(["success"=>false,"role"=>"invalid","message"=>"Login failed! Wrong user credentials."]);
            // dd('Login Failed! Wrong User Credentials');;
        }

        // Session::flash('error', "Login Failed Wrong User Credentials");
        // return Redirect::back();
        // }
        // return back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {

        Auth::guard('supplier')->logout();
        Auth::guard('customer')->logout();
        // $request->session()->flush();
        // $request->session()->regenerate();
        return redirect('/');
    }
    
}
