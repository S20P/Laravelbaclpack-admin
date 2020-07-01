<?php
namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use App\Models\Supplier_services;
class IndustryStatsReportQaLocation extends Model
{
      use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */  

    protected $table = 'location';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['location_name','city','state_province','postal_code','country'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
  

 




public function TotalSupplierByLocation()
{
	$supplierServicesList = Supplier_services::get();

	$serviceGroup = $supplierServicesList->pluck('location');

	$myLocations = [];
	$supplierByLocation = [];

	foreach($serviceGroup as $locations)
	{
	    foreach($locations as $location)
        {
            if(array_key_exists($location,$supplierByLocation))
	        {
	            $supplierByLocation[$location]++;
	        }
	        else
	        {
	            $supplierByLocation[$location] = 1;
            	array_push($myLocations,$location);
	        }
        }
	}

            return $supplierByLocation[$this->id];           
	
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
