<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['category_id','title','slug','date','quote','content','short_content','column1_image','column1_title','column1_description','column2_image','column2_title','column2_description','banner_image','media_type','image','video','status','author','featured'];
    // protected $hidden = [];
    // protected $dates = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
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

    public function ArticleCategory()
    {
        return $this->belongsTo('App\Models\ArticleCategory','category_id','id');
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

        // The slug is created automatically from the "title" field if no slug exists.
        public function getSlugOrTitleAttribute()
        {
            if ($this->slug != '') {
                return $this->slug;
            }

            return $this->title;
        }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


 public function setColumn1ImageAttribute($value)
    {
        $attribute_name = "column1_image";
        $disk = "public";
        $destination_path = "uploads/Articles";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

     public function setColumn2ImageAttribute($value)
    {
        $attribute_name = "column2_image";
        $disk = "public";
        $destination_path = "uploads/Articles";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "public";
        $destination_path = "uploads/Articles";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

    public function setBannerImageAttribute($value)
    {
        $attribute_name = "banner_image";
        $disk = "public";
        $destination_path = "uploads/Articles";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }


    public function setVideoAttribute($value)
    {
        $attribute_name = "video";
        $disk = "public";
        $destination_path = "uploads/Articles";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

}
