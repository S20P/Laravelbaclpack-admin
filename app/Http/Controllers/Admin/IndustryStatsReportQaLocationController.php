<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

class IndustryStatsReportQaLocationController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\IndustryStatsReportQaLocation');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/reports/industry_stats_report_QabyLocation');
        $this->crud->setEntityNameStrings('How many of a supplier type on PP By Location', 'How many of a supplier type on PP By Location');
    }

    protected function setupListOperation()
    {
       
       $this->crud->setTitle('How many of a supplier type on PP Report By Location');
       $this->crud->setHeading('How many of a supplier type on PP Report By Location');
       $this->crud->removeButton('create');     

       $this->crud->removeColumn('action');
       $this->crud->removeAllButtons();
       $this->crud->enableExportButtons();
     
        CRUD::addColumns([
            [
                'name' => 'location_name', // The db column name
                'label' => "Location", // Table column heading
            ],  
            [
                'name' => 'totalsupplier', // The db column name
                'label' => "Total Supplier", // Table column heading
                'type' => "model_function",
                'function_name' => 'TotalSupplierByLocation',
                'fake' => true,                
            ],                     
        ]);

         // $this->crud->groupBy(''); 
         // $this->crud->addClause('where', 'supplier_id', '<>', '0');                  
  
    }

}
