<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SupplierReviewsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class SupplierReviewsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SupplierReviewsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\SupplierReviews');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/supplierreviews');
        $this->crud->setEntityNameStrings('supplier review', 'supplier reviews');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('Supplier Reviews');
        $this->crud->setHeading('Supplier Reviews');
        $this->crud->setSubheading('Reviews list','list');
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();
       $this->addCustomCrudFilters();

       $this->crud->enableExportButtons();
       $this->crud->removeButton('create');


       CRUD::addColumns([
     
         [
            'label'     => 'Customer', // Table column heading
            'name'      => 'customer_id', // the column that contains the ID of that connected entity;
            'type'      => 'model_function',
            'entity'    => 'supplier_services', // the method that defines the relationship in your Model
            'function_name' => 'customer_name', // foreign key model 
        ],
        [
            'label'     => 'Supplier Service', // Table column heading
            'name'      => 'supplier_services_id', // the column that contains the ID of that connected entity;
            'type'      => 'model_function',
            'entity'    => 'supplier_services', // the method that defines the relationship in your Model
            'function_name' => 'service_name', // foreign key model 
        ],       
         [
            'name' => 'content_review', 
            'label' => "Content review", 
         ],
         [
            'name' => 'rates', 
            'label' => "Rates", 
         ],
       ]);
   
    }

     public function show($id)
{

     // get the info for that entry
    $this->data['entry'] = $this->crud->getEntry($id);
    $this->data['crud'] = $this->crud;
       

$supplier_reviews =  DB::table("supplier_services")
        ->join('supplier_reviews', 'supplier_services.id', '=', 'supplier_reviews.supplier_services_id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('customer_profile', 'supplier_reviews.customer_id', '=', 'customer_profile.id') 
        ->where('supplier_reviews.id',$id)
        ->select('customer_profile.name as customer_name','services.name as service_name','supplier_reviews.*')
        ->first();      

      $this->data['supplier_reviews'] = $supplier_reviews;           
    
     return view('crud::details_row.SupplierReviews', $this->data);
  
}

    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Supplier Reviews');
        $this->crud->setHeading('Supplier Reviews');
        $this->crud->setSubheading('Add Review','create');
        $this->crud->setValidation(SupplierReviewsRequest::class);

        $this->crud->addField([
            'name'           => 'content_review',
            'type'           => 'text',
            'label'          => 'Content review',
            // 'fake' => true,          
        ]);

        $this->crud->addField([
            'name'           => 'rates',
            'type'           => 'number',
            'label'          => 'Rates',
            // 'fake' => true,          
        ]);
         $this->crud->addField([
            'name'           => 'status',
            'type'           => 'radio',
            'label'          => 'Status',
            'options' => [1 => "Active", 0 => "Deative"],
            'default' => "Deative",
            'inline'      => true,
        ]);

     


        // TODO: remove setFromDb() and manually define Fields
       // $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Supplier Reviews');
        $this->crud->setHeading('Supplier Reviews');
        $this->crud->setSubheading('Edit Review','edit');
        $this->setupCreateOperation();       
    }


      public function addCustomCrudFilters()
    {


        $this->crud->addFilter([
            'name' => 'supplier',
            //'type' => 'select2_multiple',
            'type' => 'select2',
            'label'=> 'Supplier'
        ], function() {
            return \App\Models\Supplier::get()->pluck('name', 'id')->toArray();
        }, function($values) {
          
         $this->crud->addClause('join', 'supplier_services', function($query) use($values) {  
                         // join with function
                         $query->on('supplier_services.id', '=', 'supplier_reviews.supplier_services_id')
                         ->join('supplier_profile','supplier_profile.id', '=', 'supplier_services.supplier_id')
                                ->where('supplier_id', $values);
        });
         $this->crud->addClause('select', 'supplier_reviews.*');

        });
   

       $this->crud->addFilter([ // dropdown filter
            'name' => 'rates',
            'type' => 'dropdown',
            'label'=> 'Rates',
        ], ["1" => "1", "2" => "2","3" => "3","4" => "4","5" => "5"], function ($value) {
            // if the filter is active
            $this->crud->addClause('where', 'rates', $value);
        });

    }


}
