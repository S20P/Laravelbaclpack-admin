<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Requests\Supplier_servicesRequest;
use App\Http\Requests\Supplier_servicesUpdateRequest;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use DB;
use App\Models\Supplier;
use App\Models\Supplier_services;
use App\Models\Services;
use App\Models\Events;
use App\Models\Supplier_assign_events;
use App\Models\SupplierDetailsSlider;
use App\Models\Location;

/**
 * Class Supplier_servicesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class Supplier_servicesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }

    public function setup()
    {
        $this->crud->setModel('App\Models\Supplier_services');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/supplier_services');
        $this->crud->setEntityNameStrings('supplier service', 'supplier services');
    }

    protected function setupListOperation()
    {

        $this->crud->setTitle('Assign Service to supplier');
        $this->crud->setHeading('Assign Service to supplier');

        CRUD::addColumns([
            [
                // 1-n relationship
                'label'     => 'Supplier', // Table column heading
                'type'      => 'model_function',
                'name'      => 'supplier_id', // the column that contains the ID of that connected entity;
                'entity'    => 'Supplier', // the method that defines the relationship in your Model
                'function_name' => 'getSupplier', // foreign key model
            ],
            [
                // 1-n relationship
                'label'     => 'Services', // Table column heading
                'type'      => 'model_function',
                'name'      => 'service_id', // the column that contains the ID of that connected entity;
                'entity'    => 'Services', // the method that defines the relationship in your Model
                'function_name' => 'getServices', // foreign key model
            ],
            'business_name','service_description',
            [
                // 1-n relationship
                'label'     => 'Location', // Table column heading
                'type'      => 'model_function',
                'name'      => 'location', // the column that contains the ID of that connected entity;
                'entity'    => 'Location', // the method that defines the relationship in your Model
                'function_name' => 'getLocation', // foreign key model
            ],
            [
                'name' => 'price_range',
                'label' => "Price Range",
                'type' => 'model_function',
                'function_name' => 'price_range_display',
            ],
            'facebook_link','facebook_title','instagram_link','instagram_title',     
               'status',
               [
                'name'  => 'featured', // The db column name
                'key'   => 'check',
                'label' => 'Featured', // Table column heading
                'type'  => 'check',
               ],
                  ]);
           
           $this->addCustomCrudFilters();
           $this->crud->enableExportButtons();
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
      //  $this->crud->setFromDb();
    }

   public function show($id)
{

     // get the info for that entry
    $this->data['entry'] = $this->crud->getEntry($id);
    $this->data['crud'] = $this->crud;
       

$supplier_services = DB::table("supplier_services")
        ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->where('supplier_services.id',$id)
        ->select('supplier_profile.name as supplier_name','services.name as service_name','supplier_services.*')
        ->get()->toArray();       

      $this->data['supplier_services'] = $supplier_services;

       
       
       if(count($supplier_services)){
        $locations = [];
        
       for($i=0;$i<count($supplier_services);$i++){
       $location_name = [];
       $locationslist = json_decode($supplier_services[$i]->location);
       $location_result =  Location::whereIn('id',$locationslist)->select('location_name')->get();       
        
         if(count($location_result)){
            foreach($location_result as $location){
           array_push($location_name,$location->location_name);
            }
         } 

      array_push($locations,["locations_record"=>$location_name,"supplier_services_id"=>$supplier_services[$i]->id]);

       }
    }  
     
   

        $this->data['locations'] = $locations;
       // return implode(",<br>",$locations);

        // return json_encode(implode(",",$locations));

     return view('crud::details_row.Supplier_services', $this->data);
  
}


    protected function setupCreateOperation()
    {
        $this->crud->setTitle('Assign Service to supplier');
        $this->crud->setHeading('Assign Service to supplier');
        $this->crud->setSubheading('','create');

        $this->crud->setValidation(Supplier_servicesRequest::class);

        $this->crud->addField([ 
            'fake' => true,
            'name' => 'supplier_id',
            'label' => "Supplier",
            'type' => 'select2_from_array',
            'options' =>$this->getSupplier(),
            'allows_null' => false,
            'default' => '',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'business_name',
            'type'           => 'text',
            'label'          => 'Business name',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'service_description',
            'type'           => 'textarea',
            'label'          => 'Service description',
            'fake' => true,
        ]);

        $this->crud->addField([ 
            'fake' => true,
            'name' => 'service_id',
            'label' => "TYPE OF SERVICE",
            'type' => 'select2_from_array',
            'options' =>$this->getTypeOfService(),
            'allows_null' => false,
            'default' => '',
            'fake' => true,
        ]);
     

        $this->crud->addField([ 
            'fake' => true,
            'name' => 'price_range',
            'label' => "Price Range",
            'type' => 'select2_from_array',
            'options' =>["1"=>"Low","2"=>"Medium","3"=>"High"],
            'allows_null' => false,
            'default' => '',
            'fake' => true,
        ]);
   

        $this->crud->addField([ 
            'fake' => true,
            'name' => 'event_id',
            'label' => "TYPE OF EVENT",
            'type' => 'select2_from_array',
            'options' =>$this->getTypeOfEvent(),
            'allows_null' => false,
            'default' => '',
            'allows_multiple' => true, 
            'fake' => true,
        ]);
             	
        $this->crud->addField([           // Select_Multiple = n-n relationship
            'label' => "Location",
            'type' => 'select_multiple',
            'name' => 'location', // the db column for the foreign key
            'entity' => 'Location', // the method that defines the relationship in your Model
            'attribute' => 'location_name', // foreign key attribute that is shown to user
            'model' => "App\Models\Location",
            'fake' => true,
            // 'pivot' => true,
            // optional
            'options'   => (function ($query) {
                 return $query->orderBy('location_name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

     
        $this->crud->addField([
            'name'           => 'facebook_link',
            'type'           => 'text',
            'label'          => 'Facebook Link',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'facebook_title',
            'type'           => 'text',
            'label'          => 'Facebook Title',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'instagram_link',
            'type'           => 'text',
            'label'          => 'Instagram Link',
            'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'instagram_title',
            'type'           => 'text',
            'label'          => 'Instagram Title',
             'fake' => true,
        ]);
        
        $this->crud->addField([
            'name'           => 'status',
            'type'           => 'radio',
            'label'          => 'Service Status',
            'options' => ["Active" => "Active", "Deactive" => "Deactive"],
            'default' => "Deactive",
            'inline'      => true,
        ]);

        $this->crud->addField([
            'name'           => 'featured',
            'type'           => 'checkbox',
            'label'          => 'Featured',
            'fake' => true,
        ]);


        $this->crud->addField([
            'name'           => 'heading',
            'type'           => 'text',
            'label'          => 'Heading',
            'tab'   => 'Slider Information',
             'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'content',
            'type'           => 'textarea',
            'label'          => 'Content Description',
            'tab'   => 'Slider Information',
            'fake' => true,
          ]);

          $this->crud->addField([   // Upload
            'name'   => 'image',
            'label'  => 'Upload Slide Image',
            'type'   => 'upload',
            'upload' => true,
            // 'disk' => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
            // optional:
            // 'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URL's this will make a URL that is valid for the number of minutes specified
            'tab' => 'Slider Information',
        ]);
        
        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    public function store(Supplier_servicesRequest $request)
    {         
        $validated = $request->validated();
        // $response = $this->traitStore();
        //$Result = $this->crud->entry;
        $Result = $request;

      $status = $Result->status;
      $supplier_id = $Result->supplier_id;
      $business_name = $Result->business_name;
      $service_description = $Result->service_description;
      $location = json_encode($Result->location);
      $facebook_link  = $Result->facebook_link;
      $facebook_title = $Result->facebook_title;
      $instagram_link = $Result->instagram_link;
      $instagram_title = $Result->instagram_title;
      $featured = $Result->featured;
      $service_id = $Result->service_id;
      $event_id = $Result->event_id;
      $price_range = $Result->price_range;
      
   
     $check_exist_supplier_service =  Supplier_services::where("supplier_id",$supplier_id)->where('service_id',$service_id)->get();
     if(count($check_exist_supplier_service)){
        \Alert::error('The Supplier Allready Assign to this Service.')->flash();
        return \Redirect::back();
     }

      $supplier_services_data = [ 
        'supplier_id' =>$supplier_id,
        'service_id'=>$service_id,
        'business_name'=>$business_name,
        'service_description'=>$service_description,
        'location'=>$location,
        'price_range'=>$price_range,
        'status'=>$status,
        'facebook_link'=>$facebook_link,
        'facebook_title'=>$facebook_title,
        'instagram_link'=>$instagram_link,
        'instagram_title'=>$instagram_title,
        'featured'=>$featured];

    $supplier_services_id = Supplier_services::insertGetId($supplier_services_data);

    if($supplier_services_id){
        if($event_id){
         if(count($event_id)){
                for($i=0;$i<count($event_id);$i++){
                    Supplier_assign_events::create(['supplier_services_id'=>$supplier_services_id,'event_id'=>$event_id[$i]]);
                }
            }
        }

   //Slider data

      $heading = $Result->heading;
      $content = $Result->content;
      $images = $Result->image;

     
    
         if($request->hasFile('image'))
        {
            $file = $request->file('image');
            
                $path = $file->getClientOriginalName();
                $name = time()."_".$path;
                $destinationPath = public_path('/uploads/SupplierDetailsSlider/');
                $images_url = '/uploads/SupplierDetailsSlider/'.$name;
                $file->move($destinationPath,$name);
            
           
            SupplierDetailsSlider::insert(['supplier_services_id'=>$supplier_services_id,'heading'=>$heading,'content'=>$content,'image'=>$images_url]);
        }
      
    }
                 \Alert::success('Successfully Assign Service to supplier.')->flash();
                 return \Redirect::to($this->crud->route);
                //  Session::flash('success', "Supplier Profile is Successfully Created.");
                //  return redirect()->back()->with('success', "Supplier Profile is Successfully Created.");
    } 


    protected function setupUpdateOperation()
    {

        $this->crud->setTitle('Assign Service to supplier');
        $this->crud->setHeading('Assign Service to supplier');

        //$this->setupCreateOperation();
      
        $this->crud->addField([ 
            'fake' => true,
            'name' => 'supplier_id',
            'label' => "Supplier",
            'type' => 'select2_from_array',
            'options' =>$this->getSupplier(),
            'allows_null' => false,
            'default' => '',
            'fake' => true,
            'attributes' => [
                'placeholder' => 'Some text when empty',
                'class' => 'form-control some-class',
                'readonly'=>'readonly',
                'disabled'=>'disabled',
              ], 
        ]);

        $this->crud->addField([
            'name'           => 'business_name',
            'type'           => 'text',
            'label'          => 'Business name',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'service_description',
            'type'           => 'textarea',
            'label'          => 'Service description',
            'fake' => true,
        ]);
        $this->crud->addField([ 
            'fake' => true,
            'name' => 'service_id',
            'label' => "TYPE OF SERVICE",
            'type' => 'select2_from_array',
            'options' =>$this->getTypeOfService(),
            'allows_null' => false,
            'default' => '',
            'fake' => true,
            'attributes' => [
                'placeholder' => 'Some text when empty',
                'class' => 'form-control some-class',
                'readonly'=>'readonly',
                'disabled'=>'disabled',
              ], 
        ]);


        $this->crud->addField([ 
            'fake' => true,
            'name' => 'price_range',
            'label' => "Price Range",
            'type' => 'select2_from_array',
            'options' =>["1"=>"Low","2"=>"Medium","3"=>"High"],
            'allows_null' => false,
            'default' => '',
            'fake' => true,
        ]);

        
        $this->crud->addField([
            'name'           => 'facebook_link',
            'type'           => 'text',
            'label'          => 'Facebook Link',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'facebook_title',
            'type'           => 'text',
            'label'          => 'Facebook Title',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'instagram_link',
            'type'           => 'text',
            'label'          => 'Instagram Link',
            'fake' => true,
        ]);
        $this->crud->addField([
            'name'           => 'instagram_title',
            'type'           => 'text',
            'label'          => 'Instagram Title',
             'fake' => true,
        ]);
        
        $this->crud->addField([
            'name'           => 'status',
            'type'           => 'radio',
            'label'          => 'Service Status',
            'options' => ["Active" => "Active", "Deactive" => "Deactive"],
            'default' => "Deactive",
            'inline'      => true,
        ]);

        $this->crud->addField([
            'name'           => 'featured',
            'type'           => 'checkbox',
            'label'          => 'Featured',
            'fake' => true,
        ]);


        $this->crud->addField([
            'name'           => 'heading',
            'type'           => 'text',
            'value'          => $this->getServiceSliderDetails('heading'),
            'default'        => $this->getServiceSliderDetails('heading'),
            'label'          => 'Heading',
            'tab'   => 'Slider Information',
             'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'content',
            'type'           => 'textarea',
            'value'          => $this->getServiceSliderDetails('content'),
            'default'        => $this->getServiceSliderDetails('content'),
            'label'          => 'Content Description',
            'tab'   => 'Slider Information',
            'fake' => true,
          ]);

          $this->crud->addField([   // Upload
            'name'   => 'image',
            'label'  => 'Upload Slide Image',
            'type'   => 'upload',
            'upload' => true,
            // 'disk' => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
            // optional:
            // 'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URL's this will make a URL that is valid for the number of minutes specified
            'tab' => 'Slider Information',
        ]);

       $this->crud->removeField('event_id');    
   
          }

          public function getServiceSliderDetails($fieldname=null)
          {
              $edit_value = "";
              $id = \Route::current()->parameter('id');       
              $Result = SupplierDetailsSlider::where('supplier_services_id',$id)->first();     
              if($Result){
                  $edit_value = $Result[$fieldname];
              }
              return $edit_value;
          }


    public function update(Supplier_servicesUpdateRequest $request)
    {
        // dd($request->all());    
       // $this->crud->setValidation(Supplier_servicesUpdateRequest::class);
        $validated = $request->validated();

        $Result = $request;
       
        $id = $Result->id;
        $status = $Result->status;
        $business_name = $Result->business_name;
        $service_description = $Result->service_description;
        
        $facebook_link  = $Result->facebook_link;
        $facebook_title = $Result->facebook_title;
        $instagram_link = $Result->instagram_link;
        $instagram_title = $Result->instagram_title;
        $featured = $Result->featured;
        $price_range = $Result->price_range;

        $supplier_services_data = [ 
            'business_name'=>$business_name,
            'service_description'=>$service_description,
            'price_range'=>$price_range,
            'status'=>$status,
            'facebook_link'=>$facebook_link,
            'facebook_title'=>$facebook_title,
            'instagram_link'=>$instagram_link,
            'instagram_title'=>$instagram_title,
            'featured'=>$featured];
    
        $supplier_services = Supplier_services::where('id',$id)->update($supplier_services_data);
  
        $heading = $Result->heading;
        $content = $Result->content;
        $images = $Result->image;

      
        $images_url = "";
           if($request->hasFile('image'))
          {
              $file = $request->file('image');
             
                  $path = $file->getClientOriginalName();
                  $name = time()."_".$path;
                  $destinationPath = public_path('/uploads/SupplierDetailsSlider/');
                  $images_url = '/uploads/SupplierDetailsSlider/'.$name;
                  $file->move($destinationPath,$name);
         

           $slider_data =  SupplierDetailsSlider::where('supplier_services_id',$id)->first();
            if($slider_data){
                if($heading==null || $heading==""){
                    $heading = $slider_data->heading;
                }
                if($content==null || $content==""){
                    $content = $slider_data->content;
                }
                if($images==null || $images==""){
                    $images_url = $slider_data->image;
                }
             }
              
              SupplierDetailsSlider::updateOrInsert(
                  ['supplier_services_id'=>$id],
                  ['heading'=>$heading,'content'=>$content,'image'=>$images_url]);
          
              }

        \Alert::success('Assign Service to supplier Successfully updated.')->flash();
        return \Redirect::to($this->crud->route);
        

        // do something after save
        ///return $response;
    }

    public function destroy($id)
    {

        SupplierDetailsSlider::where('supplier_services_id',$id)->delete();
        Supplier_assign_events::where('supplier_services_id',$id)->delete();   
        DB::table('supplier_reviews')->where('supplier_services_id',$id)->delete();
        DB::table('customers_wishlist')->where('supplier_services_id',$id)->delete();
        DB::table('customers_inquiry')->where('supplier_services_id',$id)->delete();
        DB::table('analytics')->where('supplier_services_id',$id)->delete();
         
       
        $this->crud->hasAccessOrFail('delete');
    
       return $this->crud->delete($id);
    }

    public function getTypeOfService(){
        $services = [];
        $results = Services::get();
       foreach($results as $item){
           $services[$item->id] = $item->name;
       }
        return $services;
     }
 
     public function getTypeOfEvent(){
         $services = [];
         $results = Events::get();
        foreach($results as $item){
            $services[$item->id] = $item->name;
        }
         return $services;
      }

      public function getSupplier(){
        $services = [];
        $results = Supplier::get();
       foreach($results as $item){
           $services[$item->id] = $item->name;
       }
        return $services;
     }

    public function addCustomCrudFilters()
    {
        $this->crud->addFilter([ // add a "simple" filter called Draft
            'type'  => 'simple',
            'name'  => 'featured',
            'label' => 'Featured',
        ],
        false, // the simple filter has no values, just the "Draft" label specified above
        function () { // if the filter is active (the GET parameter "draft" exits)
            $this->crud->addClause('where', 'featured', '1');
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

        $this->crud->addFilter([ // dropdown filter
            'name' => 'status',
            'type' => 'dropdown',
            'label'=> 'Status',
        ], ["Active" => "Active", "Deactive" => "Deactive"], function ($value) {
            // if the filter is active
            $this->crud->addClause('where', 'status', $value);
        });
    }
}
