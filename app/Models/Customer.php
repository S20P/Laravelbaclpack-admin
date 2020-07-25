<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $guard = 'customer';
    protected $table = 'customer_profile';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['user_id','password','password_string','name','email','phone','status','image'];   
    protected $hidden = ['password', 'remember_token','password_string'];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function thumbnail_image() {
        $profileimage = asset('/').$this->image;
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

    public function setImageAttribute($value)
    {
        // $attribute_name = "image";
        // $disk = "public";
        // $destination_path = "uploads/Customer";

        // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

        $attribute_name = "image";
        $disk = "public";
        $destination_path = "uploads/Customer";
        $upload_imagename = md5($value->getClientOriginalName().random_int(1, 9999).time()).'.'.$value->getClientOriginalExtension();
        $upload_url = public_path($destination_path).'/'.$upload_imagename;
        $filename = compress_image($_FILES["image"]["tmp_name"], $upload_url, 40);
        $file_path = $destination_path.'/'.$upload_imagename;
        $this->attributes[$attribute_name] = $file_path;


    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

}
