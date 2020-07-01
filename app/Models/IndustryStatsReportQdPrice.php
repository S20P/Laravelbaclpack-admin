<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use App\Models\Supplier_services;
class IndustryStatsReportQdPrice extends Model
{
      use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */  

    protected $table = 'price_range';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['range','status','symbol'];
    // protected $hidden = [];
    // protected $dates = [];
//-----------------------------------------------------------
          // price_range = ["low","medium","high"];
          // status = [1,2,3];
          // symbol = ['€','€€',€€€'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
  

	public function PriceRange()
	{
  		return $this->symbol." - ".$this->range." price";
	}

	    public function TotalSupplierByPrice()
    {
           $Results =  DB::table("booking")
            ->join('supplier_services', 'supplier_services.id', '=', 'booking.supplier_services_id')
                  ->where('supplier_services.price_range',$this->status)
                  ->count(); 

                  // SELECT * FROM `analytics` WHERE `supplier_services_id` = 29 AND `analytics_event_type` = 'clicks_view'

        return $Results;         
     }
   
     
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */   

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
