<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TestimonialRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class TestimonialCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TestimonialCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Testimonial');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/testimonial');
        $this->crud->setEntityNameStrings('Testimonial', 'Testimonials');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Testimonial');
        $this->crud->setHeading('Testimonial');
        $this->crud->setSubheading('Testimonial list','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();

       $this->crud->addColumns([
        [
            'name' => 'image', // The db column name
            'label' => "Image", // Table column heading
            'type' => 'image',
             // 'prefix' => 'folder/subfolder/',
             // optional width/height if 25px is not ok with you
              'height' => '80px',
              'width' => '80px',
         ],
        'title','tagline','content_review_message','client_name','company_name','company_website','email','rating'
    ]);

        $this->addCustomCrudFilters();
        $this->crud->enableExportButtons();
    }

    public function show($id)
        {
             // get the info for that entry

            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud; 
            $this->data['records'] = $this->crud->getEntry($id);            
            return view('crud::details_row.Testimonial', $this->data);          
        }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Testimonial');
        $this->crud->setHeading('Testimonial');
        $this->crud->setSubheading('Add Testimonial','create');

        $this->crud->addField([
            'name'           => 'title',
            'type'           => 'text',
            'label'          => 'Title',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'tagline',
            'type'           => 'text',
            'label'          => 'Tagline',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'content_review_message',
            'type'           => 'textarea',
            'label'          => 'Content review message',
            // 'tab'   => 'Simple',
          ]);

          $this->crud->addField([
            'name'           => 'client_name',
            'type'           => 'text',
            'label'          => 'Client name',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'company_name',
            'type'           => 'text',
            'label'          => 'Company name',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'company_website',
            'type'           => 'text',
            'label'          => 'Company website',
            // 'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'email',
            'type'           => 'text',
            'label'          => 'Email',
            // 'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'rating',
            'type'           => 'text',
            'label'          => 'Rating',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image',
            'upload' => true,
            'disk' => 'public',
        ]);

        $this->crud->setValidation(TestimonialRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Testimonial');
        $this->crud->setHeading('Testimonial');
        $this->crud->setSubheading('Edit Testimonial','edit');
        $this->setupCreateOperation();
    }

    public function addCustomCrudFilters()
    {
       $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'title',
            'label' => 'Title',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'title', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'client_name',
            'label' => 'Client Name',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'client_name', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'company_name',
            'label' => 'Company Name',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'company_name', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'email',
            'label' => 'Email',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'email', 'LIKE', "%$value%");
        });

    }

}
