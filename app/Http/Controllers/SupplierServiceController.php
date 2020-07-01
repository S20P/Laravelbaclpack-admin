<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

use Auth;
use Session;
use App\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use App\Models\Location;
use Mail;
use Response;
use App\Models\Supplier_services;

use App\Models\Supplier_assign_events;
use App\Models\SupplierDetailsSlider;

class SupplierServiceController extends Controller
{
    public function getSupplierServices(Request $request,$supplier_id=null)
    {   
      
       $Result =  DB::table("supplier_services")
        ->where('supplier_services.supplier_id',$supplier_id)
        ->join('services', 'services.id', '=', 'supplier_services.service_id')
        ->join('supplier_assign_events', 'supplier_services.id', '=', 'supplier_assign_events.supplier_services_id')                                        
        ->join('events', 'supplier_assign_events.event_id', '=', 'events.id')
        ->select('services.name as service_name','events.name as event_name','supplier_services.*')
        ->get();   

        
        if(count($Result)){
            for($j=0;$j<count($Result);$j++){ 
            $location_store = [];
            $locations = json_decode($Result[$j]->location);
             for($i=0;$i<count($locations);$i++){
                $location_serach =  Location::where('id',$locations[$i])->value('location_name');  
                array_push($location_store,$location_serach);
             }
          
              if(count($location_store)){
                 $Result[$j]->location = $location_store;
              }
              if($Result[$j]->price_range==1){
                $Result[$j]->price_range = "Low";
                }
               if($Result[$j]->price_range==2){
                  $Result[$j]->price_range = "Medium";
               }
               if($Result[$j]->price_range==3){
                  $Result[$j]->price_range = "High";
               }
         }
        }
      
       return Response::json($Result);
    }     
     
   
    public function EditSupplierServices($id=null)
    {   
      $Result =  DB::table("supplier_services")
      ->where('supplier_services.id',$id)
      ->join('services', 'services.id', '=', 'supplier_services.service_id')
      ->join('supplier_assign_events', 'supplier_services.id', '=', 'supplier_assign_events.supplier_services_id')                                        
      ->join('events', 'supplier_assign_events.event_id', '=', 'events.id')
      ->select('services.name as service_name','events.name as event_name','supplier_services.*')
      ->first();     
    
     return Response::json($Result);
    }
 
    
    public function UpdateSupplierServices(Request $request)
    {
      // dd($request->all());
            $supplier_services_id = $request['supplier_services_id'];
          
            $Result = $request;
            
            $id = $Result->supplier_services_id;
            $business_name = $Result->business_name;
            $service_description = $Result->service_description;
            $facebook_link  = $Result->facebook_link;
            $instagram_link = $Result->instagram_link;
            $price_range = $Result->price_range;

            $location = $Result->location;
            $supplier_services_data = [ 
               'business_name'=>$business_name,
               'service_description'=>$service_description,
               'facebook_link'=>$facebook_link,
               'instagram_link'=>$instagram_link,
               'location'=>$location,
               'price_range'=>$price_range,
               "updated_at" => date('Y-m-d H:i:s'),
            ];
       
           $supplier_services = Supplier_services::where('id',$id)->update($supplier_services_data);
          
            if($supplier_services){
               return Response::json(["success"=>"Supplier service Updated Successfully."]);
           }
            return Response::json(["error"=>"Supplier service Updated failed."]);
    }


   public function RemoveSupplierServices(Request $request,$supplier_services_id=null)
   {
       $supplier_services_data =Supplier_services::where('id',$supplier_services_id)->delete();

       SupplierDetailsSlider::where('supplier_services_id',$supplier_services_id)->delete();
       Supplier_assign_events::where('supplier_services_id',$supplier_services_id)->delete();   
       DB::table('supplier_reviews')->where('supplier_services_id',$supplier_services_id)->delete();
       DB::table('customers_wishlist')->where('supplier_services_id',$supplier_services_id)->delete();
       DB::table('customers_inquiry')->where('supplier_services_id',$supplier_services_id)->delete();
       DB::table('analytics')->where('supplier_services_id',$supplier_services_id)->delete();

      if($supplier_services_data){
           return Response::json(["success"=>"Supplier services Deleted Successfully."]);
         }
      Session::flash('error', "The Supplier services cannot be deleted.");
   }


//Service slider crud

            public function EditServiceSlider($id=null)
            {   
            $Result = SupplierDetailsSlider::where('supplier_services_id',$id)->get()->toArray();     
            return Response::json($Result);
            }


            public function UpdateServiceSlider(Request $request)
            {
                 
               $id = $request['supplier_services_id'];
               
             

                    $Result = $request;

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
                    
                          SupplierDetailsSlider::Insert(
                              ['supplier_services_id'=>$id,'heading'=>$heading,'content'=>$content,'image'=>$images_url]);
                      }
                  
                    return Response::json(["success"=>"Supplier services Slider Saved Successfully."]);
            }



            

            public function DeleteServiceSlider(Request $request,$id=null)
            {
                $result = SupplierDetailsSlider::where('id',$id)->delete();
               if($result){
                return Response::json(["success"=>"Slide Deleted Successfully."]);
                // Session::flash('success', "Booking Deleted Successfully.");
                // return redirect()->back();   
                  }
            Session::flash('error', "The Slide cannot be deleted.");
            // return Response::json(["error"=>"The booking cannot be deleted."]);
            // return redirect()->back(); 
            }

//Service slider crud end

}
