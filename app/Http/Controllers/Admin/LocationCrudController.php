<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LocationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class LocationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LocationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Location');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/location');
        $this->crud->setEntityNameStrings('location', 'locations');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Location');
        $this->crud->setHeading('Location');
        $this->crud->setSubheading('Location list','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->addCustomCrudFilters();
        $this->crud->enableExportButtons();
    }

     public function show($id)
        {
             // get the info for that entry

            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud; 
            $this->data['records'] = $this->crud->getEntry($id);            
            return view('crud::details_row.Location', $this->data);          
        }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Location');
        $this->crud->setHeading('Location');
        $this->crud->setSubheading('Add Location','create');

        $this->crud->setValidation(LocationRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Location');
        $this->crud->setHeading('Location');
        $this->crud->setSubheading('Edit Location','edit');
        $this->setupCreateOperation();
    }

    public function addCustomCrudFilters()
    {
       $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'location_name',
            'label' => 'Location Name',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'location_name', 'LIKE', "%$value%");
        });


        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'city',
            'label' => 'City',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'city', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'state_province',
            'label' => 'State/Province',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'state_province', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'postal_code',
            'label' => 'Postal Code',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'postal_code', 'LIKE', "%$value%");
        });

        $this->crud->addFilter([ // text filter
            'type'  => 'text',
            'name'  => 'country',
            'label' => 'Country',
        ],
        false,
        function ($value) { // if the filter is active
            $this->crud->addClause('where', 'country', 'LIKE', "%$value%");
        });
    }

}
