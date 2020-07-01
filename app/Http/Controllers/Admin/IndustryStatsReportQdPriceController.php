<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

class IndustryStatsReportQdPriceController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\IndustryStatsReportQdPrice');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/reports/industry_stats_report_QdbyPrice');
        $this->crud->setEntityNameStrings('How many people booked a supplier type on PP By Price', 'How many people booked a supplier type on PP By Price');
    }

    protected function setupListOperation()
    {
       
       $this->crud->setTitle('How many people booked a supplier type on PP Report By Price');
       $this->crud->setHeading('How many people booked a supplier type on PP Report By Price');
       $this->crud->removeButton('create');     

       $this->crud->removeColumn('action');
       $this->crud->removeAllButtons();
       $this->crud->enableExportButtons();
     
        CRUD::addColumns([
            [
                'name' => 'range', // The db column name
                'label' => "Price Range", // Table column heading
                 'type' => "model_function",
                 'function_name' => 'PriceRange',
            ], 
            [
                'name' => 'totalsupplier', // The db column name
                'label' => "Total Supplier", // Table column heading
                'type' => "model_function",
                'function_name' => 'TotalSupplierByPrice',
                'fake' => true,                
            ],                     
        ]);

        $this->crud->orderBy('status');

         // $this->crud->groupBy(''); 
         // $this->crud->addClause('where', 'supplier_id', '<>', '0');                  
  
    }

}
