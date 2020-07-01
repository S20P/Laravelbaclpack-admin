<?php

namespace App\Http\Controllers\Admin;

/*use App\Http\Controllers\Controller;
use Illuminate\Http\Request;*/
use Illuminate\Http\Request;

// use App\Http\Requests\PaymentsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

class PaymentReportController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Payments');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/reports/supplier');
        $this->crud->setEntityNameStrings('suppliers', 'Supplier Payment Report');
    }

    protected function setupListOperation()
    {
       
       $this->crud->setTitle('Supplier Payment Report');
       $this->crud->setHeading('Supplier Payment Report');
       $this->crud->removeButton('create');     

      $this->crud->removeColumn('action');
      $this->crud->removeAllButtons();
      $this->crud->enableExportButtons();
     


        CRUD::addColumns([
            [
                'name' => 'supplier_name', // The db column name
                'label' => "Supplier Name", // Table column heading
                'type' => "model_function",
                'function_name' => 'payment_supplier_name',
                'fake' => true,     
                'limit' => 200,           
            ],           
            [
                'name' => 'payments', // The db column name
                'label' => "Total Payment", // Table column heading
                'type' => "model_function",
                'function_name' => 'total_payment_of_supplier',
                'fake' => true,                
            ],
            [
                'name' => 'commission', // The db column name
                'label' => "Commission(5%)",
                'fake' => true,
                'type' => "model_function",
                'function_name' => 'Commission'
            ], 
            [
                'name' => 'paytosupplier', // The db column name
                'label' => "Pay to Supplier",
                'fake' => true,
                'type' => "model_function",
                'function_name' => 'Pay_to_Supplier'
            ],
            [
                'name' => 'payment_date', // The db column name
                'label' => "Payment Date",
                'fake' => true,
                'type' => "model_function",
                'function_name' => 'payment_date'
            ],
             [
                'name' => 'paid_unpaid', // The db column name
                'label' => "Payment Status",
                'fake' => true,
                'type' => "model_function",
                'function_name' => 'payment_status'
            ],
              [
                'name' => 'pay', // The db column name
                'label' => "Pay",
                'fake' => true,
                'type' => "model_function",
                'function_name' => 'payment_status_action',
                'limit'=> 1000,
            ],
        ]);

          $this->crud->groupBy('supplier_id');   
                           
          $this->crud->addClause('where', 'supplier_id', '<>', '0'); 
          $this->crud->addClause('where', 'paid_unpaid', '<>', '1');                    

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
      
     $this->crud->addFilter([ // select2 filter
        'name' => 'supplier_id',
        'type' => 'select2',
        'label'=> 'Supplier'
      ], function() {
          return \App\Models\Supplier::all()->pluck('name', 'id')->toArray();
      }, function($value) { 

     $this->crud->addClause('where', 'supplier_id', 'LIKE', "%$value%");

    //   $this->crud->query = $this->crud->query->whereHas('supplier_services', function ($query) use ($value) {
    //     $query->where('service_id', $value);
    // });

      });


         $this->crud->addFilter([ // daterange filter
                   'type' => 'date_range',
                   'name' => 'payment_date',
                   'label'=> 'Date range'
                 ], 
                 false,
                 function($value) { // if the filter is active, apply these constraints

                   $dates = json_decode($value);
                    $date_from = \Carbon\Carbon::createFromFormat('Y-m-d', $dates->from)->format('Y-m-d');
                    $date_to = \Carbon\Carbon::createFromFormat('Y-m-d', $dates->to)->format('Y-m-d');    

            $this->crud->addClause('where', 'payment_date', '>=', $date_from);
            $this->crud->addClause('where', 'payment_date', '<=', $date_to);   

                   });    
}


    

     public function PaymentDetailsBySupplier(Request $request,$id){
       
                          $this->data['crud'] = $this->crud;                       
    
 $result = DB::table("supplier_profile")
                    ->join('payment', 'payment.supplier_id', '=', 'supplier_profile.id')
                    ->where('payment.id',$id)
                    ->first();

                $supplier_name =  $result->name;
               $this->data['supplier_id']  = $result->supplier_id;
               $this->data['supplier_name']  = $supplier_name;

        return view('crud::Reports.SupplierPaymentDetailsReport',$this->data);

     }

          public function PaymentDetailsBySupplierAjex(Request $request,$supplier_id){
        

       
 $payment_details = DB::table("booking")
                            ->join('payment', 'payment.booking_id', '=', 'booking.id')
                            ->join('services', 'services.id', '=', 'booking.service_id')
                            ->join('events', 'events.id', '=', 'booking.event_id')
                            ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id')
                            ->where('payment.supplier_id',$supplier_id)
                            ->where('payment.paid_unpaid',0)
                            ->select('booking.*',DB::raw("DATE_FORMAT(booking.booking_date, '%d-%m-%Y') as booking_date"),'payment.amount as payment_amount','payment.paid_unpaid','payment.booking_id','customer_profile.name as customer_name','services.name as service_name','events.name as event_name',DB::raw("DATE_FORMAT(payment.payment_date, '%d-%m-%Y') as payment_date"))
                            ->get();

                            return $payment_details;
                           

     }

      public function UpdatePaymentStatus(Request $request){


         $supplier_id = $request->supplier_id;
         $comment = $request->comment;

         
            $payment_update_status =  DB::table("payment")->where('supplier_id',$supplier_id)->where('paid_unpaid',0)->update([
                "paid_unpaid"=>1,
                "comment"=>$comment
            ]);

 return "true";

      }


     

}
