<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use DB;
class Analytics extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'analytics';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['customer_id','supplier_services_id','slug','analytics_event_type','image_url','date'];
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

          public function supplier_name() {
        $callback_value ="";
        $Result = $this->getSupplierServiceDetails();
        if($Result){
           $callback_value = $Result->supplier_name;
        }
        return $callback_value;
      }

    public function getSupplierServiceDetails() {
        $Results =  DB::table("supplier_services")
        ->join('analytics', 'supplier_services.id', '=', 'analytics.supplier_services_id')
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
         ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('customer_profile', 'analytics.customer_id', '=', 'customer_profile.id') 
        ->where('supplier_services.id',$this->supplier_services_id)
        ->distinct('analytics.customer_id')
        ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','services.name as service_name')
        ->first();  
        return $Results;
    } 


   public function AnalyticsDetails() {

    $Results =  DB::table("supplier_services")
        ->join('analytics', 'supplier_services.id', '=', 'analytics.supplier_services_id')
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('customer_profile', 'analytics.customer_id', '=', 'customer_profile.id') 
        ->where('analytics.supplier_services_id',$this->supplier_services_id)
        ->distinct('customer_profile.name')
        ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','services.name as service_name')
        ->first();           

        return $Results;

     }


  public function supplier_name_analytics()
     {
                 $callback_value ="";
        $Result = $this->AnalyticsDetails();
        if($Result){
           $callback_value = $Result->supplier_name;
        }
        return $callback_value;    
    }

     public function customer_name_analytics()
     {
                 $callback_value ="";
        $Result = $this->AnalyticsDetails();
        if($Result){
           $callback_value = $Result->customer_name;
        }
        return $callback_value;    
    }

     public function service_name_analytics()
     {
                 $callback_value ="";
        $Result = $this->AnalyticsDetails();
        if($Result){
           $callback_value = $Result->service_name;
        }
        return $callback_value;    
     }

    public function total_impressions()
     {
     $Results =  DB::table("analytics")
                  ->where('analytics.supplier_services_id',$this->supplier_services_id)
                  ->where('analytics.analytics_event_type',"impressions")
                   ->distinct('analytics.customer_id')
                   ->count();  
        return $Results;     
    }

     public function total_email_view()
     {
     $Results =  DB::table("analytics")
                  ->where('analytics.supplier_services_id',$this->supplier_services_id)
                  ->where('analytics.analytics_event_type',"email_view")
                  ->distinct('analytics.customer_id')
                  ->count();  
        return $Results;     
    }

     public function total_mobile_view()
     {
     $Results =  DB::table("analytics")
                  ->where('analytics.supplier_services_id',$this->supplier_services_id)
                  ->where('analytics.analytics_event_type',"mobile_view")
                  ->distinct('analytics.customer_id')
                  ->count();  
        return $Results;     
    }

     public function total_enquiries()
     {
     $Results =  DB::table("analytics")
                  ->join('customers_inquiry', 'customers_inquiry.supplier_services_id', '=', 'analytics.supplier_services_id')
                  ->where('analytics.supplier_services_id',$this->supplier_services_id)
                   ->distinct('analytics.customer_id')
                   ->count();  
        return $Results;     
    }
     public function total_photo_view()
     {
     $Results =  DB::table("analytics")
                  ->where('analytics.supplier_services_id',$this->supplier_services_id)
                  ->where('analytics.analytics_event_type',"photo_view")
                  ->distinct('analytics.customer_id')
                  ->count();  
        return $Results;     
    }
     public function total_clicks_view()
     {
     $Results =  DB::table("analytics")
                  ->where('analytics.supplier_services_id',$this->supplier_services_id)
                  ->where('analytics.analytics_event_type',"clicks_view")
                  ->distinct('analytics.customer_id')
                  ->count();  
        return $Results;     
    }








    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function supplier_services()
    {
        return $this->hasOne('App\Models\Supplier_services','id');
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

    public function setImageUrlAttribute($value)
    {

        $attribute_name = "image_url";
        $disk = "public";
        $destination_path = "uploads";
        $upload_imagename = md5($value->getClientOriginalName().random_int(1, 9999).time()).'.'.$value->getClientOriginalExtension();
        $upload_url = public_path($destination_path).'/'.$upload_imagename;
        $filename = compress_image($_FILES["image_url"]["tmp_name"], $upload_url, 40);
        $file_path = $destination_path.'/'.$upload_imagename;
        $this->attributes[$attribute_name] = $file_path;

        // $attribute_name = "image_url";
        // $disk = "public";
        // $destination_path = "uploads/";

        // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

}
