<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventsRequest;
use App\Http\Requests\EventsUpdateRequest;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EventsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class EventsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Events');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/events');
        $this->crud->setEntityNameStrings('event', 'events');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('events  Management');
        $this->crud->setHeading('events');

        CRUD::addColumns([
            'name','slug',
        ]);

        $this->addCustomCrudFilters();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(EventsRequest::class);

        $this->crud->setTitle('events Management');
        $this->crud->setHeading('events Management');
        $this->crud->setSubheading('Add events','create');


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

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        //        $this->setupCreateOperation();
          //$this->setupCreateOperation();
          $this->crud->setTitle('events Management');
          $this->crud->setHeading('events Management');
          $this->crud->setSubheading('Edit events','edit');
  
  
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

        $this->crud->setValidation(EventsUpdateRequest::class);

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
    
    }
}
