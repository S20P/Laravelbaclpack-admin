<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Supplier;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Models\SliderModule;
use App\Models\HowItWork;
use App\Models\Location;
use App\Models\Testimonial;
use App\Models\Articles;
use App\Models\Supplier_services;
use App\Models\Supplier_assign_events;
use App\Models\SupplierReviews;
use App\Models\SupplierDetailsSlider;
use App\Models\Faqs;
use App\Models\Our_story;
use App\Models\GalleryModule;
use App\Models\Help;
use App\Models\Subscribe;
use App\Models\Pages;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Customer;
use App\Models\SiteDetails;
use Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Null_;
use Session;
use Mail;
use Response;
use App\Mail\TestEmail;
use MetaTag;
use PDF;


use App\Models\EmailTemplatesDynamic as EmailTemplate;

    

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private  $per_page;
    private  $admin_mail;
    public function __construct()
    {
        //$this->middleware('auth');
         $per_page_array = $this->getDetails();
         $this->per_page = $per_page_array->pagination_per_page;
         $this->admin_mail = $per_page_array->contact_email;
     

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $homebanner = SliderModule::select('content','image')->where('slug','home_page_banner')->first();
        $howitworks = HowItWork::select('content','image','step_number')->orderBy('step_number','asc')->take(5)->get();
        $testimonials = Testimonial::select('content_review_message','client_name','id')->orderBy('id','asc')->get();
        $benefits = Articles::join('articles_category', 'articles.category_id', '=', 'articles_category.id')
                            ->where('articles_category.slug','the-benefits')
                            ->where('articles.status','PUBLISHED')
                            ->orderBy('articles.date','desc')
                            ->limit(4)
                            ->get();
        $services = Services::select('id','name','image','slug','image_hover')->orderBy('id','asc')->get();
        $events = Events::select('id','name')->orderBy('id','asc')->get();
        // dd($events);
        $featuredvendors = $this->getFutureVendors();
        $getLocations = Location::get();
        return view('FrontEnd.home')->with(['homebanner' => $homebanner,'howitworks' => $howitworks,'locations' => $getLocations,'services' => $services,'testimonials' => $testimonials,'benefits' => $benefits,'featuredvendors' => $featuredvendors,'events'=>$events]);
    }
    public function displayFilterSupplier(Request $request)
    {
        $user_id = '';
        if(Auth::guard('customer')->user()){
            $user_id =  Auth::guard('customer')->user()->id;
        }
        $supplierstlistbanner = SliderModule::select('content','image')->where('slug','supplierst_list_page_banner')->first();
        $getserviceid =  Services::select('id','name')->Where([['id','=', ''.$request->service_name.'']])->first();
        $geteventid = Events::select('id','name')->Where([['id','=', ''.$request->event_name.'']])->first();
        $query  = DB::table('supplier_services')
                            
                            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                            ->leftJoin('location', 'supplier_services.location', '=', 'location.id')
                            ->join('services', 'supplier_services.service_id', '=', 'services.id')
                            ->where('supplier_services.status','Active')
                            ->where('supplier_profile.status','Approved')
                           ->groupby('supplier_id')
                           ->groupBy('service_id')
                           ->orderBy('supplier_profile.lft')
                                                      ->select('supplier_services.price_range','supplier_services.supplier_id as spid','supplier_profile.name as supplier_name','supplier_services.business_name','supplier_services.service_description','supplier_services.location','location.location_name as location_name','supplier_profile.image','services.name as service_name','services.price as service_price','supplier_services.service_id','supplier_services.id as ssid');
        if($request->service_name != ""){
            $query->Where([['supplier_services.service_id','=', ''.$request->service_name.'']]);
        }
        if($request->event_name != ""){
            $query->join('supplier_assign_events', 'supplier_services.id', '=', 'supplier_assign_events.supplier_services_id');
            $query->join('events', 'supplier_assign_events.event_id', '=', 'events.id');
            $query->Where([['events.id','=', ''.$request->event_name.'']]);
        }
        if($request->location != ""){
            $query->Where([['supplier_services.location','like','%\"'.$request->location.'\"%']]);
        }
        if($request->price_range != ""){
            $query->Where([['supplier_services.price_range',$request->price_range]]);
        }   
//    dd($this->per_page);
        $vendors = $query->paginate($this->per_page);

        foreach ($vendors as $key => $value) {

          $supplier_services_id =  $value->ssid;
          $events  =  DB::table('supplier_assign_events')
                     ->join('events', 'supplier_assign_events.event_id', '=', 'events.id')
                     ->select('events.name as event_name')
                     ->where('supplier_assign_events.supplier_services_id',$supplier_services_id)
                     ->get();
            $vendors[$key]->events = $events;
         }

        $vendors->appends(request()->input())->links();

        // dd($vendors);
        $filters =  $this->getFilters();

        return view('FrontEnd.pages.OurSuppliers')->with(['supplierstlistbanner'=>$supplierstlistbanner,'vendors'=> $vendors,'filters'=>$filters,'service'=>$getserviceid ,'event'=>$geteventid,'location'=>$request->location,'pricerange'=>$request->price_range,'user_id'=>$user_id]);
    }
    public function displayOurSupplier($slug = null)
    {
        $user_id = '';
        if(Auth::guard('customer')->user()){
            $user_id =  Auth::guard('customer')->user()->id;
        }
        $supplierstlistbanner = SliderModule::select('content','image')->where('slug','supplierst_list_page_banner')->first();
        $serviceid = Services::select('id')->where('slug',$slug)->first();
        // $data = SupplierAssignCategoryEvent::with('getSupAssCatRelation')->where([['event_id',$id]])->get();
        $vendors = DB::table('supplier_services')
                           // ->join('supplier_assign_events', 'supplier_services.id', '=', 'supplier_assign_events.supplier_services_id')
                            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                            ->leftJoin('location', 'supplier_services.location', '=', 'location.id')
                            ->join('services', 'supplier_services.service_id', '=', 'services.id')
                            ->select('supplier_services.price_range','supplier_services.supplier_id as spid','supplier_profile.name as supplier_name','supplier_services.business_name','supplier_services.service_description','supplier_services.location','location.location_name as location_name','supplier_profile.image','services.name as service_name','services.price as service_price','supplier_services.service_id','supplier_services.id as ssid')
                            ->where([['supplier_services.service_id',$serviceid->id]])
                            ->where('supplier_services.status','Active')
                            ->where('supplier_profile.status','Approved')
                            ->groupby('supplier_id')
                            ->groupBy('service_id')
                            ->orderBy('supplier_profile.lft')
                            ->paginate($this->per_page);

        // $featuredvendors = $this->getFutureVendors();
        $filters =  $this->getFilters();

        foreach ($vendors as $key => $value) {

            $supplier_services_id =  $value->ssid;
            $events  =  DB::table('supplier_assign_events')
                       ->join('events', 'supplier_assign_events.event_id', '=', 'events.id')
                       ->select('events.name as event_name')
                       ->where('supplier_assign_events.supplier_services_id',$supplier_services_id)
                       ->get();
              $vendors[$key]->events = $events;
           }


        return view('FrontEnd.pages.OurSuppliers')->with(['supplierstlistbanner'=>$supplierstlistbanner,'vendors'=> $vendors,'service'=> $serviceid,'filters'=>$filters,'user_id'=>$user_id]);
    }
    public function getSupplierDetails($slug = null){
        $supplier_service_id = base64_decode($slug);
        $vendors = [];
        $supplierdetailsbanner = [];
        if($supplier_service_id != ""){
            $servicedetailsbanner = SupplierDetailsSlider::select('image')->where('supplier_services_id',$supplier_service_id)->get();
            $vendors = Supplier_services::join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                                        ->join('services', 'supplier_services.service_id', '=', 'services.id')
                                        ->where([['supplier_services.id',$supplier_service_id]])
                                        ->select('supplier_services.price_range','supplier_services.supplier_id as supplier_id','supplier_profile.name as supplier_name','supplier_profile.image as company_image','supplier_services.business_name','supplier_services.service_description','supplier_services.location','services.name as service_name','services.price as service_price','supplier_services.service_id','supplier_services.id as supplier_service_id',
                                            'supplier_services.facebook_title','supplier_services.facebook_link','supplier_services.instagram_title','supplier_services.instagram_link','supplier_profile.email','supplier_profile.phone')
                                        ->first();
            if($vendors != ''){
                $vendors= $vendors->toArray();
            }
            if($servicedetailsbanner != ''){
                $servicedetailsbanner= $servicedetailsbanner->toArray();
            }
        }
        $events = Supplier_assign_events::select('event_id')->where('supplier_services_id',$supplier_service_id)->get();
        if($events != ''){
            $events = $events->toArray();
        }
//       $customerreviews = SupplierReviews::with('getSupplierReviews')->where([['status',1],['supplier_services_id',$supplier_service_id]])->get()->toArray();
        $customerreviews =  DB::table('supplier_reviews')
            ->join('customer_profile', 'supplier_reviews.customer_id', '=', 'customer_profile.id')
            ->where('supplier_reviews.supplier_services_id',$supplier_service_id)
            ->where('supplier_reviews.status',1)
            ->select('customer_profile.*','supplier_reviews.*')
            ->get();
        if($customerreviews != ''){
            $customerreviews = $customerreviews->toArray();
        }
        $featuredvendors = $this->getFutureVendors();
        $user_id = '';
        if(Auth::guard('customer')->user()){
            $user_id =  Auth::guard('customer')->user()->id;
        }
    	return view('FrontEnd.pages.SupplierDetails')->with(['user_id'=>$user_id,'vendors'=>$vendors,'events'=>$events,'featuredvendors' => $featuredvendors,'customerreviews'=> $customerreviews,'servicedetailsbanner'=>$servicedetailsbanner]);
                            // dd($vendors);
    }
    public function displayAllCategory($slug = null){
        $supplierstbanner = SliderModule::select('content','image')->where('slug','supplierst_page_banner')->first();
        $services_count = Services::count();
        $services = Services::select('id','name','image','slug','image_hover')->orderBy('id','asc')->skip(0)->take(11)->get();
        $featuredvendors = $this->getFutureVendors();
        $services_up = [];
        if($services_count >= 13){
        	$services_up = Services::select('id','name','image','slug','image_hover')->orderBy('id','asc')->skip(11)->get();
        }
        // dd($services);
        return view('FrontEnd.pages.BrowseSuppliers')->with(['supplierstbanner'=>$supplierstbanner,'services' => $services,'services_up' => $services_up,'featuredvendors' => $featuredvendors,'eventscatName'=>$slug]);
    }
    public function getFilters(){
        $allevents = Events::select('id','name')->orderBy('id','asc')->get()->toArray();
        $allservices = Services::select('id','name')->orderBy('id','asc')->get()->toArray();;
        $alllocation = Location::select('id','location_name')->orderBy('id','asc')->get();
        return array('allservices'=> $allservices,"allevents"=>$allevents,"alllocation"=>$alllocation);
    }
    public function getFutureVendors(){
        return Supplier_services::join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
                ->join('services', 'supplier_services.service_id', '=', 'services.id')
                ->select('supplier_services.id','service_description','supplier_profile.image','business_name','services.name as service_name')
                ->where([['supplier_profile.status','Approved'],['supplier_services.featured',1]])
                ->orderBy('supplier_profile.lft')
                ->get();
    }  
    public function becomeSupplierSignupform(Request $request){
        $becomeSupplierbanner = SliderModule::select('content','image')->where('slug','becomeSupplier_page_banner')->first();
        $pagecontent = pages::where('slug','become_supplier_page')->first();
        $meta_title = $pagecontent->meta_title;
        $meta_description = $pagecontent->meta_description;
        MetaTag::set('title', $meta_title);
        MetaTag::set('description', $meta_description);
        $getLocations = Location::get();
        $events =  Events::orderBy('name', 'ASC')->get();
        $services = Services::orderBy('name', 'ASC')->get();
        $currency_symbol = "";
        $SiteDetails =  SiteDetails::get()->first();
        if($SiteDetails){
            $currency_symbol = $SiteDetails->currency_symbol;
        }
         

        return view('FrontEnd.pages.BecomeSupplier',['locations' => $getLocations,"currency_symbol"=>$currency_symbol,'events'=>$events,'services'=>$services,'becomeSupplierbanner'=>$becomeSupplierbanner,'pagecontent'=> $pagecontent]);
    }
