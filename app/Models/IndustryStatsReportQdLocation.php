<?php
namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use App\Models\Supplier_services;
class IndustryStatsReportQdLocation extends Model
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

   $TotalViewedSupplierByLocation = [];

   $location_id = $this->id;
    $supplierServicesList = Supplier_services::select('id','location')->get();    

   if(count($supplierServicesList)){
    for($i=0;$i<count($supplierServicesList);$i++){
    $locations = $supplierServicesList[$i]->location;

      $analytics = [];
    foreach($locations as $location)
        {
            if($location==$location_id){
               $total_analytics = DB::table("booking")
                  ->where('booking.supplier_services_id',$supplierServicesList[$i]->id)
                  ->count(); 
                  array_push($TotalViewedSupplierByLocation, $total_analytics);
            }  
        }
    }
}

return  array_sum($TotalViewedSupplierByLocation);
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
