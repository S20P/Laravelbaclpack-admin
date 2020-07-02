<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Location;
use App\Models\Services;
use DB;

class Supplier extends Authenticatable
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */  
    protected $guard = 'supplier';
    protected $table = 'supplier_profile';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['user_id','password','password_string','name','email','phone','image','status'];
    protected $hidden = ['password', 'remember_token'];
    // protected $dates = [];
  

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function thumbnail_image() {
          $profileimage = url('/').$this->image;
          return   "<img src='".$profileimage."' height='auto' width='80px'>";
    }


    // public function getLocation() {
    //     $location_result =  Location::whereIn('id',$this->location)->select('location_name')->get();
       
    //     $locations = [];
    //     if(count($location_result)){
    //         foreach($location_result as $location){
    //             array_push($locations,$location->location_name);
    //         }
    //     }   

    //     return implode(",<br>",$locations);

    //     return json_encode(implode(",",$locations));

    //   //$locations = json_encode($locations);
    //   // dd(implode(",",$locations));
    //  }

    public function service_name() {
        $callback_value ="";
        $Result = $this->getSupplierServiceDetails();
        if($Result){
           $callback_value = $Result->service_name;
        }
        return $callback_value;
      }

    public function getSupplierServiceDetails() {
        $Results =  DB::table("supplier_services")
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->where('supplier_profile.id',$this->id)
        ->select('supplier_profile.name as supplier_name','services.name as service_name')
        ->first(); 
        return $Results;
    } 

    
  
  
    public function Resend_Confirmation_Email()
    {   
        // return '<a data-button-type="Resend Confirmation Email" data-value="resend-email" title="Resend Confirmation Email" href="'. url('admin/supplier/resend-email/'. $this->id) .'" class="btn btn-xs btn-success">Resend Confirmation Email </a>';
        return  '<a  href="'. url('admin/supplier/resend-email/'. $this->id) .'" class="btn btn-sm btn-link"><i class="fa fa-paper-plane-o"></i> Resend Confirmation Email</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function Location()
    {
        return $this->belongsTo('App\Models\Location','id');
    }

    public function Services()
    {
        return $this->hasOne('App\Models\Services','id');
    }

    public function supplier_services()
    {
        return $this->hasOne('App\Models\Supplier_services','supplier_id');
    }

    public function payment_transfer_info_supplier()
    {
        return $this->hasOne('App\Models\SupplierBankingDetails','supplier_id');
    }

    public function supplier_profile()
        {
            return $this->hasOne('App\Models\Supplier','id');
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

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "public";
        $destination_path = "uploads/Supplier";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }


}
