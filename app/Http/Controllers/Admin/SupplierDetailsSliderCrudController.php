<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SupplierDetailsSliderRequest;
use App\Http\Requests\SupplierDetailsSliderUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SupplierDetailsSliderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SupplierDetailsSliderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\SupplierDetailsSlider');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/supplierdetailsslider');
        $this->crud->setEntityNameStrings('Supplier Details Slider', 'Supplier Details Slider');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
           $this->crud->addColumns([
        [
            'name' => 'image', // The db column name
            'label' => "Slide image", // Table column heading
            'type' => 'image',
             // 'prefix' => 'folder/subfolder/',
             // optional width/height if 25px is not ok with you
              'height' => '80px',
              'width' => '80px',
         ],
        'heading',
        'content',
        'slide_number'         
    ]);
$this->addCustomCrudFilters();
    }

    protected function setupCreateOperation()
    {
        $this->crud->addField([
            'name'           => 'heading',
            'type'           => 'text',
            'label'          => 'Heading',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'content',
            'type'           => 'textarea',
            'label'          => 'Content Description',
            // 'tab'   => 'Simple',
          ]);
            $this->crud->addField([
                'name'           => 'slide_number',
                'type'           => 'number',
                'label'          => 'Slide number',
                'attributes' => ['min' => 0],
                'default'=> '0',
                // 'fake' => true,
            ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Slide Image',
            'upload' => true,
            'disk' => 'public',
        ]);
        // $this->crud->setFromDb();
        $this->crud->setValidation(SupplierDetailsSliderRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->addField([
            'name'           => 'heading',
            'type'           => 'text',
            'label'          => 'Heading',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'content',
            'type'           => 'textarea',
            'label'          => 'Content Description',
            // 'tab'   => 'Simple',
          ]);


            $this->crud->addField([
                'name'           => 'slide_number',
                'type'           => 'number',
                'label'          => 'Slide number',
                'attributes' => ['min' => 0],
                'default'=> '0',
                // 'fake' => true,
            ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Slide Image',
            'upload' => true,
            'disk' => 'public',
        ]);
        $this->crud->setValidation(SupplierDetailsSliderUpdateRequest::class);
        $this->crud->setFromDb();
        // $this->setupCreateOperation();
    }

    public function addCustomCrudFilters()
    {
        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'heading',
            'label' => 'Heading',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'heading', 'LIKE', "%$value%");
        });
    }
}
