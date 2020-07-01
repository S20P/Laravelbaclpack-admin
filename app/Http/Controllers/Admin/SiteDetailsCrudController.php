<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SiteDetailsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;


/**
 * Class SiteDetailsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SiteDetailsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\SiteDetails');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sitedetails');
        $this->crud->setEntityNameStrings('site detail', 'site details');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
       // $this->crud->setFromDb();

       
       
       $this->crud->setTitle('Site Details');
       $this->crud->setHeading('Site Details');
       

       $TotalRecord = $this->crud->query->get()->count(); 
       if($TotalRecord>=1){
        $this->crud->removeButton('create');
       }


       CRUD::addColumns([
        [
        'name' => 'logo1', 
        'label' => "Logo1", 
        'type' => "model_function",
        'function_name' => 'thumbnail_logo1',
        'limit' => 1000,
        ],
        [
            'name' => 'logo2', 
            'label' => "Logo2", 
            'type' => "model_function",
            'function_name' => 'thumbnail_logo2',
            'limit' => 1000,
         ],
         [
            'name' => 'contact_number', 
            'label' => "Contact Phone Number", 
         ],
         [
            'name' => 'contact_email', 
            'label' => "Contact Email", 
         ],
         [
            'name' => 'address', 
            'label' => "Address", 
         ],
         [
            'name' => 'currency_code', 
            'label' => "Currency Code", 
         ],
         [
            'name' => 'currency_symbol', 
            'label' => "Currency Symbol", 
         ],
         [
            'name' => 'pagination_per_page', 
            'label' => "Pagination per page", 
         ],
         [
            'name' => 'stripe_key', 
            'label' => "Stripe key", 
         ],
         [
            'name' => 'stripe_secret', 
            'label' => "Stripe secret", 
         ],
         [
            'name' => 'instagram_user_id', 
            'label' => "Instagram UserId", 
         ],
         [
            'name' => 'instagram_secret', 
            'label' => "Instagram secret", 
         ],
         [
            'name' => 'number_of_feeds', 
            'label' => "Number of Feeds", 
         ]  
       ]);
       
    }

    public function show($id)
        {
             // get the info for that entry

            $this->data['entry'] = $this->crud->getEntry($id);
            $this->data['crud'] = $this->crud; 
            $this->data['records'] = $this->crud->getEntry($id);            
            return view('crud::details_row.SiteDetails', $this->data);
          
        }

    protected function setupCreateOperation()
    {

        $this->crud->setTitle('Site Details');
        $this->crud->setHeading('Site Details');
        $this->crud->setSubheading('Add Site Details','create');



        $this->crud->addField([
            'name'           => 'logo1',
            'type'           => 'upload',
            'label'          => 'Logo1',
            'upload' => true,
            
        ]);
        $this->crud->addField([
            'name'           => 'logo2',
            'type'           => 'upload',
            'label'          => 'Logo2',
            'upload' => true,
            
        ]);

        $this->crud->addField([
            'name'           => 'contact_number',
            'type'           => 'text',
            'label' => "Contact Phone Number",
        ]);

        $this->crud->addField([
            'type' => 'text',
            'name' => 'contact_email', 
            'label' => "Contact Email",
        ]);

        $this->crud->addField([
            'type' => 'textarea',
            'name' => 'address', 
            'label' => "Address", 
        ]);

        $this->crud->addField([
            'type' => 'text',
            'name' => 'currency_code', 
            'label' => "Currency Code",
        ]);

        $this->crud->addField([
            'type' => 'text',
            'name' => 'currency_symbol', 
            'label' => "Currency Symbol", 
        ]);

        $this->crud->addField([
            'type' => 'text',
            'name' => 'pagination_per_page', 
            'label' => "Pagination per page", 
        ]);

        $this->crud->addField([
            'type' => 'text',
            'name' => 'stripe_key', 
            'label' => "Stripe key",
        ]);

        $this->crud->addField([
            'type' => 'text',
            'name' => 'stripe_secret', 
            'label' => "Stripe secret", 
        ]);   
        
        $this->crud->addField([
            'type' => 'text',
            'name' => 'instagram_user_id', 
            'label' => "Instagram UserId",
        ]); 

        $this->crud->addField([
            'type' => 'text',
            'name' => 'instagram_secret', 
            'label' => "Instagram secret", 
        ]); 

        $this->crud->addField([
            'type' => 'text',
            'name' => 'number_of_feeds', 
            'label' => "Number of Feeds", 
        ]); 

        $this->crud->setValidation(SiteDetailsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setTitle('Site Details');
        $this->crud->setHeading('Site Details');
        $this->crud->setSubheading('Edit Site Details','edit');
        $this->setupCreateOperation();
    }
}
