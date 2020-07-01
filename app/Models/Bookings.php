<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Supplier_services;

class Bookings extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'booking';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['customer_id','supplier_services_id','event_address','event_id','amount','status','booking_date'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function booking_date() {
        $callback_value ="";
        $Result = $this->BookingDetails();
        if($Result){
           $callback_value =  \Carbon\Carbon::parse($Result->booking_date)->format('d-m-yy');  
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


     public function BookingDetails() {

        $Results =  DB::table("supplier_services")
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('booking', 'booking.supplier_services_id', '=', 'supplier_services.id')
        ->join('events', 'booking.event_id', '=', 'events.id')
        ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
        ->where('booking.id',$this->id)
        ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*')
        ->first();    

        return $Results;
     }
     public function status_type()
     {
         // $status = "pending";

         // if($this->status==1){
         //    $status="complete";
         // }

         return ucfirst($this->status);
     }   

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function SupplierSrvices()
    {
        return $this->belongsTo('App\Models\Supplier_services','id');
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
