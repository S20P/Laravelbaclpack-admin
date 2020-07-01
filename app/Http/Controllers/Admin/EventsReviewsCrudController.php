<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventsReviewsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EventsReviewsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventsReviewsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\EventsReviews');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/eventsreviews');
        $this->crud->setEntityNameStrings('eventsreviews', 'events_reviews');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Events Reviews Management');
        $this->crud->setHeading('Events Reviews Management');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Events Reviews Management');
        $this->crud->setHeading('Events Reviews Management');
        $this->crud->setSubheading('Add Events Review','create');

        $this->crud->setValidation(EventsReviewsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Events Reviews Management');
        $this->crud->setHeading('Events Reviews Management');
        $this->crud->setSubheading('Edit Events Review','edit');

        $this->setupCreateOperation();
    }
}
