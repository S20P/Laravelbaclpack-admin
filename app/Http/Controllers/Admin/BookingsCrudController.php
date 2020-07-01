<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookingsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class BookingsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BookingsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Bookings');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/bookings');
        $this->crud->setEntityNameStrings('booking', 'bookings');
    }

    protected function setupListOperation()
    {
        $this->crud->setTitle('bookings');
        $this->crud->setHeading('bookings');
        // $this->crud->removeButton('create');

      if(isset($this->crud->request->booking_id) && !empty($this->crud->request->booking_id)) {

                   $booking_id = $this->crud->request->booking_id;
                  $this->crud->addClause('where', 'id', '=', $booking_id);

              }


        CRUD::addColumns([
            [
                'label'     => 'BOOKING DATE', // Table column heading
                'name'      => 'booking_date', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'SupplierSrvices', // the method that defines the relationship in your Model
                'function_name' => 'booking_date', // foreign key model
            ],
            [
                'label'     => 'TYPE OF SERVICE', // Table column heading
                'name'      => 'service_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'SupplierSrvices', // the method that defines the relationship in your Model
                'function_name' => 'service_name', // foreign key model 
            ],
            [
                'label'     => 'EVENT NAME', // Table column heading
                'name'      => 'event_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'SupplierSrvices', // the method that defines the relationship in your Model
                'function_name' => 'event_name', // foreign key model  
            ],
            [
                'label'     => 'SUPPLIER NAME', // Table column heading
                'name'      => 'supplier_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'SupplierSrvices', // the method that defines the relationship in your Model
                'function_name' => 'supplier_name', // foreign key model
            ],
            [
                'label'     => 'CUSTOMER NAME', // Table column heading
                'name'      => 'customer_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'SupplierSrvices', // the method that defines the relationship in your Model
                'function_name' => 'customer_name', // foreign key model
            ],
            [
                'label'     => 'AMOUNT', // Table column heading
                'name'      => 'amount', // the column that contains the ID of that connected entity;
            ],
            [
                'name'  => 'event_address', // The db column name
                'label' => 'Event venues', // Table column heading
               ],
                [
                'name'  => 'status', // The db column name
                'label' => 'Status', // Table column heading
                'type'      => 'model_function',
                'function_name' => 'status_type',
               ],
            ]);
           
           $this->addCustomCrudFilters();
           $this->crud->enableExportButtons();
    }

  public function show($id)
        {
             // get the info for that entry
            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud;
               

      $Results =  DB::table("supplier_services")
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('booking', 'booking.supplier_services_id', '=', 'supplier_services.id')
        ->join('events', 'booking.event_id', '=', 'events.id')
        ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
        ->where('booking.id',$id)
        ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*')
        ->first();    
            
            $this->data['records'] = $Results;           
            return view('crud::details_row.Bookings', $this->data);
           }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(BookingsRequest::class);

        $this->crud->addField([
            'name'           => 'status',
            'type'           => 'radio',
            'label'          => 'Status',
            'options' => ["pending" => "Pending", "hold" => "Hold","complete" => "Complete"],
            'default' => "pending",
            'inline'      => true,
            // 'tab' => 'Supplier Service information',            
        ]); 

      

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
            'type' => 'date_range',
            'name' => 'from_to',
            'label'=> 'Booking Date'
        ],
        false,
        function($value) {
            $dates = json_decode($value);
            $this->crud->addClause('where', 'booking_date', '>=', $dates->from);
            $this->crud->addClause('where', 'booking_date', '<=', $dates->to);
        });

        $this->crud->addFilter([
            'name' => 'supplier',
            //'type' => 'select2_multiple',
            'type' => 'select2',
            'label'=> 'Supplier'
        ], function() {
            return \App\Models\Supplier::get()->pluck('name', 'id')->toArray();
        }, function($values) {
            /*foreach (json_decode($values) as $key => $value) {
                $this->crud->addClause('where', 'supplier_id', $value);
            }*/
            $this->crud->addClause('where', 'supplier_id', $values);
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
