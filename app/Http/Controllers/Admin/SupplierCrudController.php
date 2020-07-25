<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;


use App\Http\Requests\SupplierRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Supplier;
use App\Models\Supplier_services;
use App\Models\Services;
use App\Models\Events;
use App\Models\Supplier_assign_events;
use App\Models\SupplierDetailsSlider;
use App\Models\SupplierBankingDetails;
use DB;
use Auth;   
use Hash;
use Mail;
use App\Models\Location;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\EmailTemplatesDynamic as EmailTemplate;
use Crypt;

use Session;
/**
 * Class SupplierCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SupplierCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;


    public function setup()
    {
        $this->crud->setModel('App\Models\Supplier');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/supplier');
        $this->crud->setEntityNameStrings('supplier', 'suppliers');
        $this->crud->enableReorder('name', 0);
      
    }

    public function getUserID(){
       return Auth::guard('backpack')->user()->id;
    }

    protected function setupListOperation()
    {
        // $this->crud->addButtonFromView('bottom', 'bulk_clone', 'bulk_clone', 'end');
        // $this->crud->addButton('line', 'resend', 'model_function', 'Resend_Confirmation_Email', 'end');
        // $this->crud->addButtonFromView('line', 'moderate', 'moderate', 'beginning');
        $this->crud->addButtonFromModelFunction('line','approve_document', 'Resend_Confirmation_Email', 'beginning');

       CRUD::addColumns([
        [
        'name' => 'image', // The db column name
        'label' => "Profile image", // Table column heading
        'type' => "model_function",
         'function_name' => 'thumbnail_image',
         'limit' => 1000,
        ],
        'name','email','phone','address','city','status',
        [
            'label'     => 'TYPE OF SERVICE', // Table column heading
            'name'      => 'service_name', // the column that contains the ID of that connected entity;
            'type'      => 'model_function',
            'entity'    => 'Services', // the method that defines the relationship in your Model
            'function_name' => 'service_name', // foreign key model 
        ],
        // [
        //     'name' => 'resend_mail', // The db column name
        //     'label' => "Resend Confirmation Email",
        //     'fake' => true,
        //     'type' => "model_function",
        //     'function_name' => 'Resend_Confirmation_Email',
        //     'limit'=> 1000,
        // ],
       ]);

      // $this->crud->addClause('where', 'id', '=', $booking_id);
       
     // http://localhost:8000/admin/supplier?profile_id=1
      if(isset($this->crud->request->profile_id) && !empty($this->crud->request->profile_id)) {
        $profile_id = $this->crud->request->profile_id;
       $this->crud->addClause('where', 'id', '=', base64_decode($profile_id));
     }
     
        $this->crud->orderBy('lft');

      //  $this->crud->setFromDb();
        $this->crud->removeColumn('user_id');
        $this->addCustomCrudFilters();
        $this->crud->setDetailsRowView('crud::details_row.supplier');
        $this->crud->enableExportButtons();
    }


   public function show($id)
    {

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Moderate '.$this->crud->entity_name;
        
    $supplier =  DB::table("supplier_profile")->where('id',$id)->first();

    $supplier_services = DB::table("supplier_services")
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->where('supplier_services.supplier_id',$id)
        ->select('supplier_services.*','services.name as service_name')
        ->get()->toArray();

    $supplier_payment_info = DB::table("payment_transfer_info_supplier")->where('supplier_id',$id)->first();


        $this->data['supplier'] = $supplier;
        $this->data['supplier_services'] = $supplier_services;
        $this->data['supplier_payment_info'] = $supplier_payment_info;



        //     // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('crud::details_row.supplier', $this->data);
    
    }
    

    protected function setupCreateOperation()
    {

      
   
        $this->crud->setTitle('Add a new supplier');
        $this->crud->setHeading('Add a new supplier');
        $this->crud->setSubheading('','create');
       
    //   $user_id = $this->getUserID();

        $this->crud->addField([
            'name'           => 'name',
            'type'           => 'text',
            'label'          => 'Name',
            // 'fake' => true,
            // 'tab' => 'Supplier profile information',
        ]);

        $this->crud->addField([
            'name'           => 'email',
            'type'           => 'email',
            'label'          => 'Email Address',
            // 'fake' => true,
            // 'tab' => 'Supplier profile information',
        ]);

        $this->crud->addField([
            'name'           => 'phone',
            'type'           => 'number',
            'label'          => 'Phone',
            // 'fake' => true,
            // 'tab' => 'Supplier profile information',
        ]);


        $this->crud->addField([ 
            'name' => 'city',
            'label' => "City",
            'type' => 'select2_from_array',
            'options' =>$this->getTypeOfCity(),
            'allows_null' => false,
        ]);

        $this->crud->addField([
            'name'           => 'address',
            'type'           => 'textarea',
            'label'          => 'Address',
        ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Profile Image',
            'upload' => true,
            // 'disk' => 'public',
            // 'tab' => 'Supplier profile information',            
        ]);

        $this->crud->addField([
            'name'           => 'password',
            'type'           => 'password',
            'label'          => 'Password',
            // 'fake' => true,
            // 'tab' => 'Supplier profile information',
        ]);

        $this->crud->addField([
            'name'           => 'password_confirmation',
            'type'           => 'password',
            'label'          => 'Confirm Password',
            'fake' => true,
            // 'tab' => 'Supplier profile information',
        ]);

         $this->crud->addField([
            'name'           => 'status',
            'type'           => 'radio',
            'label'          => 'Profile Status',
            'options' => ["Approved" => "Approved", "Disapproved" => "Disapproved"],
            'default' => "Disapproved",
            'inline'      => true,
            // 'tab' => 'Supplier profile information',
        ]);
     

        $this->crud->addField([
            'name'           => 'business_name',
            'type'           => 'text',
            'label'          => 'Business name',
            'fake' => true,
            // 'tab' => 'Supplier Service information',            
        ]);

        $this->crud->addField([
            'name'           => 'service_description',
            'type'           => 'textarea',
            'label'          => 'Service description',
            'fake' => true,
            // 'tab' => 'Supplier Service information',            
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
            // 'tab' => 'Supplier Service information',            
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
            // 'tab' => 'Supplier Service information',            
        ]);
             	
        $this->crud->addField([           // Select_Multiple = n-n relationship
            'label' => "Location",
            'type' => 'select_multiple',
            'name' => 'location', // the db column for the foreign key
            'entity' => 'Location', // the method that defines the relationship in your Model
            'attribute' => 'location_name', // foreign key attribute that is shown to user
            'model' => "App\Models\Location",
            'fake' => true,
            // 'tab' => 'Supplier Service information',            

            // 'pivot' => true,
            // optional
            'options'   => (function ($query) {
                 return $query->orderBy('location_name', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

        $this->crud->addField([
            'name'           => 'supplier_services_status',
            'type'           => 'radio',
            'label'          => 'Supplier Services Status',
            'options' => ["Active" => "Active", "Deactive" => "Deactive"],
            'default' => "Deactive",
            'inline'      => true,
            'fake' => true,
            // 'tab' => 'Supplier Service information',            
        ]); 

        $this->crud->addField([
            'name'           => 'facebook_link',
            'type'           => 'text',
            'label'          => 'Facebook Link',
            'fake' => true,
            // 'tab' => 'Supplier Service information',            

        ]);

        $this->crud->addField([
            'name'           => 'facebook_title',
            'type'           => 'text',
            'label'          => 'Facebook Title',
            'fake' => true,
            // 'tab' => 'Supplier Service information',            

        ]);

        $this->crud->addField([
            'name'           => 'instagram_link',
            'type'           => 'text',
            'label'          => 'Instagram Link',
            'fake' => true,
            // 'tab' => 'Supplier Service information',            
        ]);
        $this->crud->addField([
            'name'           => 'instagram_title',
            'type'           => 'text',
            'label'          => 'Instagram Title',
             'fake' => true,
            // 'tab' => 'Supplier Service information',            
        ]);

        $this->crud->addField([
            'name'           => 'featured',
            'type'           => 'checkbox',
            'label'          => 'Featured',
            'fake' => true,
        ]);

// Supplier Service Slider details -------------------------------
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
            'name'   => 'slideimage',
            'label'  => 'Upload Slide Image',
            'type'   => 'upload',
            'upload' => true,
            'fake' => true,
            // 'disk' => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
            // optional:
            // 'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URL's this will make a URL that is valid for the number of minutes specified
            'tab' => 'Slider Information',
        ]);

// Supplier Service Slider details end-------------------------------


// Supplier Banking Payment details details -------------------------------

        $this->crud->addField([
            'name'           => 'account_holder_name',
            'type'           => 'text',
            'label'          => 'Account Holder Name',
            'tab'   => 'Payment Information',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'account_number',
            'type'           => 'text',
            'label'          => 'Account Number',
            'tab'   => 'Payment Information',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'bank_name',
            'type'           => 'text',
            'label'          => 'Bank Name',
            'tab'   => 'Payment Information',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'bank_address',
            'type'           => 'textarea',
            'label'          => 'Bank Address',
            'tab'   => 'Payment Information',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'ifsc',
            'type'           => 'text',
            'label'          => 'IFSC',
            'tab'   => 'Payment Information',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'iban',
            'type'           => 'text',
            'label'          => 'IBAN',
            'tab'   => 'Payment Information',
            'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'sortcode',
            'type'           => 'text',
            'label'          => 'Sort code',
            'tab'   => 'Payment Information',
            'fake' => true,
        ]);

// Supplier Banking Payment details details end-------------------------------

        $user_id = $this->getUserID();

        $this->crud->addField([
            'name'           => 'user_id',
            'type'           => 'hidden',
            'default'    =>  $user_id, 
        ]);
       
   
        $this->crud->setValidation(SupplierRequest::class);     
       $this->crud->setFromDb();  
       $this->crud->removeField('password_string');
       $this->crud->removeField('parent_id');
       $this->crud->removeField('lft');
       $this->crud->removeField('rgt');
       $this->crud->removeField('depth');

    }


    public function getTypeOfCity(){
        $services = [];
        $results = Location::get();
       foreach($results as $item){
           $services[$item->location_name] = $item->location_name;
       }
        return $services;
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
   

    public function store(SupplierRequest $request)
    {         
        $validated = $request->validated();
        // $response = $this->traitStore();
        //$Result = $this->crud->entry;
        $Result = $request;

      $status = $Result->status;
      $email  = $Result->email;
      $name = $Result->name;
      $password = $Result->password;
      $id = $Result->id;
      $user_id = $this->getUserID();
      $phone = $Result->phone;
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
      $supplier_services_status = $Result->supplier_services_status;

        $image = $request->file('image');
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/Supplier/');
        $image->move($destinationPath, $imagename);

       
         $approved_status = 0;
        if($status=="Approved"){
          $approved_status = 1;  
        }

    $supplier_profile_data = [ 
        'user_id'=>$user_id,
        'name' => $name,
        'email'=>$email,
        'password'=>Hash::make($password),
        'password_string'=>$password,
        'phone'=>$phone,
        'image' => "/uploads/Supplier/".$imagename,
        'status'=>$status,
        'approved_status'=>$approved_status
       ];

      $supplier_id = Supplier::insertGetId($supplier_profile_data);

      // Supplier Banking Payment details details end-------------------------------
      
      $account_holder_name = $Result->account_holder_name;
      $account_number = $Result->account_number;
      $ifsc = $Result->ifsc;
      $bank_name = $Result->bank_name;
      $bank_address = $Result->bank_address;
      $iban = $Result->iban;
      $sortcode = $Result->sortcode;

    $payment_details =  DB::table('payment_transfer_info_supplier')
          ->insert([
                  'supplier_id' => $supplier_id,
                  'account_holder_name' => $account_holder_name,
                  'account_number' => $account_number,
                  'ifsc' => $ifsc,
                  'bank_name' => $bank_name,
                  'bank_address' => $bank_address,
                  'iban' => $iban,
                  'sortcode' => $sortcode,
                  "created_at" => date('Y-m-d H:i:s'), # new \Datetime()
                  "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
              ]
          );

// Supplier Banking Payment details details end-------------------------------

      $supplier_services_data = [ 
        'supplier_id' =>$supplier_id,
        'service_id'=>$service_id,
        'business_name'=>$business_name,
        'service_description'=>$service_description,
        'location'=>$location,
        'price_range'=>$price_range,
        'status'=>$supplier_services_status,
        'facebook_link'=>$facebook_link,
        'facebook_title'=>$facebook_title,
        'instagram_link'=>$instagram_link,
        'instagram_title'=>$instagram_title,
        'featured'=>$featured];

    $supplier_services_id = Supplier_services::insertGetId($supplier_services_data);

    if($supplier_services_id){
         if(count($event_id)){
                for($i=0;$i<count($event_id);$i++){
                    Supplier_assign_events::create(['supplier_services_id'=>$supplier_services_id,'event_id'=>$event_id[$i]]);
                }
            }

            //Slider data

            $heading = $Result->heading;
            $content = $Result->content;
            $slideimage = $Result->slideimage;


                    if($request->hasFile('slideimage'))
                {
                    $file = $request->file('slideimage');
                    
             
                        $path = $file->getClientOriginalName();
                        $imagename = time()."_".$path;
                        $destinationPath = public_path('/uploads/SupplierDetailsSlider/');
                        $images_url = '/uploads/SupplierDetailsSlider/'.$imagename;
                        $file->move($destinationPath,$imagename);
                    
                  
                    SupplierDetailsSlider::insert(['supplier_services_id'=>$supplier_services_id,'heading'=>$heading,'content'=>$content,'image'=>$images_url]);
                }
                
     }
        
     $data = array(
                 'name'=>$name,
                 'email'=>$email,
                 'password'=>$password,
                 "phone" => $phone,
                );

                // Mail::send("emails.SupplierProfile_manually_created",$data, function($message) use ($email, $name)
                //  {
                //      $message->to($email, $name)->subject('Welcome!');
                //  });
 
            /*
            * @Author: Satish Parmar
            * @ purpose: This helper function use for send dynamic email template from db.
            */
            $template = EmailTemplate::where('name', 'SupplierProfile-manually-created')->first();
            $to_mail = $email;
            $to_name = $name;
            $view_params = [
                'name'=>$name, 
                'email'=>$email,
                'password'=>$password,
                "phone" => $phone,
                'base_url' => url('/'),
                'SupplierLogin_url' => url('/supplier-login')
            ];
            // in DB Html bind data like {{firstname}}
            send_mail_dynamic($to_mail,$to_name,$template,$view_params);
  
            /* @author:Satish Parmar EndCode */


                 \Alert::success('Supplier Profile is Successfully Created.')->flash();
                 return \Redirect::to($this->crud->route);

                //  Session::flash('success', "Supplier Profile is Successfully Created.");
                //  return redirect()->back()->with('success', "Supplier Profile is Successfully Created.");
    }   

    protected function setupUpdateOperation()
    {

     

         $this->crud->addField([
            'name'           => 'name',
            'type'           => 'text',
            'label'          => 'Name',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'email',
            'type'           => 'email',
            'label'          => 'Email Address',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'phone',
            'type'           => 'number',
            'label'          => 'Phone',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'address',
            'type'           => 'textarea',
            'label'          => 'Address',
        ]);

        $this->crud->addField([ 
            'name' => 'city',
            'label' => "City",
            'type' => 'select2_from_array',
            'options' =>$this->getTypeOfCity(),
            'allows_null' => false,
        ]);

         $this->crud->addField([
            'name'           => 'status',
            'type'           => 'radio',
            'label'          => 'Profile Status',
            'options' => ["Approved" => "Approved", "Disapproved" => "Disapproved"],
            'default' => "Disapproved",
            'inline'      => true,
        ]);

       $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image',
            'upload' => true,
            // 'disk' => 'public',
        ]);



