<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Our_storyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Our_storyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class Our_storyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Our_story');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/our_story');
        $this->crud->setEntityNameStrings('our story', 'our stories');

    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {

        // TODO: remove setFromDb() and manually define Fields
        
        $this->crud->setFromDb();


    }

    protected function setupUpdateOperation()
    {
        

        $this->crud->addField([
            'name'           => 'section1_subtitle',
            'type'           => 'text',
            'label'          => 'Section1 subtitle',
            // 'fake' => true,
        ]);   
        $this->crud->addField([
            'name'           => 'section1_title',
            'type'           => 'text',
            'label'          => 'Section1 title',
            // 'fake' => true,
        ]);   
        $this->crud->addField([
            'name'           => 'section1_description_title',
            'type'           => 'text',
            'label'          => 'Section1 description title',
            // 'fake' => true,
        ]);   
         $this->crud->addField([
            'name'           => 'section1_description',
            'type'           => 'textarea',
            'label'          => 'Section1 description',
            // 'fake' => true,
        ]);   
         $this->crud->addField([
            'name'           => 'section2_subtitle',
            'type'           => 'text',
            'label'          => 'Section2 subtitle',
            // 'fake' => true,
        ]);   
        $this->crud->addField([
            'name'           => 'section2_tile',
            'type'           => 'text',
            'label'          => 'Section2 title',
            // 'fake' => true,
        ]);   
        $this->crud->addField([
            'name'           => 'section2_description_title',
            'type'           => 'text',
            'label'          => 'Section2 description title',
            // 'fake' => true,
        ]); 
        $this->crud->addField([
            'name'           => 'section2_description',
            'type'           => 'textarea',
            'label'          => 'Section2 description',
            // 'fake' => true,
        ]);    
        $this->crud->addField([
            'name'           => 'section3_subtitle',
            'type'           => 'text',
            'label'          => 'Section3 subtitle',
            // 'fake' => true,
        ]);   
        $this->crud->addField([
            'name'           => 'section3_title',
            'type'           => 'text',
            'label'          => 'Section3 title',
            // 'fake' => true,
        ]);   
        $this->crud->addField([
            'name'           => 'section3_description_title',
            'type'           => 'text',
            'label'          => 'Section3 description title',
            // 'fake' => true,
        ]); 
        $this->crud->addField([
            'name'           => 'section3_description',
            'type'           => 'textarea',
            'label'          => 'Section3 description',
            // 'fake' => true,
        ]);     

         $this->crud->addField([
            'label' => 'Color1',
            'name' => 'color1',
            'type' => 'color_picker',
            // 'default' => '#000000',
            'color_picker_options' => ['customClass' => 'custom-class']
                ]);
         $this->crud->addField([
            'label' => 'Color2',
            'name' => 'color2',
            'type' => 'color_picker',
            'color_picker_options' => ['customClass' => 'custom-class']
                ]);
          $this->crud->addField([
            'label' => 'Color3',
            'name' => 'color3',
            'type' => 'color_picker',
            // 'default' => '#000000',
            'color_picker_options' => ['customClass' => 'custom-class']
                ]);
          // $this->crud->setValidation(Our_storyRequest::class);

        $this->setupCreateOperation();
    }
}
