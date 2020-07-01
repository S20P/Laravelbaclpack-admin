<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SupplierCategoryEventsRequest;
use App\Http\Requests\SupplierCategoryEventsUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SupplierCategoryEventsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SupplierCategoryEventsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\SupplierCategoryEvents');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/suppliercategoryevents');
        $this->crud->setEntityNameStrings('Supplier Category Events', 'Supplier Category Events');
    }

    protected function setupListOperation()
    {

        $this->crud->setTitle('Supplier Category Events Management');
        $this->crud->setHeading('Services');

        CRUD::addColumns([
            [
            'name' => 'image',
            'label' => "Image",
            'type' => 'image',

                'height' => '80px',
                'width' => '80px',
            ],
            [
                'name' => 'image_hover',
                'label' => "Image Hover",
                'type' => 'image',
                    'height' => '80px',
                    'width' => '80px',
                ],


            'name','slug','description','price'
        ]);

        $this->addCustomCrudFilters();

    }

    protected function setupCreateOperation()
    {

        $this->crud->setTitle('Supplier Category Events Management');
        $this->crud->setHeading('Events Management');
        $this->crud->setSubheading('Add Event','create');


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
            'name'           => 'description',
            'type'           => 'textarea',
            'label'          => 'Description',

              ]);

        $this->crud->addField([
            'name'  => 'price',
            'label' => 'Price',
            'type'  => 'number',
            'prefix' => '$',
            'suffix' => '.00',

        ]);
        $this->crud->addField([           // Select_Multiple = n-n relationship
            'label' => "Location",
            'type' => 'select',
            'name' => 'location_id', // the db column for the foreign key
            'entity' => 'Location', // the method that defines the relationship in your Model
            'attribute' => 'location_name', // foreign key attribute that is shown to user
            'model' => "App\Models\Location",
            // optionals
            'options'   => (function ($query) {
                 return $query->orderBy('location_name', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
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

        $this->crud->setValidation(SupplierCategoryEventsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Supplier Category Events Management');
        $this->crud->setHeading('Events Management');
        $this->crud->setSubheading('Edit Event','edit');


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
            'name'           => 'description',
            'type'           => 'textarea',
            'label'          => 'Description',
            // 'tab'   => 'Simple',
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
        
        $this->crud->addField([           // Select_Multiple = n-n relationship
            'label' => "Location",
            'type' => 'select',
            'name' => 'location_id', // the db column for the foreign key
            'entity' => 'Location', // the method that defines the relationship in your Model
            'attribute' => 'location_name', // foreign key attribute that is shown to user
            'model' => "App\Models\Location",
            // optional
            'options'   => (function ($query) {
                 return $query->orderBy('location_name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
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

        $this->crud->setValidation(SupplierCategoryEventsUpdateRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        // $this->setupCreateOperation();
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