// Supplier Banking Payment details details -------------------------------

$this->crud->addField([
    'name'           => 'account_holder_name',
    'type'           => 'text',
    'value'          => $this->getSupplierBankingDetails('account_holder_name'),
    'default'        => $this->getSupplierBankingDetails('account_holder_name'),
    'label'          => 'Account Holder Name',
    'tab'   => 'Payment Information',
    'fake' => true,
]);

$this->crud->addField([
    'name'           => 'account_number',
    'type'           => 'text',
    'value'          => $this->getSupplierBankingDetails('account_number'),
    'default'        => $this->getSupplierBankingDetails('account_number'),
    'label'          => 'Account Number',
    'tab'   => 'Payment Information',
    'fake' => true,
]);

$this->crud->addField([
    'name'           => 'bank_name',
    'type'           => 'text',
    'value'          => $this->getSupplierBankingDetails('bank_name'),
    'default'        => $this->getSupplierBankingDetails('bank_name'),
    'label'          => 'Bank Name',
    'tab'   => 'Payment Information',
    'fake' => true,
]);

$this->crud->addField([
    'name'           => 'bank_address',
    'type'           => 'textarea',
    'value'          => $this->getSupplierBankingDetails('bank_address'),
    'default'        => $this->getSupplierBankingDetails('bank_address'),
    'label'          => 'Bank Address',
    'tab'   => 'Payment Information',
    'fake' => true,
]);

