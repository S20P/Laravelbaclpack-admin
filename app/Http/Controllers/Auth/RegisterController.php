<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Http\Request;
use Mail;
use Session;
use App\Models\SupplierCategory;
use DB;
use App\Models\EmailTemplatesDynamic as EmailTemplate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    //     $this->middleware('guest:customer');
    //     $this->middleware('guest:supplier');
    //     $this->middleware('guest:backpack');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }



    //Supplier Register -------------------------

    public function showSupplierRegisterForm()
    {
        $Category =  SupplierCategory::orderBy('name', 'ASC')->get();
        $Category = $Category->pluck('name');
        return view('auth.supplierRegister', ['url' => 'supplier','Category'=>$Category]);
    }

    protected function createSupplier(Request $request)
    {
       // $this->validator($request->all())->validate();

        $messages = [
            'name.required' => 'The Name field is required.',
            'email.required' => 'The Email field is required.',
            'phone.required' => 'The Phone field is required.',
            'image.required' => 'The Image field is required.',
            'service_name.required' => 'The Service Name field is required.',
            'business_name.required' => 'The Business Name field is required.',
            'category.required' => 'The  category field is required.',
            'service_description.required' => 'The  Service description field is required.',
            'location.required' => 'The  Location field is required.',
            'pricing_category.required' => 'The  Pricing Category field is required.',
            'event_type.required' => 'The  Event Type field is required.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' =>  ['required', 'string', 'email', 'max:255','unique:supplier_profile'],
            'phone' => ['required', 'numeric'],
            'image' => 'required',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'service_name' => 'required',
            'business_name' => 'required',
            'category' => 'required',
            'event_type' => 'required',
            'service_description' => 'required',
            'location' => 'required',
            'pricing_category' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }   
    

       $supplier = Supplier::create([
        'user_id' => 0,
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => Hash::make($request['password']),
        'password_string' => $request['password'],
        'phone' => $request['phone'],
        'image' => '/images/avtar.png',      
        'service_name' => $request['service_name'],
        'business_name' => $request['business_name'],
        'category' => $request['category'],
        'service_description' => $request['service_description'],
        'event_type' => $request['event_type'],
        'location' => $request['location'],
        'pricing_category' => $request['pricing_category'],
       ]);

       $image = $request->file('image');
       $imagename = time().'.'.$image->getClientOriginalExtension();
       $destinationPath = public_path('/uploads/Supplier/');
       $image->move($destinationPath, $imagename);
        
       $insertedsupplierID = $supplier->id;
       $supplier = Supplier::where('id',$insertedsupplierID)
        ->update([
            'image' => "/uploads/Supplier/".$imagename,
          ]);   
        
       $name = $request['name'];
       $email = $request['email'];
       $data = array(
        'name'=>$name,
       );
     
     
    if($supplier){
        // Mail::send("emails.Profile_Register_Welcome",$data, function($message) use ($email, $name)
        // {
        //     $message->to($email, $name)->subject('Welcome!');
        // });
                   /*
                    * @Author: Satish Parmar
                    * @ purpose: This helper function use for send dynamic email template from db.
                    */
                    $template = EmailTemplate::where('name', 'Profile_Register_Welcome')->first();
                    $to_mail = $email;
                    $to_name = $name;
                    $view_params = [
                        'business_name'=> $request['name'],
                        'base_url' => url('/'),
                    ];
                    // in DB Html bind data like {{firstname}}
                    send_mail_dynamic($to_mail,$to_name,$template,$view_params);

                /* @author:Satish Parmar EndCode */
     


        }
        
        Session::flash('success', "Thank you! Please check your email for next steps.");
        return redirect('supplier/login');
       // return redirect()->intended('supplier/login');
    }

    //customer Register ------------------------

    public function showCustomerRegisterForm()
    {
        return view('auth.customerRegister', ['url' => 'customer']);
    }
    
    protected function createCustomer(Request $request)
    {
     //   $this->validator($request->all())->validate();
     $messages = [
        'name.required' => 'The Name field is required.',
        'email.required' => 'The Email field is required.',
        'phone.required' => 'The Phone field is required.',
        'image.required' => 'The Image field is required.',
      ];

        $validator = Validator::make($request->all(), [
            'email' =>  ['required', 'string', 'email', 'max:255','unique:customer_profile'],
            'phone' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'image' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
           
        $Customer = Customer::create([
            'user_id' => 0,
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password_string' => $request['password'],
            'password' => Hash::make($request['password']),
            'image' => '/images/avtar.png', 
           ]);

           $image = $request->file('image');
           $imagename = time().'.'.$image->getClientOriginalExtension();
           $destinationPath = public_path('/uploads/Customer/');
           $image->move($destinationPath, $imagename);
    
           $insertedCustomerID =  $Customer->id;

           $supplier = Customer::where('id',$insertedCustomerID)
            ->update([
                'image' => "/uploads/Customer/".$imagename,
              ]);  

           $name = $request['name'];
           $email = $request['email'];
           $data = array(
            'name'=>$name,
           );
            

        if($Customer){
            // Mail::send("emails.Customer_Profile_Register_Welcome",$data, function($message) use ($email, $name)
            // {
            //     $message->to($email, $name)->subject('Party Perfect !');
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

            Session::flash('success', "Thank you! Please check your email for next steps.");
            return redirect('customer/login');

       // return redirect()->intended('customer/login');
    }


    public function register(Request $request)
    {

     $messages = [
        'name.required' => 'The Name field is required.',
        'email.required' => 'The Email field is required.',
      ];

   
      $name = $request['name'];
      $email = $request['email'];
       
             $check_mail = Customer::where('email',$email)->first();
             if($check_mail){
                return response()->json(['error'=>'Email already in use!']);
             }else{

                $Customer = Customer::insertGetId([
                    'user_id' => 0,
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password_string' => $request['password'],
                    'password' => Hash::make($request['password']),
                   // "status"=>'Approved',
                    'image' => '/images/avtar.png', 
                   ]);
                 
                   $data = array(
                    'name'=>$name,
                   );
        
                if($Customer){
                    // Mail::send("emails.Customer_Profile_Register_Welcome",$data, function($message) use ($email, $name)
                    // {
                    //     $message->to($email, $name)->subject('Party Perfect !');
                    // });
            
           
            /*
            * @Author: Satish Parmar
            * @ purpose: This helper function use for send dynamic email template from db.
            */
            $customer_id = $Customer;
            $verificationLink = route('customer-verificationLink',base64_encode($customer_id));

                $template = EmailTemplate::where('name', 'Customer-VerificationLink')->first();
                $to_mail = $email;
                $to_name = $name;
                $view_params = [
                    'name'=>$name, 
                    'base_url' => url('/'),
                    'verificationLink' => $verificationLink
                ];
            // in DB Html bind data like {{firstname}}
            send_mail_dynamic($to_mail,$to_name,$template,$view_params);
  
            /* @author:Satish Parmar EndCode */


                }

        
                    // Session::flash('success', "Your Profile is Successfully Register.");
                    // return redirect()->route('home');

                return response()->json(['success'=>'Thank you! Please check your email for next steps.']);
}
        
   
         
        // $Customer = Customer::create([
        //     'user_id' => 0,
        //     'name' => $request['name'],
        //     'email' => $request['email'],
        //     'phone' => $request['phone'],
        //     'password' => Hash::make($request['password']),
        //     'image' => '/images/avtar.png', 
        //    ]);

        //    $image = $request->file('image');
        //    $imagename = time().'.'.$image->getClientOriginalExtension();
        //    $destinationPath = public_path('/uploads/Customer/');
        //    $image->move($destinationPath, $imagename);
    
        //    $insertedCustomerID =  $Customer->id;

        //    $supplier = Customer::where('id',$insertedCustomerID)
        //     ->update([
        //         'image' => "/uploads/Customer/".$imagename,
        //       ]);  
            
        //    $name = $request['name'];
        //    $email = $request['email'];
        //    $data = array(
        //     'name'=>$name,
        //    );
            

        // if($Customer){
        //     Mail::send("emails.Profile_Register_Welcome",$data, function($message) use ($email, $name)
        //     {
        //         $message->to($email, $name)->subject('Welcome!');
        //     });
        //     }


            // return response()->json(['error'=>'Your Profile is not Register.']);

            // Session::flash('success', "Your Profile is Successfully Register.");
            // return redirect('customer/login');

       // return redirect()->intended('customer/login');
    }


    




}
