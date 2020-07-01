<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Analytic_emailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Services;
use App\Models\Location;

/**
 * Class Analytic_emailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class Analytic_emailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/analytic_email');
        $this->crud->setEntityNameStrings('analytic_email', 'analytic_emails');
    }
    protected function show(){
        $services = Services::select('id','name')->get();
        $locations = Location::select('id','location_name')->get();
        return view('crud::details_row.AnalyticsEmails')->with(['services'=>$services,'locations'=>$locations]);
    }

}
