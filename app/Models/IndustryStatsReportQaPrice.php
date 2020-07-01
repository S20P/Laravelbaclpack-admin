<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use App\Models\Supplier_services;
class IndustryStatsReportQaPrice extends Model
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
		$supplierServicesList = Supplier_services::where('price_range',$this->status)->get();

		$serviceGroup = $supplierServicesList->count();

		return $serviceGroup;
         
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
