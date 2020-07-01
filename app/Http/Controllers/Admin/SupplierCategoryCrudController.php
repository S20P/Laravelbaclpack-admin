<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SupplierCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SupplierCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SupplierCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\SupplierCategory');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/suppliercategory');
        $this->crud->setEntityNameStrings('suppliercategory', 'supplier_categories');
    }

    protected function setupListOperation()
    {

        $this->crud->setTitle('Supplier Category Management');
        $this->crud->setHeading("List of Category's");
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
     //   $this->crud->setFromDb();

     CRUD::addColumns([
        [
        'name' => 'image', // The db column name
        'label' => "Image", // Table column heading
        'type' => 'image',
            // 'prefix' => 'folder/subfolder/',
            // optional width/height if 25px is not ok with you
            'height' => '80px',
            'width' => '80px',
        ],
        'name','slug','description','price','rates'
    ]);


        $this->addCustomCrudFilters();
        $this->crud->enableExportButtons();

    }

    protected function setupCreateOperation()
    {
      
        $this->crud->setTitle('Supplier Category Management');
        $this->crud->setHeading('Supplier Category Management');
        $this->crud->setSubheading('Add Category','create');

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

        $this->crud->addField([
            'name'           => 'rates',
            'type'           => 'text',
            'label'          => 'Rates',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image',
            'upload' => true,
            'disk' => 'public',
        ]);
            
        $this->crud->setValidation(SupplierCategoryRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        
    }

    protected function setupUpdateOperation()
    {

        $this->crud->setTitle('Supplier Category Management');
        $this->crud->setHeading('Supplier Category Management');
        $this->crud->setSubheading('Edit Category','edit');

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
                
        $this->crud->addField([
            'name'           => 'rates',
            'type'           => 'text',
            'label'          => 'Rates',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image',
            'upload' => true,
            'disk' => 'public',
        ]);

        $this->setupCreateOperation();  
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

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'rates',
            'label' => 'Rates',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'rates', 'LIKE', "%$value%");
        });

    }

}
