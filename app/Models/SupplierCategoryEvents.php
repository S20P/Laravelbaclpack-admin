<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class SupplierCategoryEvents extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'supplier_categories_events';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name','slug','description','image','image_hover','price','location_id'];
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function Location()
    {
        return $this->belongsTo('App\Models\Location','location_id','id');
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

      // The slug is created automatically from the "name" field if no slug exists.
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
        // $attribute_name = "image";
        // $disk = "public";
        // $destination_path = "uploads/CategoryEvents";

        // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);



        $attribute_name = "image";
        $disk = "public";
        $destination_path = "uploads/CategoryEvents";
        $upload_imagename = md5($value->getClientOriginalName().random_int(1, 9999).time()).'.'.$value->getClientOriginalExtension();
        $upload_url = public_path($destination_path).'/'.$upload_imagename;
        $filename = compress_image($_FILES["image"]["tmp_name"], $upload_url, 40);
        $file_path = $destination_path.'/'.$upload_imagename;
        $this->attributes[$attribute_name] = $file_path;


    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

    public function setImageHoverAttribute($value)
    {
        // $attribute_name = "image_hover";
        // $disk = "public";
        // $destination_path = "uploads/CategoryEvents";

        // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

        $attribute_name = "image";
        $disk = "public";
        $destination_path = "uploads/CategoryEvents";
        $upload_imagename = md5($value->getClientOriginalName().random_int(1, 9999).time()).'.'.$value->getClientOriginalExtension();
        $upload_url = public_path($destination_path).'/'.$upload_imagename;
        $filename = compress_image($_FILES["image_hover"]["tmp_name"], $upload_url, 40);
        $file_path = $destination_path.'/'.$upload_imagename;
        $this->attributes[$attribute_name] = $file_path;


    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }
   

}
