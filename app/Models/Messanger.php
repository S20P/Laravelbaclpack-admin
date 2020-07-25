<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Supplier_services;
class Messanger extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'customers_inquiry';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['customer_id','supplier_services_id','message'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function supplier_name() {
        $callback_value ="";
        $Result = $this->MessangerDetails();
        if($Result){
           $url_profile_details = backpack_url('supplier/').'?profile_id='.base64_encode($Result->supplier_id);
           $callback_value = '<a href='.$url_profile_details.' target="_blank">'.$Result->supplier_name.'</a>';
        }
        return $callback_value;
       }

      public function customer_name() {
        $callback_value ="";
        $Result = $this->MessangerDetails();
        if($Result){
           //$callback_value = $Result->customer_name;
           $url_profile_details = backpack_url('customer/').'?profile_id='.base64_encode($Result->customer_id);
           $callback_value = '<a href='.$url_profile_details.' target="_blank">'.$Result->customer_name.'</a>';
        }
        return $callback_value;
      }

      public function service_name() {
        $callback_value ="";
        $Result = $this->MessangerDetails();
        if($Result){
           $callback_value = $Result->service_name;
        }
        return $callback_value;
      }

  public function last_message_date() {
        $callback_value ="";
        $Result = $this->MessangerDetails();
        if($Result){
           $date = $Result->created_at;
         $callback_value =   \Carbon\Carbon::parse($date)->format('d-m-yy');
        }
        return $callback_value;
      }


    public function MessangerDetails() {

        $Results =  DB::table("customers_inquiry")
        ->join('supplier_services', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('customer_profile', 'customers_inquiry.customer_id', '=', 'customer_profile.id') 
        ->where('customers_inquiry.supplier_services_id',$this->supplier_services_id)
        ->where('customers_inquiry.customer_id',$this->customer_id)
        ->select('supplier_profile.id as supplier_id','supplier_profile.name as supplier_name','customer_profile.id as customer_id','customer_profile.name as customer_name','services.name as service_name','customers_inquiry.*')
        ->distinct('customers_inquiry.customer_id')
        ->first();    

        return $Results;

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
