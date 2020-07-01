<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HowItWorkRequest;
use App\Http\Requests\HowItWorkUpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;


/**
 * Class HowItWorkCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HowItWorkCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\HowItWork');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/howitwork');
        $this->crud->setEntityNameStrings('', 'How It Works');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('How Does It Work');
        $this->crud->setHeading('How Does It Work');
        $this->crud->setSubheading('How Does It Work','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();


       $this->crud->addColumns([
        'heading','slug','content','step_number',
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

     public function show($id)
        {
             // get the info for that entry

            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud; 
            $this->data['records'] = $this->crud->getEntry($id);            
            return view('crud::details_row.HowItWork', $this->data);          
        }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('How Does It Work');
        $this->crud->setHeading('How Does It Work');
        $this->crud->setSubheading('Add','create');

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
            'hint' => 'Will be automatically generated from your Heading, if left empty.',
            // 'disabled' => 'disabled'
        ]);
        
        $this->crud->addField([
            'name'           => 'content',
            'type'           => 'textarea',
            'label'          => 'Content Description',
            // 'tab'   => 'Simple',
        ]);

        $this->crud->addField([
            'name'           => 'step_number',
            'type'           => 'number',
            'label'          => 'Step number',
            'default'        => 0,
            'attributes'     => ['min'=> 0],
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
            // 'disk' => 'public',
        ]);


        $this->crud->setValidation(HowItWorkRequest::class);
        // $this->setupCreateOperation();
        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('How Does It Work');
        $this->crud->setHeading('How Does It Work');
        $this->crud->setSubheading('Edit','edit');

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
            'hint' => 'Will be automatically generated from your Heading, if left empty.',
            // 'attributes'     => ['disabled' => 'disabled'],
            // 'disabled' => 'disabled'
        ]);
        
        $this->crud->addField([
            'name'           => 'content',
            'type'           => 'textarea',
            'label'          => 'Content Description',
            // 'tab'   => 'Simple',
        ]);

        $this->crud->addField([
            'name'           => 'step_number',
            'type'           => 'number',
            'label'          => 'Step number',
            'default'        => 0,
            'attributes'     => ['min'=> 0],
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
            // 'disk' => 'public',
        ]);


        $this->crud->setValidation(HowItWorkUpdateRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        // $this->setupCreateOperation();
    }
}
