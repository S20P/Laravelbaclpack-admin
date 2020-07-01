<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryPriceTiersRequest;
use App\Http\Requests\CategoryPriceTiersUpdateRequest;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\SupplierAssignCategoryEvent;

/**
 * Class CategoryPriceTiersCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CategoryPriceTiersCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\CategoryPriceTiers');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/categorypricetiers');
        $this->crud->setEntityNameStrings('categorypricetiers', 'category_price_tiers');
    }

    

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();
        CRUD::addColumns([
            [
            // 1-n relationship
            'label'     => 'TYPE OF SERVICE', // Table column heading
            'type'      => 'model_function',
            'name'      => 'event_id', // the column that contains the ID of that connected entity;
            'entity'    => 'TypeOfService', // the method that defines the relationship in your Model
            'function_name' => 'getTypeOfService', // foreign key model
            ],'low_price_range','medium_price_range','high_price_range'
           ]);
           
            $this->crud->enableExportButtons();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CategoryPriceTiersRequest::class);

        $this->crud->addField([           // Select_Multiple = n-n relationship
            'label' => "TYPE OF SERVICE",
            'type' => 'select',
            'name' => 'event_id', // the db column for the foreign key
            'entity' => 'TypeOfService', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\SupplierCategoryEvents",
            // optionals
            'options'   => (function ($query) {
                 return $query->orderBy('name', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]); 

        $this->crud->addField([
            'name'           => 'low_price_range',
            'type'           => 'text',
            'label'          => 'Low price range',
            'prefix' => '$',
            // 'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'medium_price_range',
            'type'           => 'text',
            'label'          => 'Medium price range',
            'prefix' => '$',
            // 'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'high_price_range',
            'type'           => 'text',
            'label'          => 'High price range',
            'prefix' => '$',
            // 'fake' => true,
        ]);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->addField([           // Select_Multiple = n-n relationship
            'label' => "TYPE OF SERVICE",
            'type' => 'select',
            'name' => 'event_id', // the db column for the foreign key
            'entity' => 'TypeOfService', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\SupplierCategoryEvents",
            // optionals
            'options'   => (function ($query) {
                 return $query->orderBy('name', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]); 

        $this->crud->addField([
            'name'           => 'low_price_range',
            'type'           => 'text',
            'label'          => 'Low price range',
            'prefix' => '$',
            // 'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'medium_price_range',
            'type'           => 'text',
            'label'          => 'Medium price range',
            'prefix' => '$',
            // 'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'high_price_range',
            'type'           => 'text',
            'label'          => 'High price range',
            'prefix' => '$',
            // 'fake' => true,
        ]);       
        $this->crud->setValidation(CategoryPriceTiersUpdateRequest::class);
        $this->crud->setFromDb();  
       // $this->setupCreateOperation();
    }
}
