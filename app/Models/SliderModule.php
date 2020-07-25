<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class SliderModule extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'slider_module';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['heading','slug','content','button_text','button_url','slide_number','image'];
    // protected $hidden = [];
    // protected $dates = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_heading',
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

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrHeadingAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->heading;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setImageAttribute($value)
    {

        $attribute_name = "image";
        $disk = "public";
        $destination_path = "uploads/Slider";
        $upload_imagename = md5($value->getClientOriginalName().random_int(1, 9999).time()).'.'.$value->getClientOriginalExtension();
        $upload_url = public_path($destination_path).'/'.$upload_imagename;
        $filename = compress_image($_FILES["image"]["tmp_name"], $upload_url, 40);
        $file_path = $destination_path.'/'.$upload_imagename;
        $this->attributes[$attribute_name] = $file_path;


        // $attribute_name = "image";
        // $disk = "public";
        // $destination_path = "uploads/Slider";

        // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }


}