$this->crud->addField([
    'name'           => 'ifsc',
    'type'           => 'text',
    'value'          => $this->getSupplierBankingDetails('ifsc'),
    'default'        => $this->getSupplierBankingDetails('ifsc'),
    'label'          => 'IFSC',
    'tab'   => 'Payment Information',
    'fake' => true,
]);

$this->crud->addField([
    'name'           => 'iban',
    'type'           => 'text',
    'value'          => $this->getSupplierBankingDetails('iban'),
    'default'        => $this->getSupplierBankingDetails('iban'),
    'label'          => 'IBAN',
    'tab'   => 'Payment Information',
    'fake' => true,
]);

$this->crud->addField([
    'name'           => 'sortcode',
    'type'           => 'text',
    'value'          => $this->getSupplierBankingDetails('sortcode'),
    'default'        => $this->getSupplierBankingDetails('sortcode'),
    'label'          => 'Sort code',
    'tab'   => 'Payment Information',
    'fake' => true,
]);


$this->crud->addField([
    'name'           => 'password',
    'type'           => 'password',
    'label'          => 'Password',
     'fake' => true,
     'tab' => 'Reset Password',
]);

$this->crud->addField([
    'name'           => 'password_confirmation',
    'type'           => 'password',
    'label'          => 'Confirm Password',
    'fake' => true,
    'tab' => 'Reset Password',
]);

