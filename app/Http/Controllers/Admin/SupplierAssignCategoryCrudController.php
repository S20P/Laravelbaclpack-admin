<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\SupplierAssignCategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use \App\Models\SupplierAssignCategoryEvent;
use \App\Models\SupplierAssignCategory;
// use App\Http\Requests\SupplierAssignCategoryRequest;

/**
 * Class SupplierAssignCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SupplierAssignCategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    
    

    public function setup()
    {
        $this->crud->setModel('App\Models\SupplierAssignCategory');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/supplierassigncategory');
        $this->crud->setEntityNameStrings('Supplier Assign Category', 'Supplier Assign Category');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
//        $this->crud->addClause('where', 'price', '=', '200');
        $fda = [
            'label' => "Supplier",
            'type' => 'select',
            'name' => 'supplier_id', // the db column for the foreign key
            'entity' => 'SupplierCategoryEvent', // the method that defines the relationship in your Model
            'attribute' => 'name',  // foreign key attribute that is shown to user
            'model' => "App\Models\Supplier", // foreign key model
        ];
//        echo "<pre>";
//        print_r($fda);
//        die;
        $this->crud->setColumnDetails('Supplier', "kk");
        $this->crud->setFromDb();
    }

    public function AddSupplierAssignEvent($supplierAssignEvent,$event_id)
    {
        $obj = new SupplierAssignCategoryEvent;
        $obj->supplier_assign_category_id = $supplierAssignEvent;
        $obj->category_id = $event_id;
        $obj->save();
    }

    public function store(SupplierAssignCategoryRequest $request)
    {       
        $supplierAssignCategory = new SupplierAssignCategory;
        $supplierAssignCategory->supplier_id = $request->supplier_id;
        $supplierAssignCategory->event_id = $request->event_id;
        $supplierAssignCategory->price = $request->price;
        $supplierAssignCategory->rating = $request->rating;
        if($supplierAssignCategory->save())
        {
            $supplierAssignCategory->id;
            for($i=0;$i<count($request->event_type);$i++)
            {
                $this->AddSupplierAssignEvent($supplierAssignCategory->id,$request->event_type[$i]);
            }
            
        }
        
        // // your additional operations before save here
        $redirect_location = $request->http_referrer;
       
    
        // return redirect()->route('supplierassigncategory');
        return redirect( $redirect_location);
    }

    
    protected function setupCreateOperation()
    {
        
        $this->crud->addField([           // Select_Multiple = n-n relationship
            'label' => "Supplier",
            'type' => 'select2',
            'name' => 'supplier_id', // the db column for the foreign key
            'entity' => 'SupplierCategoryEvent', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Supplier",
            'pivot' => true,
            // optional
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

       

        $this->crud->addField([       // Select_Multiple = n-n relationship
            'label' => "Category",
            'type' => 'select2',
            'name' => 'event_id', // the db column for the foreign key
            'entity' => 'SupplierCategory', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\SupplierCategory",
                'pivot' => true,
            // optional
            'options'   => (function ($query) {
    
                 return $query->orderBy('name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);
        
            $this->crud->addField([           // Select_Multiple = n-n relationship
                'label' => "Event Type",
                'type' => 'select2_multiple',
                'name' => 'event_type', // the db column for the foreign key
                'entity' => 'SupplierCategoryEvent', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\SupplierCategoryEvents",
                'pivot' => true,
                // optional
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                 }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ]);

            $this->crud->addField([
                'name'           => 'status',
                'type'           => 'checkbox',
                'label'          => 'Status',
                'options' => [
                    0 => "Active",
                    1 => "De-active"
                ],
                'attributes' => [
                    'class' => 'form-control switch'
                ],
                'default' => "0",
                'inline'      => true,
            ]);
        $this->crud->addField([   // CustomHTML
            'name' => 'span',
            'type' => 'custom_html',
            'value' => '<span>',
            'attributes' => [
                'class' => 'slider round'
            ]
        ]);

        $this->crud->setValidation(SupplierAssignCategoryRequest::class);
        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }  
}
