<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MessangerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;
/**
 * Class MessangerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MessangerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
     use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
   // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation { show as traitShow; }

    public function setup()
    {
        $this->crud->setModel('App\Models\Messanger');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/messanger');
        $this->crud->setEntityNameStrings('messanger', 'messangers');
      

    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        //$this->crud->setFromDb();

        $this->crud->setTitle('Messanger');
        $this->crud->setHeading('Messanger');
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
       // $this->crud->enableDetailsRow();
       

      //  $this->crud->setDetailsRowView('details_row.supplier');
        CRUD::addColumns([
            [
                'label'     => 'TYPE OF SERVICE', // Table column heading
                'name'      => 'service_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'SupplierSrvices', // the method that defines the relationship in your Model
                'function_name' => 'service_name', // foreign key model 
            ],
            [
                'label'     => 'SUPPLIER NAME', // Table column heading
                'name'      => 'supplier_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'SupplierSrvices', // the method that defines the relationship in your Model
                'function_name' => 'supplier_name', // foreign key model
                'searchLogic' => function ( $query, $column, $searchTerm ) {
                      $this->crud->addClause('join', 'supplier_services', function($query) use($searchTerm) {  
                         // join with function
                         $query->on('supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
                         ->join('supplier_profile','supplier_profile.id', '=', 'supplier_services.supplier_id')
                                ->where('supplier_profile.name','like', '%' . $searchTerm . '%');
        });
         $this->crud->addClause('select', 'customers_inquiry.*');
          }
            ],
            [
                'label'     => 'CUSTOMER NAME', // Table column heading
                'name'      => 'customer_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'SupplierSrvices', // the method that defines the relationship in your Model
                'function_name' => 'customer_name', // foreign key model
                
            ],
               [
                'label'     => 'Message Date', 
                'name'      => 'created_at', 
                'type'      => 'model_function',
                'function_name' => 'last_message_date', 
            ],
            ]);
            $this->crud->groupBy('supplier_services_id');

             $this->addCustomCrudFilters();
          // $this->crud->enableExportButtons();

       // $this->crud->setDetailsRowView('vendor.backpack.crud.details_row.supplier');


    }

   // protected function setupShowOperation()
   // {


       // $this->crud->set('show.setFromDb', false);

       // $this->crud->setDetailsRowView('vendor.backpack.crud.details_row.supplier');


 //   }

    public function show($id)
{
  

    $this->data['entry'] = $this->crud->getEntry($id);
    $this->data['crud'] = $this->crud;
    $this->data['title'] = 'Moderate '.$this->crud->entity_name;

    $entry = $this->crud->getEntry($id);
    $customer_id = $entry->customer_id;
    $supplier_services_id = $entry->supplier_services_id;


   ///////////////////////////////dd($this->data);

    $Results =  DB::table("customers_inquiry")
    ->join('supplier_services', 'supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
    ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
    ->join('services', 'services.id', '=', 'supplier_services.service_id')
    ->join('customer_profile', 'customers_inquiry.customer_id', '=', 'customer_profile.id') 
    ->where('customers_inquiry.supplier_services_id',$supplier_services_id)
    ->where('customers_inquiry.customer_id',$customer_id)
    ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','services.name as service_name','customers_inquiry.*')
   ->orderBy('customers_inquiry.id','asc')->get()->toArray();
                               


    $this->data['conversation'] = $Results;

    //     // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
     return view('crud::details_row.messanger', $this->data);
  
}



    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MessangerRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }


   public function addCustomCrudFilters()
    {

        $this->crud->addFilter([
            'name' => 'supplier',
            'type' => 'select2',
            'label'=> 'Supplier'
        ], function() {
            return \App\Models\Supplier::get()->pluck('name', 'id')->toArray();
        }, function($values) {
          
         $this->crud->addClause('join', 'supplier_services', function($query) use($values) {  
                         // join with function
                         $query->on('supplier_services.id', '=', 'customers_inquiry.supplier_services_id')
                         ->join('supplier_profile','supplier_profile.id', '=', 'supplier_services.supplier_id')
                                ->where('supplier_id', $values);
        });
         $this->crud->addClause('select', 'customers_inquiry.*');

        });


    $this->crud->addFilter([
            'name' => 'customer_id',
            //'type' => 'select2_multiple',
            'type' => 'select2',
            'label'=> 'Customer'
        ], function() {
            return \App\Models\Customer::get()->pluck('name', 'id')->toArray();
        }, function($values) {
            $this->crud->addClause('where', 'customer_id', $values);
        });
   }
}
