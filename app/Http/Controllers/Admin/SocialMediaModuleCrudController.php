<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SocialMediaModuleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class SocialMediaModuleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SocialMediaModuleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\SocialMediaModule');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/socialmediamodule');
        $this->crud->setEntityNameStrings('social media', 'social media modules');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Social Media Management');
        $this->crud->setHeading('Social Media');
        $this->crud->setSubheading('Social Media list','list');


        $this->crud->addColumns([
            'social_network','slug',
            [
            // run a function on the CRUD model and show its return value
            'name' => "icon",
            'label' => "Icon", // Table column heading
            'type' => "model_function",
            'function_name' => 'getIcon', // the method in your Model
            // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
         // 'limit' => 100, // Limit the number of characters shown
            ],
            [
                'name' => 'image', // The db column name
                'label' => "Image", // Table column heading
                'type' => 'image',
                 // 'prefix' => 'folder/subfolder/',
                 // optional width/height if 25px is not ok with you
                  'height' => '80px',
                  'width' => '80px',
             ],
        ]);
       

        // TODO: remove setFromDb() and manually define Columns, maybe Filters
      //  $this->crud->setFromDb();
        $this->crud->enableExportButtons();
        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'name',
            'label' => 'Social network',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
        });
    }


    public function show($id)
        {
             // get the info for that entry

            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud; 
            $this->data['records'] = $this->crud->getEntry($id);            
            return view('crud::details_row.SocialMediaModule', $this->data);
          
        }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Social Media Management');
        $this->crud->setHeading('Social Media');
        $this->crud->setSubheading('Add Social Media','create');
      

        $this->crud->addField([
            'name'           => 'social_network',
            'type'           => 'text',
            'label'          => 'Social network',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Social network, if left empty.',
            // 'disabled' => 'disabled'
        ]);

        $this->crud->addField([
            'name'           => 'account_url',
            'type'           => 'text',
            'label'          => 'Account url',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'icon',
            'type'           => 'icon_picker',
            'label'          => 'Icon',
            'iconset' => 'fontawesome'
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image',
            'upload' => true,
            'disk' => 'public',
        ]);

        $this->crud->setValidation(SocialMediaModuleRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Social Media Management');
        $this->crud->setHeading('Social Media');
        $this->crud->setSubheading('Edit Social Media','edit');
        $this->setupCreateOperation();
    }
}
