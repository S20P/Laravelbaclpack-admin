<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use DB;
class SupplierReviews extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'supplier_reviews';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['customer_id','supplier_services_id','content_review','status','rates'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function service_name() {
        $callback_value ="";
        $Result = $this->getSupplierServiceDetails();
        if($Result){
           $callback_value = $Result->service_name;
        }
        return $callback_value;
      }

      public function customer_name() {
        $callback_value ="";
        $Result = $this->getSupplierServiceDetails();
        if($Result){
           $callback_value = $Result->customer_name;
        }
        return $callback_value;
      }

    public function getSupplierServiceDetails() {
        $Results =  DB::table("supplier_services")
        ->join('supplier_reviews', 'supplier_services.id', '=', 'supplier_reviews.supplier_services_id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('customer_profile', 'supplier_reviews.customer_id', '=', 'customer_profile.id') 
        ->where('supplier_services.id',$this->supplier_services_id)
        ->select('customer_profile.name as customer_name','services.name as service_name')
        ->first();  
        return $Results;
    } 

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function getSupplierReviews()
    {
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }
    public function supplier_services()
    {
        return $this->hasOne('App\Models\Supplier_services','id');
    }

     public function supplier_services_review()
    {
        return $this->hasMany('App\Models\Supplier_services','supplier_id');
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