//    public function selectPriceRange(Request $request){
////        dd($request->categoryevents);
//        return view('FrontEnd.pages.pricetire');
//
//    }
    public function contactUS(){
        $contactbanner = SliderModule::select('content','image')->where('slug','contact_us_banner')->first();
        return view('FrontEnd.pages.contacts')->with(['contactbanner'=>$contactbanner]);
    }
    public function contactUsSend(Request $request){
//        dd($request->all());
        $sender_mail = $request->email;
        $name = $request->name;
        $admin_mail = $this->admin_mail;
        $subject = $request->subject;
        $messages = $request->message;
        $data = array(
            'type' => "Admin",
            'name'=>$name,
            'email'=>$sender_mail,
            'message_data'=> $messages,
            'subject'=>$subject,
        );
        $dataclient  = array(
            'type' => "User",
        );
//        dd($data);
//        dd($admin_mail);
        Mail::send("emails.ContactUsMail",$data, function($message) use ($admin_mail)
        {
            $message->to($admin_mail, 'Party Perfect')->subject('Contact Us : Party Perfect' );
        });
        Mail::send("emails.ContactUsMail",$dataclient, function($message) use ($sender_mail, $name)
        {
            $message->to($sender_mail, $name)->subject('Contact Us: Party Perfect' );
        });
        return response()->json(["success" => true, "message" => "Your message sent successfully!"]);
        
        // return  redirect()->back();
    }
    public function becomeSupplierSignup(Request $request){
        // dd($request->all());
        if(!empty($request->all())){
            $service_id =  $request['services'];
            $selectPrice = Services::select('id','price','name')->where('id',$service_id)->first()->toArray();
            return view('FrontEnd.pages.pricetire')->with(['selectprice'=>$selectPrice,'request'=>$request->all()]);
        } else {
            return redirect()->back();
        }
        
    }
    public function check_email_exists(Request $request)
     {
        $profile_type = $request->profile_type;
        $email = $request->email;

        if($profile_type=="supplier"){
           
            $Supplier_profile = Supplier::where('email', $email)->first();

            if($Supplier_profile){
              return "false";
            }
            else{
              return "true";
            }
        }
        if($profile_type=="customer"){
            $Supplier_profile = Customer::where('email', $email)->first();
            if($Supplier_profile){
                return "false";
            }else{
            return "true";
            }
        }
        return "true";
     }
      public function invoice($booking_id = null,Request $request){
        $booking = '';
         $user_id = '';
        if(Auth::guard('customer')->user()){
            $user_id =  Auth::guard('customer')->user()->id;
        }
        if(isset($booking_id) && $booking_id != ''){
            $request->session()->put('b_id', $booking_id);
            // $booking  = DB::table("booking")
            //     ->join('services', 'services.id', '=', 'booking.service_id')
            //     ->join('supplier_services', 'booking.supplier_services_id', '=', 'supplier_services.id')
            //     ->join('events', 'booking.event_id', '=', 'events.id')
            //     ->join('supplier_profile', 'booking.supplier_id', '=', 'supplier_profile.id')
            //     ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id')
            //     ->where('booking.id',base64_decode($booking_id))
            //     ->select('booking.id as booking_id','services.name as service_name','supplier_profile.name as sname','customer_profile.name as cname','supplier_profile.*','booking.*','events.name as event_name','supplier_services.*','booking.status as booking_status')
            // ->first();

            $booking =  DB::table('supplier_services')
            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
            ->join('booking', 'supplier_services.id', '=', 'booking.supplier_services_id')
            ->join('events', 'booking.event_id', '=', 'events.id')
            ->join('services', 'supplier_services.service_id', '=', 'services.id')
            ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id')
            ->where('booking.id',base64_decode($booking_id))
            ->select('booking.id as booking_id','services.name as service_name','supplier_profile.name as sname','customer_profile.name as cname','supplier_profile.*','booking.*','events.name as event_name','supplier_services.*','supplier_profile.id as supplier_id','booking.status as booking_status')
            ->first();

        }
//        dd($booking);
         return view('customer.invoice')->with(['booking'=> $booking,'user_id'=>$user_id]);
     }
     public function thankyou(){
         return view('thankyou');
     }
     public function our_Story(){
        $ourstorybanner = SliderModule::select('content','image')->where('slug','our_story_page_banner')->first()->toArray();
        $our_story = Our_story::first()->toArray();
         $benefits = Articles::join('articles_category', 'articles.category_id', '=', 'articles_category.id')
             ->where('articles_category.slug','the-benefits')
             ->where('articles.status','PUBLISHED')
             ->orderBy('articles.date','desc')
             ->limit(4)
             ->get();
        $gallery = GalleryModule::select('image')->where('type','our_story')->first()->toArray();
        return view('FrontEnd.pages.OurStory')->with(['our_story' =>$our_story,'ourstorybanner'=>$ourstorybanner,'benefits'=>$benefits, 'gallery' =>  $gallery]);
     }
     public function  blogListng(Request $request){
        $filter = [];
        if($request->search_key || $request->blog_filter_by ){
            $blogs =  Articles::join('articles_category', 'articles.category_id', '=', 'articles_category.id')
                ->where('articles_category.slug','blogs')
                ->where('status','PUBLISHED');
            if($request->blog_filter_by == "most_recent"){
                $blogs->orderBy('date','desc');
                $filter['blog_filter_by']= $request->blog_filter_by;
            }
            if($request->blog_filter_by == "oldest"){
                $blogs->orderBy('date','asc');
                $filter['blog_filter_by']= $request->blog_filter_by;
            }
            if($request->blog_filter_by == "all"){
                $blogs->Where([['articles.title','like', '%'.$request->search_key.'%']]);
                $filter['blog_filter_by']= $request->blog_filter_by;
            }
            if($request->search_key != ""){
                $blogs->Where([['articles.title','like', '%'.$request->search_key.'%']]);
                $filter['search_key']= $request->search_key;
            }
        }else{

            $blogs = Articles::join('articles_category', 'articles.category_id', '=', 'articles_category.id')
                ->where('articles_category.slug','blogs')
                ->where('status','PUBLISHED');
        }
         $blogs->select('articles.id as blog_id','articles.*','articles_category.*');
         $blogbanner = SliderModule::select('content','image')->where('slug','blog_page_banner')->first()->toArray();
         $blogs = $blogs->paginate($this->per_page);

         return view('FrontEnd.pages.Blog')->with(['blogbanner'=>$blogbanner,'blogs'=>$blogs,'filter'=>$filter]);
     }
     public function getBlogDetails($slug){
         $blog_id = base64_decode($slug);
         $blogdetails = [];
         if($blog_id != ""){
             $blogdetails =  Articles::get()->where('id',$blog_id)->first()->toArray();
         }
         $relatedblogs = $this->getrelatedArticles();
         return view('FrontEnd.pages.ArticleBlogPage')->with(['blogdetails'=>$blogdetails,'relatedblogs'=>$relatedblogs]);
     }
    public function getrelatedArticles(){
        return $relatedblogs = Articles::join('articles_category', 'articles.category_id', '=', 'articles_category.id')
            ->where('articles_category.slug','blogs')
            ->where('articles.status','PUBLISHED')
            ->where('articles.featured',1)
            ->orderBy('date','desc')
            ->select('articles.id as blog_id','articles.*','articles_category.*')
            ->get()->toArray();
    }
    public function getFaqs(Request $request){
        $filter = [];
        $faqs = Faqs::orderBy('created_at','desc');
        if($request->search_keyword) {
            $faqs->where([['faqs_module.key_word','like', '%'.$request->search_keyword.'%']])
            ->orwhere([['faqs_module.question','like', '%'.$request->search_keyword.'%']]);
        }
        $faqs = $faqs->get()->toArray();
        $pagecontent = pages::where('slug','faqs_page')->first();
        $meta_title = $pagecontent->meta_title;
        $meta_description = $pagecontent->meta_description;
        MetaTag::set('title', $meta_title);
        MetaTag::set('description', $meta_description);
        $faqabanner = SliderModule::select('content','image')->where('slug','faq_page_banner')->first();
        return view('FrontEnd.pages.Faq')->with(['faqs'=>$faqs,'faqabanner'=>$faqabanner,'filter'=>$request->search_keyword,'pagecontent'=>$pagecontent]);
    }
    public function getHelps(Request $request){
        $filter = [];
        $helps = Help::orderBy('created_at','desc');
        if($request->search_keyword) {
            $helps->where([['help_module.key_word','like', '%'.$request->search_keyword.'%']])
                ->orwhere([['help_module.question','like', '%'.$request->search_keyword.'%']]);
        }
        $helps = $helps->get()->toArray();
        $pagecontent = pages::where('slug','help_page')->first();
        $helpsbanner = SliderModule::select('content','image')->where('slug','help_page_banner')->first();

        $meta_title = $pagecontent->meta_title;
        $meta_description = $pagecontent->meta_description;
        MetaTag::set('title', $meta_title);
        MetaTag::set('description', $meta_description);

        return view('FrontEnd.pages.Help')->with(['helps'=>$helps,'helpsbanner'=>$helpsbanner,'filter'=>$request->search_keyword,'pagecontent'=>$pagecontent]);
    }

   public function getHelpsAjex(Request $request){
        $filter = [];
        $helps = Help::orderBy('created_at','desc');
       $output = "";
        if($request->search_keyword) {
            $helps->where([['help_module.key_word','like', '%'.$request->search_keyword.'%']])
                ->orwhere([['help_module.question','like', '%'.$request->search_keyword.'%']]);
        }
        $helps = $helps->get()->toArray();
        

         if($helps)
        {
        foreach ($helps as $hdepsdetails) {

       $output.='<div class="list-accordion">'.
                 '<div class="list-title">'.
                 '<h5>'.$hdepsdetails['question'].'</h5>'.
                 '<span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>'. '</div>'.
                             '<div class="list-accordion-content">'.
                 '<div class="list-accordion-content-box"><p>'.$hdepsdetails['answers'].'</p>'.
                                        '</div>'.
                                    '</div>'.
                                '</div>';
        }

}
else{

    $output ='<div class="row">
                                            <div class="col-12">
                                                <div class="alert-warning alerting" role="alert">
                                                    No Helps Available...
                                                </div>
                                            </div>
                                </div>';




                                

}
return Response($output);

      //  return response()->json(['helps'=>$helps]);
    }

    public function getDetails(){
        return DB::table('site_details')->first();
    }
    public function putSubscribe(Request $request){
        if($request->email != '' && filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $data = array('email' => $request->email, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
            $sub_id = DB::table('subscribe')->insert($data);
            return response()->json(["success" => true, "message" => "Your email is subscribe successfully!"]);
        }

    }
    public function check_subscribe_exists(Request $request){
            $email = $request->email;
            $Supplier_profile =  DB::table('subscribe')->where('email', $email)->first();
            if($Supplier_profile){
                return "false";
            }else{
                return "true";
            }
    }
    public function supplierTakeAndCare(){
        $takeandcarebanner = SliderModule::select('content','image')->where('slug','supplier-take-and-care')->first();
        $pagecontent = pages::where('slug','supplier-take-and-care')->first();
        $meta_title = $pagecontent->meta_title;
        $meta_description = $pagecontent->meta_description;
        MetaTag::set('title', $meta_title);
        MetaTag::set('description', $meta_description);
        return view('FrontEnd.pages.SupplierTackandCare')->with(['takeandcarebanner'=>$takeandcarebanner,'pagecontent'=>$pagecontent]);
    }


        public  function getEventsBysupplierService(Request $request,$supplier_services_id)
        {
            $supplier_assign_events =  DB::table("supplier_assign_events")
                ->where('supplier_assign_events.supplier_services_id',$supplier_services_id)
                ->join('events', 'supplier_assign_events.event_id', '=', 'events.id')
                ->select('events.name as event_name','events.id as event_id')
                ->get();   
       
                return Response::json($supplier_assign_events);
        }
    public function supplierLogin(){
         Auth::guard('supplier')->logout();
          Auth::guard('customer')->logout();
        return view('FrontEnd/pages.supplierlogin');
    }
    public function readMessages(Request $request)
    {
        $user_id = $request->customer_id;
        $supplier_services_id = $request->supplier_services_id;
        $type = $request->type;
        if($user_id != "" && $supplier_services_id != ""){
            if($type == "supplier"){
             DB::table('customers_inquiry')
                    ->where('read_unread', 0)
                    ->where('status',0)
                    ->where('supplier_services_id', $supplier_services_id)
                    ->where('customer_id', $user_id)
                    ->update(['read_unread' => 1]);
            }else{
                DB::table('customers_inquiry')
                    ->where('read_unread', 0)
                    ->where('status',1)
                    ->where('supplier_services_id', $supplier_services_id)
                    ->where('customer_id', $user_id)
                    ->update(['read_unread' => 1]);
            }
            return Response::json(["success"=>true]);
        } else {
            return Response::json(["success"=>false]);
        }
    }

    public function locations(Request $request){
        $getLocations = Location::get();
        return $getLocations;
    }

          
    /*
    * @Author: Satish Parmar
    * @ purpose: This function use for testing.
    */

    public function test(Request $request){

       echo "TEST Function Called";


       return;
       $template = EmailTemplate::where('name', 'welcome-email')->first();
       $to_mail = "armorier@spumartes.tk";
       $to_name = "MY Dyanmic Name";
       $view_params = [
        'firstname' => "Alex",
        'base_url' => url('/'),
       ];

       // The 'send_mail_dynamic' helper function use send dynamic email template from db.
       // in DB Html bind data like {{firstname}}
       send_mail_dynamic($to_mail,$to_name,$template,$view_params);
      
    // This below code use without helper
    //    Mail::send([], [], function($message) use ($to_mail,$template,$user)
    //    {
    //        $data = [
    //            'firstname' => "Alex"
    //        ];
           
    //        $message->to($to_mail, $user['fullname'])
    //            ->subject($template->subject)
    //            ->setBody($template->parse($data),'text/html');
    //    });

       echo "<br>";
       echo "Dynamic Template mail send Successfully!";


    }
    //  @author:Satish Parmar EndCode

    
    public function customer_email_list(Request $request){
        $customer_emails = Customer::select('email')->get()->toArray();
        return Response::json(["customer_emails"=>$customer_emails]); 
    }

    public function ExportAllSupplierCSV(Request $request){

        $FileName = asset("data/cfdb7-2020-07-07.csv");

        $file = public_path('data/cfdb7-2020-07-07.csv');

        $dataArr = $this->csvToArray($file);

        for ($i = 0; $i < count($dataArr); $i ++)
        {

            // "Form_id" => "134"
            // "Form_date" => "07-07-2020 12:49"
            // "Status" => "unread"
            // "Name" => "Michael O’Shea"
            // "Email" => "michael@talentfinderireland.com"
            // "Address" => "Monrovia"
            // "City" => "Monrovia"
            // "Phone" => "84361568814"
            // "Workphone" => "84314399555"
            // "Business" => ""
            // "Service" => "Band"
            // "Message" => """
            //   Due to the current pandemic, there is a surge of good quality candidates available at the \r\n
            //   moment. \r\n
            //   If you are thinking about recruiting, now is a good time to advertise. \r\n
            //   We have the perfect solution for you. \r\n
            //   We will create a professionally written job advert and advertise across all of the major job \r\n
            //   boards: \r\n
            //   Indeed \r\n
            //   Jobs.ie \r\n
            //   LinkedIn \r\n
            //   Facebook \r\n
            //   Twitter \r\n
            //   Instagram \r\n
            //   CV Library \r\n
            //   Google for Jobs \r\n
            //   Advertise for 28 days from as little as €299, with discounts available for multiple job adverts. \r\n
            //   To find out more, call me on (01) 9069204 or reply to this email \r\n
            //   michael@talentfinderireland.com \r\n
            //   Many thanks, \r\n
            //   Michael O’Shea

            $name = $dataArr[$i]['Name'];
            $email = $dataArr[$i]['Email'];
            $name = $dataArr[$i]['Name'];
            $phone = $dataArr[$i]['Phone'];
            $City = $dataArr[$i]['City'];
            $Address = $dataArr[$i]['Address'];

            $password = "123456";

             DB::table('supplier_profile')->Insert([
                'user_id' => 0,
                'name' => $name,
                'email' => $email,
                'city' => $City,
                'address' => $Address,
                'password' => Hash::make($password),
                'password_string' => $password,
                'phone' => $phone,
                'status'=>"Disapproved",
               ]);
        }
    
        return "Successfully saved data from CSV.";


    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;
    
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
    
    public function invoice_download($booking_id = null,Request $request){
        $booking = '';
         $user_id = '';
        if(Auth::guard('customer')->user()){
            $user_id =  Auth::guard('customer')->user()->id;
        }
        if(isset($booking_id) && $booking_id != ''){
            $booking =  DB::table('supplier_services')
            ->join('supplier_profile', 'supplier_services.supplier_id', '=', 'supplier_profile.id')
            ->join('booking', 'supplier_services.id', '=', 'booking.supplier_services_id')
            ->join('events', 'booking.event_id', '=', 'events.id')
            ->join('services', 'supplier_services.service_id', '=', 'services.id')
            ->join('customer_profile', 'booking.customer_id', '=', 'customer_profile.id')
            ->where('booking.id',$booking_id)
            ->select('booking.id as booking_id','services.name as service_name','supplier_profile.name as sname','customer_profile.name as cname','supplier_profile.*','booking.*','events.name as event_name','supplier_services.*','supplier_profile.id as supplier_id')
            ->first();

            if($booking){
                $booking = (array) $booking;
            view()->share('getBooking',$booking);
           // $pdf = PDF::loadView('emails.Order_Complete_User');
           //  $invoice_download_link = $pdf->download('invoice.pdf');
            
             $filename = base64_encode($booking_id)."_invoice".date('Y_m_d_H_i_s').".pdf";

             PDF::loadView('emails.Order_Complete_User')->save(public_path('uploads/Invoice-pdf/'.$filename))->stream('invoice.pdf');

             $invoice_download_link = asset('uploads/Invoice-pdf/'.$filename);

            return Response::json(["success"=>"Invoice download Successfully","invoice_download_link"=>$invoice_download_link,"invoice_download_file"=>$filename]);
            }else{
                return Response::json(["error"=>" No Invoice Found..."]);
            }
        }else{
            return Response::json(["error"=>" No Invoice Found..."]);
        }
     }


     public function ProfileVerificationByEmailLink(Request $request, $customer_id)
     {
         $user = Customer::where('id',base64_decode($customer_id))->first();
 
             if($user){
                
                 if($user->status == "Approved"){
                   //  return response()->json(["success" => "This Profile is already in verified."]);
                     Session::flash('success', "This Profile is already in verified.");
                  
                     return redirect()->route("home");

                 }
                 if($user->status == "Disapproved"){
                     $Customer = Customer::where('id',base64_decode($customer_id))->update([
                         'status' => "Approved",
                        ]);
 
                   //  return response()->json(["success" =>  "This Profile is Successfully verified."]);

                     Session::flash('success', "This Profile is Successfully verified.");
                  
                     return redirect()->route("home");

                 }
             }else{
                // return response()->json(["error" => "Profile not found."]);
                 Session::flash('error', "Profile not found.");
                  
                 return redirect()->route("home");
             }
  
     }

}
