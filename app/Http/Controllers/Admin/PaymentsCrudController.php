<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaymentsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class PaymentsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PaymentsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Payments');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/payments');
        $this->crud->setEntityNameStrings('payments', 'payments');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        // $this->crud->setFromDb();


        $this->crud->setTitle('payments');
        $this->crud->setHeading('payments');
        $this->crud->removeButton('create');

   

        CRUD::addColumns([
         
             [
                'name' => 'booking_id', // The db column name
                'label' => "BOOKING ID",
                'fake' => true,
                'type' => "model_function",
                'function_name' => 'booking_link',
                'limit'=> 1000,
            ],
              [
                'name' => 'payment_date', // The db column name
                'label' => "PAYMENT DATE",
                'fake' => true,
                'type' => "model_function",
                'function_name' => 'payment_date'
            ],
            [
                'label'     => 'TYPE OF SERVICE', // Table column heading
                'name'      => 'service_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'Bookings', // the method that defines the relationship in your Model
                'function_name' => 'service_name', // foreign key model 
            ],
            [
                'label'     => 'EVENT NAME', // Table column heading
                'name'      => 'event_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'Bookings', // the method that defines the relationship in your Model
                'function_name' => 'event_name', // foreign key model  
            ],
            [
                'label'     => 'SUPPLIER NAME', // Table column heading
                'name'      => 'supplier_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'Bookings', // the method that defines the relationship in your Model
                'function_name' => 'supplier_name', // foreign key model
            ],
            [
                'label'     => 'CUSTOMER NAME', // Table column heading
                'name'      => 'customer_name', // the column that contains the ID of that connected entity;
                'type'      => 'model_function',
                'entity'    => 'Bookings', // the method that defines the relationship in your Model
                'function_name' => 'customer_name', // foreign key model
            ],
            [
                'label'     => 'AMOUNT', // Table column heading
                'name'      => 'amount', // the column that contains the ID of that connected entity;
            ],
            [
                'name'  => 'paid_unpaid', // The db column name
                'label' => 'paid_unpaid', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'paid_unpaid_custom_column',
                'limit'=> 1000,
                
             ],
                [
                'name'  => 'payment_status', // The db column name
                'label' => 'Status', // Table column heading
               ],
            ]);
           
          $this->crud->addClause('where', 'payment_status', 'succeeded'); 


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
        ->join('payment', 'payment.booking_id', '=', 'booking.id')
        ->join('events', 'booking.event_id', '=', 'events.id')
        ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id') 
        ->where('payment.id',$id)
        ->select('supplier_profile.name as supplier_name','customer_profile.name as customer_name','services.name as service_name','events.name as event_name','booking.*','payment.*')
        ->first();    
            
            
            $this->data['records'] = $Results;           
            return view('crud::details_row.Payments', $this->data);
           }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PaymentsRequest::class);

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
            'label'=> 'Payment Date'
        ],
        false,
        function($value) {
             $dates = json_decode($value);
             /*$this->crud->addClause('where', 'payment_date', '>=', $dates->from . ' 00:00:00');
             $this->crud->addClause('where', 'payment_date', '<=', $dates->to . ' 23:59:59');*/

            
                    $date_from = \Carbon\Carbon::createFromFormat('Y-m-d', $dates->from)->format('Y-m-d');
                    $date_to = \Carbon\Carbon::createFromFormat('Y-m-d', $dates->to)->format('Y-m-d'); 

            $this->crud->addClause('where', 'payment_date', '>=', $dates->from . '%');
            $this->crud->addClause('where', 'payment_date', '<=', $dates->to . '%');
        });

        $this->crud->addFilter([
            'name' => 'supplier',
            //'type' => 'select2_multiple',
            'type' => 'select2',
            'label'=> 'Supplier'
        ], function() {
            return \App\Models\Supplier::get()->pluck('name', 'id')->toArray();
        }, function($values) {
            $suppliers = json_decode($values);
            $this->crud->addClause('wherein', 'booking_id', function($query) use ($suppliers){
                // select * from `payment` where `booking_id` = (select id from booking where `booking`.`supplier_id` = 10)
                $query->select('id')->from('booking')->where('supplier_id','=',$suppliers);
            });
        });


             $this->crud->addFilter([
                    'name' => 'customer_id',
                    //'type' => 'select2_multiple',
                    'type' => 'select2',
                    'label'=> 'Customer'
                ], function() {
                    return \App\Models\Customer::get()->pluck('name', 'id')->toArray();
                }, function($values) {
                    
                     $this->crud->addClause('join', 'booking', function($query) use($values) {  
                         // join with function
                         $query->on('booking.id', '=', 'payment.booking_id')
                         ->join('customer_profile','customer_profile.id', '=', 'booking.customer_id')->where('customer_id', $values);
        });
         $this->crud->addClause('select', 'payment.*');
                });

    }


}
