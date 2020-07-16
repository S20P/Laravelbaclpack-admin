<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Mail;
use Auth;
use Hash;
use App\Models\Customer;
use DB;
use App\Models\EmailTemplatesDynamic as EmailTemplate;
    

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }


    public function setup()
    {
        $this->crud->setModel('App\Models\Customer');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/customer');
        $this->crud->setEntityNameStrings('customer', 'customers');
    }

    public function getUserID(){
        return Auth::guard('backpack')->user()->id;
     }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
$this->addCustomCrudFilters();
        CRUD::addColumns([
            [
            'name' => 'image', // The db column name
            'label' => "Profile image", // Table column heading
            'type' => "model_function",
            'function_name' => 'thumbnail_image',
            'limit' => 1000,
            ],
            'name','email','phone','status'
        ]);

       // $this->crud->setFromDb();
        $this->crud->removeColumn('user_id');
        
        $this->crud->enableExportButtons();

    }

   public function show($id)
    {
         // get the info for that entry

        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud; 
        $this->data['records'] = $this->crud->getEntry($id);            
        return view('crud::details_row.Customer', $this->data);
      
    }

    protected function setupCreateOperation()
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
            'name'           => 'password',
            'type'           => 'password',
            'label'          => 'Password',
            // 'fake' => true,
        ]);

        $this->crud->addField([
            'name'           => 'password_confirmation',
            'type'           => 'password',
            'label'          => 'Confirm Password',
            'fake' => true,
        ]);

        // $this->crud->addField([
        //     'name'           => 'status',
        //     'type'           => 'radio',
        //     'label'          => 'Status',
        //     'options' => ["Approved" => "Approved", "Disapproved" => "Disapproved"],
        //     'default' => "Disapproved",
        //     'inline'      => true,
        // ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image/Icon',
            'upload' => true,
            'disk' => 'public',
        ]);

        $this->crud->setValidation(CustomerRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        $this->crud->removeField('user_id');
        $this->crud->removeField('status');
        $this->crud->removeField('password_string');
    }

       

    public function store()
    {
      // do something before validation, before save, before everything
      $response = $this->traitStore();
      $Result = $this->crud->entry; 
   
    //   $status = $Result->status;
      $email  = $Result->email;
      $name = $Result->name;
      $password = $Result->password;
      $id = $Result->id;
      $user_id = $this->getUserID();
      $phone = $Result->phone;
     

             $Customer = Customer::where('id',$id)
             ->update([
                 "status"=>'Approved',
                 'user_id' => $user_id,
                 'password_string' =>$password,
                 'password' => Hash::make($password),
               ]); 
         

            /*
            * @Author: Satish Parmar
            * @ purpose: This helper function use for send dynamic email template from db.
            */
                        $template = EmailTemplate::where('name', 'CustomerProfile-manually-created')->first();
                        $to_mail = $email;
                        $to_name = $name;
                        $view_params = [
                            'name'=>$name, 
                            'email'=>$email,
                            'password'=>$password,
                            "phone" => $phone,
                            'base_url' => url('/'),
                        ];
                        // in DB Html bind data like {{firstname}}
                        send_mail_dynamic($to_mail,$to_name,$template,$view_params);
              
            /* @author:Satish Parmar EndCode */

                // $data = array(
                //     'name'=>$name, 
                //     'email'=>$email,
                //     'password'=>$password,
                //     "phone" => $phone,
                //    );
                //  Mail::send("emails.CustomerProfile_manually_created",$data, function($message) use ($email, $name)
                //  {   
                //      $message->to($email, $name)->subject('Welcome!');
                //  });

      // do something after save
      return $response;
    }


    protected function setupUpdateOperation()
    {
    //    $this->crud->addField([
    //         'name'           => 'status',
    //         'type'           => 'radio',
    //         'label'          => 'Status',
    //         'options' => ["Approved" => "Approved", "Disapproved" => "Disapproved"],
    //         'default' => "Disapproved",
    //         'inline'      => true,
    //     ]);

        $this->crud->addField([
            'name'           => 'image',
            'type'           => 'upload',
            'label'          => 'Image/Icon',
            'upload' => true,
            'disk' => 'public',
        ]);

        $this->setupCreateOperation();
        $this->crud->removeField('user_id');
        $this->crud->removeField('password');
        $this->crud->removeField('password_confirmation');
        $this->crud->removeField('status');
        $this->crud->removeField('password_string');
    }

    public function update()
    {               
          $response = $this->traitUpdate();
          $Result = $this->crud->entry;  

        //   $status = $Result->status;
          $email  = $Result->email;
          $name = $Result->name;

        //   $data = array(
        //     'name'=>$name, 
        //     'email'=>$email, 
        //    );
          
        //   if($status=="Approved"){
        //      /*
        //     * @Author: Satish Parmar
        //     * @ purpose: This helper function use for send dynamic email template from db.
        //     */
        //     $template = EmailTemplate::where('name', 'Profile-approve-customer')->first();
        //     $to_mail = $email;
        //     $to_name = $name;
        //     $view_params = [
        //         'name'=>$name, 
        //         'email'=>$email,
        //         'base_url' => url('/'),
        //     ];
        //     // in DB Html bind data like {{firstname}}
        //     send_mail_dynamic($to_mail,$to_name,$template,$view_params);
  
        //  /* @author:Satish Parmar EndCode */

        //     // Mail::send("emails.Profile_approve_customer",$data, function($message) use ($email, $name)
        //     // {
        //     //     $message->to($email, $name)->subject('You’re in! Start planning');
        //     // });
        //   } 

        //   if($status=="Disapproved"){
        //         /*
        //     * @Author: Satish Parmar
        //     * @ purpose: This helper function use for send dynamic email template from db.
        //     */
        //    // $subject = "Party Perfect - Account Disapproved";
        //     $template = EmailTemplate::where('name', 'Profile-disapprove-customer')->first();
        //     $to_mail = $email;
        //     $to_name = $name;
        //     $view_params = [
        //         'name'=>$name, 
        //         'email'=>$email,
        //         'base_url' => url('/'),
        //     ];
        //     // in DB Html bind data like {{firstname}}
        //     send_mail_dynamic($to_mail,$to_name,$template,$view_params);
  
        //  /* @author:Satish Parmar EndCode */
        //   }
         

        // do something after save
        return $response;
    }

        public function addCustomCrudFilters()
        {
            $this->crud->addFilter([ // text filter
                'type'  => 'text',
                'name'  => 'name',
                'label' => 'Name',
            ],
            // false,
            true,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
            });

            $this->crud->addFilter([ // text filter
                'type'  => 'text',
                'name'  => 'email',
                'label' => 'Email',
            ],
            // false,
            true,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'email', 'LIKE', "%$value%");
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
}