// Supplier Banking Payment details details end-------------------------------

       $this->crud->setValidation(SupplierUpdateRequest::class);     
       $this->crud->setFromDb();  
          // $this->crud->setFromDb();
       $this->crud->removeField('user_id');
       $this->crud->removeField('password_string');
       $this->crud->removeField('parent_id');
       $this->crud->removeField('lft');
       $this->crud->removeField('rgt');
       $this->crud->removeField('depth');
    //    $this->crud->removeField('password');

    }


    public function getSupplierBankingDetails($fieldname=null)
    {
        $edit_value = "";
        $supplier_id = \Route::current()->parameter('id');       
        $Result = SupplierBankingDetails::where('supplier_id',$supplier_id)->first();     
        if($Result){
            $edit_value = $Result[$fieldname];
        }
        return $edit_value;
    }
    
    public function update(SupplierUpdateRequest $request)
    {


        $validated = $request->validated();
        // $response = $this->traitStore();
        //$Result = $this->crud->entry;
        $Result = $request;

          $response = $this->traitUpdate();
        //   $Result = $this->crud->entry;

          $status = $Result->status;
          $email  = $Result->email;
          $name = $Result->name;

          $id = $Result->id;
          $user_id = $this->getUserID();

           
           

          $supplier = Supplier::where('id',$id)->update([
            'user_id' => $user_id,
          ]);
        // Supplier Banking Payment details details end-------------------------------
          
     
        // Reset Password by admin
        $password = $Result->password;

        if($password && !empty($password) && $password !== "" && $password !== null){
            
            $update_approved_status = DB::table('supplier_profile')->where('id',$id)->update([
                 'password'=>Hash::make($password),
                 'password_string' => $password
              ]);

            /*
            * @Author: Satish Parmar
            * @ purpose: This helper function use for send dynamic email template from db.
            */
            $template = EmailTemplate::where('name', 'Reset-Password-By-Admin')->first();
            $to_mail = $email;
            $to_name = $name;
            $view_params = [
                'name'=>$name, 
                'email'=>$email,
                'base_url' => url('/'),
                'password' => $password
            ];
            // in DB Html bind data like {{firstname}}
            send_mail_dynamic($to_mail,$to_name,$template,$view_params);
  
         /* @author:Satish Parmar EndCode */

        }
       // Reset Password by admin

        $account_holder_name = $Result->account_holder_name;
        $account_number = $Result->account_number;
        $ifsc = $Result->ifsc;
        $bank_name = $Result->bank_name;
        $bank_address = $Result->bank_address;
        $iban = $Result->iban;
        $sortcode = $Result->sortcode;

        $payment_details =  DB::table('payment_transfer_info_supplier')
            ->updateOrInsert(
                ['supplier_id'=>$id],
                [
                    'account_holder_name' => $account_holder_name,
                    'account_number' => $account_number,
                    'ifsc' => $ifsc,
                    'bank_name' => $bank_name,
                    'bank_address' => $bank_address,
                    'iban' => $iban,
                    'sortcode' => $sortcode,                
                    "updated_at" => date('Y-m-d H:i:s'),  # new \Datetime()
                ]
            );

        // Supplier Banking Payment details details end-------------------------------

          $data = array(
            'name'=>$name,
            'email'=>$email,
           );

              $approved_status = Supplier::where('id',$id)->value('approved_status');


          if($status=="Approved" && $approved_status==0){


        $update_approved_status = DB::table('supplier_profile')->where('id',$id)->update([
            'approved_status' => '1',
          ]);
      
            // Mail::send("emails.Profile_approve_supplier",$data, function($message) use ($email, $name)
            // {
            //     $message->to($email, $name)->subject('Welcome!');
            // });

            /*
            * @Author: Satish Parmar
            * @ purpose: This helper function use for send dynamic email template from db.
            */
            $template = EmailTemplate::where('name', 'Profile-approve-supplier')->first();
            $to_mail = $email;
            $to_name = $name;
            $view_params = [
                'name'=>$name, 
                'email'=>$email,
                'base_url' => url('/'),
                'SupplierLogin_url' => url('/supplier-login')
            ];
            // in DB Html bind data like {{firstname}}
            send_mail_dynamic($to_mail,$to_name,$template,$view_params);
  
         /* @author:Satish Parmar EndCode */


          }

 
          if($status=="Disapproved" && $approved_status==1){

            $update_approved_status = DB::table('supplier_profile')->where('id',$id)->update([
                'approved_status' => '0',
              ]);

            /*
        * @Author: Satish Parmar
        * @ purpose: This helper function use for send dynamic email template from db.
        */
        // $subject = "Party Perfect - Account Disapproved";
        $template = EmailTemplate::where('name', 'Profile-disapprove-supplier-account')->first();
        $to_mail = $email;
        $to_name = $name;
        $view_params = [
            'name'=>$name, 
            'email'=>$email,
            'base_url' => url('/'),
        ];
        // in DB Html bind data like {{firstname}}
        send_mail_dynamic($to_mail,$to_name,$template,$view_params);

     /* @author:Satish Parmar EndCode */
      } 


        //  \Alert::success('Supplier Profile is Successfully updated.')->flash();
         // return \Redirect::to($this->crud->route);

        // do something after save
        return $response;
    }

    public function addCustomCrudFilters()
    {
    
        
    //    $this->crud->addFilter([ 
    //         'type'  => 'text',
    //         'name'  => 'name',
    //         'label' => 'Name',
    //     ],
    //     false,
    //     function ($value) { 
    //         $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
    //     });

    //     $this->crud->addFilter([ 
    //         'type'  => 'text',
    //         'name'  => 'email',
    //         'label' => 'Email',
    //     ],
    //     false,
    //     function ($value) { 
    //         $this->crud->addClause('where', 'email', 'LIKE', "%$value%");
    //     });
     
        
    $this->crud->addFilter([ // select2 filter
        'name' => 'service_id',
        'type' => 'select2',
        'label'=> 'Service'
      ], function() {
          return \App\Models\Services::all()->pluck('name', 'id')->toArray();
      }, function($value) { 

     // $this->crud->addClause('where', 'service_id', 'LIKE', "%$value%");

      $this->crud->query = $this->crud->query->whereHas('supplier_services', function ($query) use ($value) {
        $query->where('service_id', $value);
    });
   });


 $this->crud->addFilter([
            'name' => 'location',
            //'type' => 'select2_multiple',
            'type' => 'select2',
            'label'=> 'Location'
        ], function() {
            return \App\Models\Location::get()->pluck('location_name', 'id')->toArray();
        }, function($values) {
          
         $this->crud->addClause('join', 'supplier_services', function($query) use($values) {  
                         // join with function
                         $query->on('supplier_services.supplier_id', '=', 'supplier_profile.id')
                                ->where('location', 'LIKE', "%$values%");
        });
         $this->crud->addClause('select', 'supplier_profile.*');
        });


        $this->crud->addFilter([ // dropdown filter
            'name' => 'status',
            'type' => 'dropdown',
            'label'=> 'Status',
        ], ["Approved" => "Approved", "Disapproved" => "Disapproved"], function ($value) {
            // if the filter is active
            $this->crud->addClause('where', 'status', $value);
        });
    }

    public function destroy($id)
    {
        // Supplier::where('id',$id)->delete();
       $Supplier_services =  Supplier_services::where('supplier_id',$id)->get();
        if(count($Supplier_services)){
       foreach($Supplier_services as $key=>$value){
        SupplierDetailsSlider::where('supplier_services_id',$value->id)->delete();
        Supplier_assign_events::where('supplier_services_id',$value->id)->delete();   

        DB::table('supplier_reviews')->where('supplier_services_id',$value->id)->delete();
        DB::table('customers_wishlist')->where('supplier_services_id',$value->id)->delete();
        DB::table('customers_inquiry')->where('supplier_services_id',$value->id)->delete();
        DB::table('analytics')->where('supplier_services_id',$value->id)->delete();
          }
        }
        SupplierBankingDetails::where('supplier_id',$id)->delete();
        Supplier_services::where('supplier_id',$id)->delete();
        $this->crud->hasAccessOrFail('delete');
    
       return $this->crud->delete($id);
    }


    public function Resend_Confirmation_Email_Action(Request $request,$supplier_id)
    {

           $SupplierData = Supplier::where("id",$supplier_id)->first();
           if($SupplierData){

            $name =$SupplierData->name;
            $email =$SupplierData->email;
            $password =$SupplierData->password_string;
            $phone =$SupplierData->phone;
            /*
            * @Author: Satish Parmar
            * @ purpose: This helper function use for send dynamic email template from db.
            */
            $template = EmailTemplate::where('name', 'SupplierProfile-manually-created')->first();
            $to_mail = $email;
            $to_name = $name;
            $view_params = [
                'name'=>$name, 
                'email'=>$email,
                'password'=>$password,
                "phone" => $phone,
                'base_url' => url('/'),
                'SupplierLogin_url' => url('/supplier-login')
            ];
            // in DB Html bind data like {{firstname}}
            send_mail_dynamic($to_mail,$to_name,$template,$view_params);
  
            /* @author:Satish Parmar EndCode */
       
 
        \Alert::success('Confirmation Email Sent Successfully.')->flash();
        return \Redirect::to($this->crud->route);

           }

           \Alert::error('something went wrong.')->flash();
           return \Redirect::to($this->crud->route);

    }


}



