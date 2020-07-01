<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Mail;
use Validator;
use Session;
use DB;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Supplier_services;
use Illuminate\Support\Facades\Hash;
use App\Models\EmailTemplatesDynamic as EmailTemplate;

class CustomResetPasswordController extends Controller
{
    public function getResetPasswordForm($role)
    {
        return view('auth.ResetPasswod.reset_password',['role' => $role]);
    }

    public function postResetPasswordEmail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if (!$validator->fails()) {
          
            $role = $request->role;
            $email = request()->input('email');

            $token = str_random(10);

            if($role=="supplier"){

                // $user = Supplier::where('email', $email)->first();
                $user = Supplier_services::join('supplier_profile','supplier_services.supplier_id','=','supplier_profile.id')
                ->where('email', $email)
                ->first();

                Supplier::where('email', $email)->update([
                    "remember_token" => $token,
                ]);
                 if($user){
            	 $user_name = $user->business_name;
            	}
                 

            }
            if($role=="customer"){
                $user = Customer::where('email', $email)->first();
                Customer::where('email', $email)->update([
                    "remember_token" => $token,
                ]);
                if($user){
            	 $user_name = $user->name;
            	}
            }

            
            if ($user) {
               
               
              
                $data = array(
                    'actionUrl'=>$token, 
                    'email'=>$email, 
                    "user_name"=>$user_name,
                    "role"=>$role
                   );
                   
                    // Mail::send("auth.ResetPasswod.emails.SendReserPasswordLink",$data, function($message) use ($user)
                    // {
                    //     $message->subject(config('app.name') . ' Password Reset');
                    //     $message->to($user->email);
                    // });

                    $resetPassword_link =  url('/resetPassword').'/'.$email.'/'.$role.'/'.$token;

                    /*
                    * @Author: Satish Parmar
                    * @ purpose: This helper function use for send dynamic email template from db.
                    */
                    $template = EmailTemplate::where('name', 'Reset-Password-Link')->first();
                    $to_mail = $user->email;
                    $to_name = "Party Perfect";
                    $view_params = [
                        'app_name'=>$to_name, 
                        "user_name"=>$user_name,
                        "resetPassword_link"=>$resetPassword_link,
                        'base_url' => url('/'),
                    ];
                    // in DB Html bind data like {{firstname}}
                    send_mail_dynamic($to_mail,$to_name,$template,$view_params);
        
                /* @author:Satish Parmar EndCode */
              

                Session::flash('success', "Mail sent successfully.");
                return back();

            } else {

                Session::flash('error', "User not Found for this Email Address.");
                return back();

            }

        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function resetPassword(Request $request,$email,$role,$verificationLink)
    {

        if($role=="supplier"){
            $user = Supplier::where('email', $email)->where('remember_token', "=", $verificationLink)->first();
          
        }
        if($role=="customer"){
            $user = Customer::where('email', $email)->where('remember_token', "=", $verificationLink)->first();
        }
        $userid = $user->id;
        $data["userid"] = $userid;
        $data["role"] = $role;

        return view('auth.ResetPasswod.new_password', $data);
    }

    public function newPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if (!$validator->fails()) {
            $param = $request->all();
            $userid = $param['userid'];
            $role = $param['role'];
           
            $new_password = $param['new_password'];
            $data["password"] = Hash::make($new_password);

                    if($role=="supplier"){
                        $updated_status = Supplier::where("id", $userid)->update($data);
                    }
                    if($role=="customer"){
                        $updated_status = Customer::where("id", $userid)->update($data);
                    }
                    Session::flash('success', "Password Reset successfully.");
                  
                 return redirect()->route("home");

        } else {

            return redirect()->back()->withInput()->withErrors($validator);
        }
    }
}
