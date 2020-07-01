<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AnalyticsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class AnalyticsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AnalyticsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Analytics');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/analytics');
        $this->crud->setEntityNameStrings('analytics', 'Analytics logs');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();

       $this->crud->setTitle('Analytics logs');
       $this->crud->setHeading('Analytics logs');
       $this->crud->removeButton('create');

       CRUD::addColumns([
        [
        'name' => 'image_url', 
        'label' => "Most viewed Image", 
        'type' => 'image',
            // 'prefix' => 'folder/subfolder/',
            // optional width/height if 25px is not ok with you
            'height' => '80px',
            'width' => '80px',
        ],
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
            'name' => 'analytics_event_type', 
            'label' => "Analytics event type", 
         ],
         [
            'name' => 'date', 
            'label' => "Date", 
            'type'       => 'date',
            'format' => 'DD-MM-YYYY'
         ],
       ]);
    }

        public function show($id)
        {
             // get the info for that entry
            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud;
               

        $Results =  DB::table("supplier_services")
        ->join('analytics', 'supplier_services.id', '=', 'analytics.supplier_services_id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('customer_profile', 'analytics.customer_id', '=', 'customer_profile.id') 
        ->where('analytics.id',$id)
        ->select('customer_profile.name as customer_name','services.name as service_name','analytics.*')
        ->first();  
     

              $this->data['records'] = $Results;           
            
             return view('crud::details_row.Analytics', $this->data);
          
        }

    protected function setupCreateOperation()
    {

        $this->crud->addField([
            'name'           => 'image_url',
            'type'           => 'upload',
            'label'          => 'Most viewed Image',
            'upload' => true,
        ]);

        $this->crud->addField([
            'type' => 'text',
            'name' => 'slug', 
            'label' => "Slug",
        ]);

        $this->crud->addField([
            'type' => 'text',
            'name' => 'analytics_event_type', 
            'label' => "Analytics event type", 
        ]);

        $this->crud->addField([
            'type' => 'date',
            'name' => 'date', 
            'label' => "Date", 
        ]);

        $this->crud->setValidation(AnalyticsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
   
        $this->crud->removeField('customer_id');
        $this->crud->removeField('supplier_services_id');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
