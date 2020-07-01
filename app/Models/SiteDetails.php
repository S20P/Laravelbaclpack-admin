<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SiteDetails extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'site_details';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['contact_number','contact_email','address','logo1','logo2','currency_code','currency_symbol','pagination_per_page','stripe_key','stripe_secret','instagram_user_id','instagram_secret','number_of_feeds'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

        public function thumbnail_logo1() {
            $profileimage = asset('/').$this->logo1;
            return   "<img src='".$profileimage."' height='auto' width='80px'>";
        }

        public function thumbnail_logo2() {
            $profileimage = asset('/').$this->logo2;
            return   "<img src='".$profileimage."' height='auto' width='80px'>";
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

    public function setLogo1Attribute($value)
    {
        $attribute_name = "logo1";
        $disk = "public";
        $destination_path = "uploads/";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

    public function setLogo2Attribute($value)
    {
        $attribute_name = "logo2";
        $disk = "public";
        $destination_path = "uploads/";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

}
