<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FaqsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FaqsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FaqsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Faqs');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/faqs');
        $this->crud->setEntityNameStrings('faq', 'faqs');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Faqs');
        $this->crud->setHeading('Faqs');
        $this->crud->setSubheading('Faqs list','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->addCustomCrudFilters();
        $this->crud->enableExportButtons();

    }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Faqs');
        $this->crud->setHeading('Faqs');
        $this->crud->setSubheading('Add Faq','create');

        $this->crud->addField([
            'name'           => 'key_word',
            'type'           => 'text',
            'label'          => 'Key word',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'question',
            'type'           => 'text',
            'label'          => 'Question',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'answers',
            'type'           => 'textarea',
            'label'          => 'Answers',
            // 'tab'   => 'Simple',
          ]);
        $this->crud->setValidation(FaqsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Faqs');
        $this->crud->setHeading('Faqs');
        $this->crud->setSubheading('Edit Faq','edit');
        $this->setupCreateOperation();
    }

    public function addCustomCrudFilters()
    {
       $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'key_word',
            'label' => 'Key word',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'key_word', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'question',
            'label' => 'Question',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'question', 'LIKE', "%$value%");
        });
    }  

}
