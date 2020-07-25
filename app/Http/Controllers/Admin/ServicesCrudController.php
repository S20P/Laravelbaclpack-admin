<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ServicesRequest;
use App\Http\Requests\ServicesUpdateRequest;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class ServicesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ServicesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Services');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/services');
        $this->crud->setEntityNameStrings('service', 'services');
        $this->crud->enableReorder('name', 0);
  
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();

        $this->crud->setTitle('Supplier  Management');
        $this->crud->setHeading('Services');

        CRUD::addColumns([
            [
            'name' => 'image',
            'label' => "Image",
            'type' => "model_function",
            'function_name' => 'thumbnail_image',
            'limit' => 1000,
            ],
            [
                'name' => 'image_hover',
                'label' => "Image Hover",
                'type' => "model_function",
                'function_name' => 'thumbnail_image_hover',
                'limit' => 1000,
                ],
            'name','slug','price'
        ]);

        $this->crud->orderBy('lft');
        $this->addCustomCrudFilters();
    }

         public function show($id)
{

     // get the info for that entry

    $this->data['entry'] = $this->crud->getEntry($id);
    $this->data['crud'] = $this->crud; 
    $this->data['records'] = $this->crud->getEntry($id); 

        
    
     return view('crud::details_row.Services', $this->data);
  
}

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ServicesRequest::class);

        // TODO: remove setFromDb() and manually define Fields
       // $this->crud->setFromDb();

        $this->crud->setTitle('Services Management');
        $this->crud->setHeading('Services Management');
        $this->crud->setSubheading('Add Services','create');


        $this->crud->addField([
            'name'           => 'name',
            'type'           => 'text',
            'label'          => 'Name',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Name, if left empty.',

        ]);

        $this->crud->addField([
            'name'  => 'price',
            'label' => 'Price',
            'type'  => 'number',
            'prefix' => '$',
            'suffix' => '.00',
        ]);
     
        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image/Icon',
            'upload' => true,
            // 'disk' => 'public',
        ]);

        $this->crud->addField([
            'name'           => 'image_hover',
            'type'           => 'upload',
            'label'          => 'Image Hover',
            'upload' => true,
            // 'disk' => 'public',
        ]);

       // $this->crud->setValidation(SupplierCategoryEventsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        $this->crud->removeField('parent_id');
        $this->crud->removeField('lft');
        $this->crud->removeField('rgt');
        $this->crud->removeField('depth');

    }

    protected function setupUpdateOperation()
    {
        //$this->setupCreateOperation();
        $this->crud->setTitle('Services Management');
        $this->crud->setHeading('Services Management');
        $this->crud->setSubheading('Edit Services','edit');


        $this->crud->addField([
            'name'           => 'name',
            'type'           => 'text',
            'label'          => 'Name',
            // 'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'attributes'     => ['disabled','disabled'],
            'hint' => 'Will be automatically generated from your Name, if left empty.',
            // 'disabled' => 'disabled'
        ]);
     
        $this->crud->addField([
            'name'  => 'price',
            'label' => 'Price',
            'type'  => 'number',
            // optionals
            //'attributes' => ["step" => "any"], // allow decimals
            'prefix' => '$',
            'suffix' => '.00',
            // 'wrapperAttributes' => [
            //    'class' => 'form-group col-md-6'
            //  ], // extra HTML attributes for the field wrapper - mostly for resizing fields
            //'tab' => 'Basic Info',
        ]);
        
        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image/Icon',
            'upload' => true,
            // 'disk' => 'public',
        ]);

        $this->crud->addField([
            'name'           => 'image_hover',
            'type'           => 'upload',
            'label'          => 'Image Hover',
            'upload' => true,
            // 'disk' => 'public',
        ]);


        $this->crud->removeField('parent_id');
        $this->crud->removeField('lft');
        $this->crud->removeField('rgt');
        $this->crud->removeField('depth');
        $this->crud->setValidation(ServicesUpdateRequest::class);
    }

    public function addCustomCrudFilters()
    {
        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'name',
            'label' => 'Name',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'price',
            'label' => 'Price',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'price', 'LIKE', "%$value%");
        });
    }
}
