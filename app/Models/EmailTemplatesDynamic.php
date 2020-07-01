<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Exception;

class EmailTemplatesDynamic extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'email_templates';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['name','subject','content'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function parse($data)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;
            if( isset($data[$index]) ) {
                return $data[$index];
            } else {
                throw new Exception("Shortcode {$shortCode} not found in template id {$this->id}", 1);   
            }
        }, $this->content);

        return $parsed;
    }


    public function parseSubject($data)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;
            if( isset($data[$index]) ) {

                return $data[$index];
            } else {
                throw new Exception("Shortcode {$shortCode} not found in template id {$this->id}", 1);   
            }
        }, $this->subject);

        return $parsed;
    }

    public function testNonExistentShortCode()
    {
        $template          = new EmailTemplatesDynamic;
        $template->id      = 1;
        $template->content = "Hi {{nonExistentVariable}}";
        $data              = [];
    
        $this->setExpectedException(Exception::class, 'Shortcode {{nonExistentVariable}} not found in template id 1');
        $parsed = $template->parse($data);
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
