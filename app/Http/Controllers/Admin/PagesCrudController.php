<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PagesRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PagesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PagesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Pages');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/pages');
        $this->crud->setEntityNameStrings('page', 'pages');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Pages');
        $this->crud->setHeading('Pages');
        $this->crud->setSubheading('Pages list','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->addCustomCrudFilters();
        $this->crud->enableExportButtons();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Pages');
        $this->crud->setHeading('Pages');
        $this->crud->setSubheading('Add Page','create');

        $this->crud->addField([
            'name'           => 'template',
            'type'           => 'text',
            'label'          => 'Template Name',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'name',
            'type'           => 'text',
            'label'          => 'Page Name',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Page Name, if left empty.',
            // 'disabled' => 'disabled'
        ]);

        $this->crud->addField([
            'name'           => 'title',
            'type'           => 'text',
            'label'          => 'Page Title',
            // 'fake' => true,
        ]);


        $this->crud->addField([   // CKEditor
            'name'  => 'content',
            'label' => 'Page content',
            'type'  => 'ckeditor',
            // 'tab'   => 'Big texts',
        ]);    
         
        

       // $this->crud->setValidation(PagesRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
   
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Pages');
        $this->crud->setHeading('Pages');
        $this->crud->setSubheading('Edit Page','edit');
        $this->setupCreateOperation();
    }

    public function addCustomCrudFilters()
    {
       $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'template',
            'label' => 'Template Name',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'template', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'name',
            'label' => 'Page Name',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
        });

        $this->crud->addField([
            'name'           => 'slug',
            'type'           => 'text',
            'label'          => 'Slug',
            'hint' => 'Will be automatically generated from your Page Name, if left empty.',
            // 'disabled' => 'disabled'
        ]);

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'title',
            'label' => 'Page title',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'title', 'LIKE', "%$value%");
        });
        
    }

}
