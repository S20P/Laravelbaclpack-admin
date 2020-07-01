<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bookings;
use DB;
class Payments extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'payment';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['booking_id','supplier_id','amount','payment_status','paid_unpaid','payment_date','comment'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

   /* $payment_details = DB::table("booking")->where('booking.supplier_id',$supplier_id)
    ->join('payment', 'payment.booking_id', '=', 'booking.id')
    ->join('services', 'services.id', '=', 'booking.service_id')
    ->join('events', 'events.id', '=', 'booking.event_id')
    ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id')
    ->select('booking.*','payment.amount as payment_amount','payment.paid_unpaid','payment.payment_date','payment.booking_id','customer_profile.name as customer_name','services.name as service_name','events.name as event_name')
    ->get();*/
 

   public function booking_link() {
          //$url_booking_view = backpack_url('bookings/').'?booking_id='.$this->booking_id;
          //return "<a href='".$url_booking_view."'>".$this->booking_id."</a>";

      $booking_id = $this->booking_id;
      $action_url = route('booking_payment_info',$booking_id);
      

$html = "<button type='button' id='BookingDetailsModel' class='btn btn-primary' data-url='".$action_url."'  data-id='".$this->booking_id."'>".$booking_id."</button>";  
return $html;

   }


     public function booking_date() {
        $callback_value ="";
        $Result = $this->BookingDetails();
        if($Result){
           $callback_value = $Result->booking_date;
        }
        return $callback_value; 
      }

      public function supplier_name() {
        $callback_value ="";
        $Result = $this->BookingDetails();
        if($Result){
           $callback_value = $Result->supplier_name;
        }
        return $callback_value;
      }

      public function customer_name() {
        $callback_value ="";
        $Result = $this->BookingDetails();
        if($Result){
           $callback_value = $Result->customer_name;
        }
        return $callback_value;
      }

      public function service_name() {
        $callback_value ="";
        $Result = $this->BookingDetails();
        if($Result){
           $callback_value = $Result->service_name;
        }
        return $callback_value;
      }

      public function event_name() {
        $callback_value ="";
        $Result = $this->BookingDetails();
        if($Result){
           $callback_value = $Result->event_name;
        }
        return $callback_value;
      }

    public function paid_unpaid_custom_column() {
         $title = "";
         $html = "";
         $comment = $this->comment;
          if($this->paid_unpaid==1){
               
                $html = "<button type='button'  class='btn btn-secondary' data-toggle='tooltip' data-placement='right' title='".$comment."'><i class='fa fa-check-circle'></i></button>";  
          }
          if($this->paid_unpaid==0){
             
                $html = "<button type='button'  class='btn btn-secondary' data-toggle='tooltip' data-placement='right' title='".$comment."'><i class='fa fa-circle'></i></button>";  
          }
    return $html;

      }


     public function BookingDetails() {

        $Results =  DB::table("supplier_services")
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('booking', 'booking.supplier_services_id', '=', 'supplier_services.id')
        ->join('events', 'booking.event_id', '=', 'events.id')
        ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
        ->where('booking.id',$this->booking_id)
        ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*')
        ->first();    

        return $Results;

     }
   
//payment report---
  public function payment_status()
  {
    
    $status = "Pending";
          if($this->paid_unpaid!=0){
               $status = "Successed";
          }

          return $status;

  }  
  public function payment_status_action()
  {
    // $url_use = backpack_url('reports/supplier_payment_details/').'/'.$this->supplier_id;
    //  return "<a href='".$url_use."'>Pay</a>";
            


       $html = "Paid";
         if($this->paid_unpaid==0){
              
              $action_url = backpack_url('reports/update_payment_status');
         $html = "<button type='button' id='payment_action' class='btn btn-primary' data-url='".$action_url."' data-id='".$this->supplier_id."'>Pay</button>";       
            }
         return $html;  

  }  

 public function payment_supplier_name()
    {
        $result = DB::table("supplier_profile")
                    ->join('payment', 'payment.supplier_id', '=', 'supplier_profile.id')
                    ->where('supplier_profile.id',$this->supplier_id)
                    ->value('supplier_profile.name');
                    
          $url_use = backpack_url('reports/supplier_payment_details/').'/'.$this->id;
          return "<a href='".$url_use."'>".$result."</a>";
    }

 public function total_payment_of_supplier()
    {
        $result = DB::table("payment")
                    ->where('supplier_id',$this->supplier_id)
                    ->where('paid_unpaid',0)                    
                    ->sum('amount');
                    

        return $result;
    }  

   public function Commission()
    {
        $total_payment = $this->total_payment_of_supplier();
                    
        $commission = $total_payment*5/100;
        return $commission;
    } 

      public function Pay_to_Supplier()
    {
        $total_payment = $this->total_payment_of_supplier();
                    
        $commission = $total_payment*5/100;

        $result = $total_payment - $commission; 
        return $result;
    } 
     
    public function payment_date()
    {
        $result = DB::table("payment")
                    ->where('id',$this->id)
                    //->where('supplier_id',$this->supplier_id)

                     ->value('payment_date');
                   //  ->select("DATE_FORMAT(payment.payment_date, '%d-%M-%Y') as payment_date")

                   //->first();
       
       if($result){
        $result = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result)->format('d-m-Y');
       }
        return $result;
    } 





    /*
    |---------------
    -----------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    
    public function Bookings()
    {
        return $this->belongsTo('App\Models\Bookings','id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
