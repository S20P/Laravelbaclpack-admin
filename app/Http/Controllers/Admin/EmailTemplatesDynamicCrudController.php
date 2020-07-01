<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmailTemplatesDynamicRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmailTemplatesDynamicCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class EmailTemplatesDynamicCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\EmailTemplatesDynamic');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/emailtemplatesdynamic');
        $this->crud->setEntityNameStrings('email template', 'email templates');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();

       CRUD::addColumns([
         'name','subject'
       ]);

   }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(EmailTemplatesDynamicRequest::class);
   
        $this->crud->addField([
            'type' => 'text',
            'name' => 'name', 
            'label' => "Name", 
            // 'attributes' => [
            //    'class'       => 'form-control some-class',
            //    'readonly'    => 'readonly',
            //    'disabled'    => 'disabled',
            //  ],
        ]);
        $this->crud->addField([
            'type' => 'text',
            'name' => 'subject', 
            'label' => "Subject", 
        ]);
        $this->crud->addField([
            'type' => 'summernote',
            'name' => 'content', 
            'label' => "Content", 
        ]);
        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {

        $this->crud->addField([
            'type' => 'text',
            'name' => 'name', 
            'label' => "Name", 
            'attributes' => [
               'class'       => 'form-control some-class',
               'readonly'    => 'readonly',
               'disabled'    => 'disabled',
             ],
        ]);
        $this->crud->addField([
            'type' => 'text',
            'name' => 'subject', 
            'label' => "Subject", 
        ]);
        $this->crud->addField([
            'type' => 'summernote',
            'name' => 'content', 
            'label' => "Content", 
        ]);

        $this->setupCreateOperation();
    }
}
