<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SliderModuleRequest;
use App\Http\Requests\SliderModuleUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class SliderModuleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SliderModuleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\SliderModule');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/slidermodule');
        $this->crud->setEntityNameStrings('Slide', 'Slider Modules');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Slider');
        $this->crud->setHeading('Slider');
        $this->crud->setSubheading('Slide list','list');
       // TODO: remove setFromDb() and manually define Columns, maybe Filters
    
       $this->crud->addColumns([
        [
            'name' => 'image', // The db column name
            'label' => "Slide image", // Table column heading
            'type' => "model_function",
            'function_name' => 'thumbnail_image',
            'limit' => 1000,
         ],
        'heading',
        'slug',
        'content',
        'button_text',
        'button_url',
        'slide_number'         
    ]);
    
       //  $this->crud->setFromDb();
        $this->addCustomCrudFilters();
      }

  public function show($id)
        {
             // get the info for that entry

            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud; 
            $this->data['records'] = $this->crud->getEntry($id);            
            return view('crud::details_row.SliderModule', $this->data);
          
        }

    protected function setupCreateOperation()
    {   
        $this->crud->setTitle('Slider');
        $this->crud->setHeading('Slider');
        $this->crud->setSubheading('Add Slide','create');

        $this->crud->addField([
            'name'           => 'heading',
            'type'           => 'text',
            'label'          => 'Heading',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Heading if left empty.',
            // 'disabled' => 'disabled'
        ]);

        $this->crud->addField([
            'name'           => 'content',
            'type'           => 'textarea',
            'label'          => 'Content Description',
            // 'tab'   => 'Simple',
          ]);

         $this->crud->addField([
                'name'           => 'button_text',
                'type'           => 'text',
                'label'          => 'Button text',
                // 'fake' => true,
         ]);

        $this->crud->addField([
                'name'           => 'button_url',
                'type'           => 'text',
                'label'          => 'Button url',
                // 'fake' => true,
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

        $this->crud->setValidation(SliderModuleRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Slider');
        $this->crud->setHeading('Slider');
        $this->crud->setSubheading('Edit Slide','edit');

        $this->crud->addField([
            'name'           => 'heading',
            'type'           => 'text',
            'label'          => 'Heading',
            // 'fake' => true,
        ]);
        
        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Heading if left empty.',
            // 'attributes' => ['disabled' => 'disabled'],
        ]);

        $this->crud->addField([
            'name'           => 'content',
            'type'           => 'textarea',
            'label'          => 'Content Description',
            // 'tab'   => 'Simple',
        ]);

        $this->crud->addField([
                'name'           => 'button_text',
                'type'           => 'text',
                'label'          => 'Button text',
                // 'fake' => true,
         ]);

        $this->crud->addField([
                'name'           => 'button_url',
                'type'           => 'text',
                'label'          => 'Button url',
                // 'fake' => true,
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
//            'disk' => 'public',
        ]);
        $this->crud->setValidation(SliderModuleUpdateRequest::class);
        $this->crud->setFromDb();
//        $this->setupCreateOperation();
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
