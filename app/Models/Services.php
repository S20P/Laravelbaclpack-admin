<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Services extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'services';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
     protected $fillable = ['name','slug','image','image_hover','price','parent_id','lft','rgt','depth'];
    // protected $hidden = [];
    // protected $dates = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


        public function thumbnail_image() {
            $profileimage = asset('/').$this->image;
            return   "<img src='".$profileimage."' height='auto' width='80px'>";
            }


        public function thumbnail_image_hover() {
            $profileimage = asset('/').$this->image_hover;
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

    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->name;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setImageAttribute($value)
    {
       //dd($_FILES["image"]["tmp_name"]);
        $attribute_name = "image";
        $disk = "public";
        $destination_path = "uploads/services";
        $upload_imagename = md5($value->getClientOriginalName().random_int(1, 9999).time()).'.'.$value->getClientOriginalExtension();
        $upload_url = public_path($destination_path).'/'.$upload_imagename;
        $filename = compress_image($_FILES["image"]["tmp_name"], $upload_url, 40);
        $file_path = $destination_path.'/'.$upload_imagename;
        $this->attributes[$attribute_name] = $file_path;

         //  $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }

    public function setImageHoverAttribute($value)
    {
        $attribute_name = "image_hover";
        $disk = "public";
        $destination_path = "uploads/services";
       // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
       $upload_imagename = md5($value->getClientOriginalName().random_int(1, 9999).time()).'.'.$value->getClientOriginalExtension();
       $upload_url = public_path($destination_path).'/'.$upload_imagename;
       $filename = compress_image($_FILES["image_hover"]["tmp_name"], $upload_url, 40);
       $file_path = $destination_path.'/'.$upload_imagename;
       $this->attributes[$attribute_name] = $file_path;
    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }
}
