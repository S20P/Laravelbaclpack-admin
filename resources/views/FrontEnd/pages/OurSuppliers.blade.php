@extends('layouts.master',['title' => 'Our Suppliers'])
@section('content')
    <div id="parallax">
        <img id="our-supplier-layer-1" class="parallax"   src="{{asset('images/layers/circle.svg')}}">
        <img id="our-supplier-layer-3" class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
        <img id="our-supplier-layer-4" class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
    </div>
    <section class="home-page-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="banner">
                        @if(isset($supplierstlistbanner['image']))
                            <img src="{{ asset($supplierstlistbanner['image']) }} ">
                        @else
                            <img src="{{ asset('images/become-a-supplier.jpg') }}">
                        @endif
                    </div>
                    <div class="banner-text">
                        <h2 class="">@if(isset($supplierstlistbanner['content'])) {{ $supplierstlistbanner['content'] }} @else
                                Our Suppliers @endif</h2>
                    </div>
                    @php
                        $socials = getSocialDetails();
                    @endphp
                    <div class="social">
                        <ul>
                            @if(isset($socials) && $socials != '')
                                @foreach($socials as $socialdetails)
                                    @if($socialdetails->icon != '')
                                        <li><a href="{{$socialdetails->account_url}}" target="_blank"><i class="{{$socialdetails->icon}}"></i></a></li>
                                    @else($socialdetails->image != '')
                                        <li><a href="{{$socialdetails->account_url}}"><img src="{{asset($socialdetails->image)}}"></a> </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="banner-mobile-button">
                        <a data-toggle="modal" data-target="#filtersuppliers">Filter suppliers <span><img
                                        src="{{ asset('images/filter-icon.svg')}} "></span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="filtersuppliers" class="mobile-modal modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="sidebar-block">
                    <div class="title-block">
                        <span class="sub-heading">What are you</span>
                        <h2>Planning?</h2>
                        <a class="modal-close" data-dismiss="modal"><img src="{{ asset('images/modal-close.svg')}} "></a>
                    </div>
                    <div class="planning-filter">
                        <form method="post" id="filter_form_category" class="filter_form_category" action="{{route('OurSuppliers')}}">
                            @csrf
                            <div class="form-group custom-select">
                                @if(isset($filters['allevents']))
                                <select name="event_name">
                                    <option value="">Select Event</option>
                                    @foreach($filters['allevents'] as $key=>$allcategorydata)
                                        @if(isset($event) && $allcategorydata['id'] == $event['id'])
                                        <option value="{{$allcategorydata['id']}}" selected="selected">{{$allcategorydata['name']}}</option>
                                        @else
                                        <option value="{{$allcategorydata['id']}}">{{$allcategorydata['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>
                            <div class="form-group custom-select" >
                                @if(isset($filters['allservices']))
                                <select name="service_name">
                                     <option value="">Select Service</option>
                                    @foreach($filters['allservices'] as $key=> $allservicesdata)
                                        @if(isset($service) && !empty($service['id']) && ($allservicesdata['id'] == $service['id']))
                                        <option value="{{$allservicesdata['id']}}" selected="selected">{{$allservicesdata['name']}}</option>
                                        @else
                                        <option value="{{$allservicesdata['id']}}">{{$allservicesdata['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif  
                            </div>
                            <div class="form-group custom-select">
                                @if(isset($filters['alllocation']))
                                <select name="location" >
                                    <option value="">Select county</option>
                                    @foreach($filters['alllocation'] as $alllocationdata)
                                        <option value="{{$alllocationdata['id']}}" @if(isset($location)) @if($alllocationdata['id'] == $location) selected="selected" @endif @endif>{{$alllocationdata['location_name']}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                           <!--  <div class="row">
                            	<div class="col-6">
                                    <div class="form-group month-year">
                                        <select>
                                                <option selected="selected">MONTH</option>
                                                <option value="1">Jan</option>
                                                <option value="2">Feb</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">Aug</option>
                                                <option value="9">Sept</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <select id="select_year_mobile">
                                            <option selected="selected">YEAR</option>
                                        </select>
                                     </div>
                                </div>
 -->
                            <div class="form-group">
                                <label class="price_range"><span>PRICE RANGE</span></label>
                                <div class="price-range">
                                    @if(isset($pricerange))
                                        <div class="range-block">
                                            <input class="styled-checkbox"  @if($pricerange == "1")  checked="checked" @endif name="price_range" id="low_mob" type="radio" value="1">
                                            <label for="low_mob">€</label>
                                        </div>
                                        <div class="range-block">
                                            <input class="styled-checkbox" name="price_range"  @if($pricerange == "2")  checked="checked" @endif  id="medium_mob" type="radio" value="2">
                                            <label for="medium_mob">€€</label>
                                        </div>
                                        <div class="range-block">
                                            <input class="styled-checkbox" name="price_range" @if($pricerange == "3")  checked="checked" @endif  id="high_mob" type="radio" value="3">
                                            <label for="high_mob">€€€</label>
                                        </div>
                                    @else
                                        <div class="range-block">
                                            <input class="styled-checkbox"  name="price_range" id="low_mob" type="radio" value="1">
                                            <label for="low_mob">€</label>
                                        </div>
                                        <div class="range-block">
                                            <input class="styled-checkbox" name="price_range"   id="medium_mob" type="radio" value="2">
                                            <label for="medium_mob">€€</label>
                                        </div>
                                        <div class="range-block">
                                            <input class="styled-checkbox" name="price_range"   id="high_mob" type="radio" value="3">
                                            <label for="high_mob">€€€</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group text-center filter">
                                <button class="btn white-btn" type="submit" name="filter_button" value="FILTER"><span>FILTER</span></button>
                                <a class="reset-filter" id="mob_reset_filter_button" href="{{ route('OurSuppliers') }}">RESET FILTER</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="breadcrumb-block">
        <div class="container">
            <ul class="breadcrumb-nav">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#" class="active">Our Suppliers</a></li>
            </ul>
        </div>
    </section>

    <section id="our-suppliers-block">
        <div class="container">

    <div id="parallax">
        <img id="our-supplier-layer-2"  class="parallax"   src="{{asset('images/layers/shape-2.svg')}}">
    </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="left-sidebar">
                    <div class="sidebar-block planning-block">
                        <div class="title-block">
                            <span class="sub-heading">What are you</span>
                            <h2>Planning?</h2>
                        </div>
                        <div class="planning-filter">
                            <form method="post" id="filter_form_category" class="filter_form_category" action="{{route('OurSuppliers')}}">
                                @csrf
                                <div class="form-group custom-select">
                                    @if(isset($filters['allevents']))
                                    <select name="event_name">
                                        <option value="">Select Event</option>
                                        @foreach($filters['allevents'] as $key=>$allcategorydata)
                                            @if(isset($event) && $allcategorydata['id'] == $event['id'])
                                            <option value="{{$allcategorydata['id']}}" selected="selected">{{$allcategorydata['name']}}</option>
                                            @else
                                            <option value="{{$allcategorydata['id']}}">{{$allcategorydata['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="form-group custom-select">
                                    @if(isset($filters['allevents']))
                                    <select name="service_name">
                                         <option value="">Select Service</option>
                                        @foreach($filters['allservices'] as $key=> $allservicesdata)
                                            @if(isset($service) && !empty($service['id']) && ($allservicesdata['id'] == $service['id']))
                                            <option value="{{$allservicesdata['id']}}" selected="selected">{{$allservicesdata['name']}}</option>
                                            @else
                                            <option value="{{$allservicesdata['id']}}">{{$allservicesdata['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="form-group custom-select">
                                    @if(isset($filters['alllocation']))
                                    <select name="location">
                                        <option value="">Select county</option>
                                        @foreach($filters['alllocation'] as $alllocationdata)
                                            <option value="{{$alllocationdata['id']}}" @if(isset($location)) @if($alllocationdata['id'] == $location) selected="selected" @endif @endif>{{$alllocationdata['location_name']}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="price_range"><span>PRICE RANGE</span></label>
                                    <div class="price-range">
                                        @if(isset($pricerange))
                                            <div class="range-block">
                                                <input class="styled-checkbox"  @if($pricerange == "1")  checked="checked" @endif name="price_range" id="low" type="radio" value="1">
                                                <label for="low">€</label>
                                            </div>
                                            <div class="range-block">
                                                <input class="styled-checkbox" name="price_range"  @if($pricerange == "2")  checked="checked" @endif  id="medium" type="radio" value="2">
                                                <label for="medium">€€</label>
                                            </div>
                                            <div class="range-block">
                                                <input class="styled-checkbox" name="price_range" @if($pricerange == "3")  checked="checked" @endif  id="high" type="radio" value="3">
                                                <label for="high">€€€</label>
                                            </div>
                                            @else
                                            <div class="range-block">
                                                <input class="styled-checkbox"  name="price_range" id="low" type="radio" value="1">
                                                <label for="low">€</label>
                                            </div>
                                            <div class="range-block">
                                                <input class="styled-checkbox" name="price_range"   id="medium" type="radio" value="2">
                                                <label for="medium">€€</label>
                                            </div>
                                            <div class="range-block">
                                                <input class="styled-checkbox" name="price_range"   id="high" type="radio" value="3">
                                                <label for="high">€€€</label>
                                            </div>
                                        @endif
                                    </div>


                                </div>
                            <div class="form-group text-center filter">
                                <button class="btn white-btn" type="submit" name="filter_button" value="FILTER"><span>FILTER</span></button>
                                <a class="reset-filter" id="mob_reset_filter_button" href="{{ route('OurSuppliers') }}">RESET FILTER</a>
                            </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">

                @if(isset($vendors) && count($vendors) > 0)
                    @foreach($vendors as $key=>$vendorsdata)
                      <div class="our-block-list"  data-supplier-service="{{ $vendorsdata->ssid }}"  data-user="{{ $user_id ? $user_id : 0 }}">
                        <div class="our-block-list-img">
                            @if(isset($vendorsdata->image))
                                <img src="{{ asset($vendorsdata->image) }} ">
                            @else
                                <img src="{{ asset('images/avtar.png') }}">
                            @endif
                            @php
                                $ratings = getRatings($vendorsdata->ssid);
                            @endphp
                            <div class="mobile-blog-btn">
                                <ul class="gradient-rating">
                                    @for($j=1;$j <= 5; $j++)
                                        @if($j <= $ratings)
                                            <li><a href="" class="checked"><i class="fas fa-star"></i></a></li>
                                        @else
                                            <li><a href=""><i class="fal fa-star"></i></a></li>
                                        @endif
                                    @endfor
                                </ul>
                                <input type="hidden" name="supplier_service_id" class="supplier_service_id" value="{{$vendorsdata->ssid}}">
                                <a href="javascript:void(0)" class="obl-heart-btn {{ $user_id ? 'add_wishlist' : 'add_wishlist_new' }}">
                                     <i class="far fa-heart {{ wishExist($vendorsdata->ssid,$user_id ? $user_id : 0) }}"></i>
                                </a>
                            </div>
                        </div>
                        <div class="our-block-list-content">
                            <h4>{{$vendorsdata->business_name}}</h4>
                            <ul class="obl-nav">
                                <!-- <li><a href="">{{$vendorsdata->service_name}}</a></li> -->

                                <li><a >{{$vendorsdata->service_name}}</a></li>
                                <li><a >
                                @if(isset($vendorsdata->events) && count($vendorsdata->events) > 0)
                                @php 
                                $total = count($vendorsdata->events);
                                $i=0;
                                @endphp
                                @foreach($vendorsdata->events as $key=>$eventsdata)
                                @php   $i++;  @endphp
                                      {{$eventsdata->event_name}} 
                                      @if ($i != $total) 
                                      , 
                                     @endif

                               @endforeach
                                @endif
                                    </a></li>
                                <li><a >
                                    @if(isset($location) && $location != '')
                                            @php
                                              echo getLocationName($location);
                                            @endphp
                                    @else
                                            @php
                                            if($vendorsdata->location){
                                               $dataList = substr($vendorsdata->location, 1, -1);
                                               $dataList =  str_replace("\"","",$dataList);
                                               $dataList = explode(",",$dataList);
                                               echo getLocationName($dataList[0]);
                                            }
                                            @endphp
                                    @endif</a></li>
                                <li><a >
                                    @if($vendorsdata->price_range == 1)
                                        €
                                    @elseif($vendorsdata->price_range == 2)
                                        €€
                                    @elseif($vendorsdata->price_range == 3)
                                        €€€
                                    @else
                                    @endif
                                </a></li>
                            </ul>
                            <p>
                               
                                @php
                                                    if(strlen($vendorsdata->service_description) > 150){
                                                        $vendors_str = trim($vendorsdata->service_description,' ');
                                                        $pos=strpos($vendors_str, " ", 150);

                                                        echo substr($vendors_str,0,$pos);
                                                    }else{

                                                        echo $vendorsdata->service_description;
                                                    }
                                                @endphp
                            </p>
                            @php
                            $encid = base64_encode($vendorsdata->ssid);
                            @endphp
                            <div class="obl-bottom">
                                <div class="obl-button">
                                    <a class="common-btn btn" href="{{ route('SupplierDetailsPage',['slug' =>  $encid])}}">READ MORE</a>
                                    <input type="hidden" name="supplier_service_id" class="supplier_service_id" value="{{$vendorsdata->ssid}}">
                                    <a href="javascript:void(0)"  class="obl-heart-btn {{ $user_id ? 'add_wishlist' : 'add_wishlist_new' }}"><i class="far fa-heart {{ wishExist($vendorsdata->ssid,$user_id ? $user_id : 0) }}"></i></a>
                                   <!--    <a href="javascript:void(0)"  class="obl-heart-btn add_wishlist_new"><i class="far fa-heart {{ wishExist($vendorsdata->ssid,$user_id ? $user_id : 0) }}"></i></a> -->
                                </div>
                                <div class="olb-ratings">
                                    <ul class="gradient-rating">
                                    @for($j=1;$j <= 5; $j++)
                                        @if($j <= $ratings)
                                            <li><a href="javascript:0" class="rating-details checked"><i class="fas fa-star"></i></a></li>
                                        @else
                                            <li><a class="rating-details" href="javascript:0"><i class="fal fa-star"></i></a></li>
                                        @endif
                                    @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                        <div class="row">
                            <div class="col-12">

                                        <div class="alert-warning alerting" role="alert">
                                            No Artists Available...
                                        </div>

                            </div>
                        </div>
                @endif
                {{ $vendors->links() }}
              <!--       <ul class="pagination-block">
                        <li><a href="#">Previous</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">6</a></li>
                        <li><a href="#">7</a></li>
                        <li><a href="#">8</a></li>
                        <li><span class="space"></span></li>
                        <li><a href="#">18</a></li>
                        <li><a href="#">Next</a></li>
                    </ul> -->

                </div>
            </div>
        </div>
        <!-- Modal -->
         <div id="login_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
           <div class="modal-content">
               <h2>Login</h2>
                <!-- <p class="text-white">irst with customer account.</p> -->
                
                <a class="modal-close" data-dismiss="modal"><img src="{{asset('images/modal-close.svg')}}"></a>
                 <div class="login-detail">
                    <form method="post" name="profilelogincustomer" class="profilelogincustomer">
                        @csrf
                       <input type="hidden" name="customer_action" class="customer_action" >
                       <input type="hidden" name="supplier_service_id_popup" class="supplier_service_id_popup">
                       <input type="text" id="email_login" class="email_login" name="email" placeholder="Your Email Address">
                       <input type="password" id="password_login" class="password_login" name="password" placeholder="Your Password">
                       <div class="error_login"></div>
                       <button type="submit"class="btn white-btn" value="Login"><span class="gradient-pink-text">Login</span></button>
                    </form>
                    <div class="forgott">
                    <br>
                     <p> <a class="sign-up header-btn" href=""><span>Sign up</span></a> </p> 
                     <p> <a href="{{ route('password.reset','customer') }}">Forgot Your customer Profile Password?</a></p>
                    </div>
              </div>
           </div>
         </div>
       </div>
    </section>
@endsection
@section('page_plugin_script')
<script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
<script type="text/javascript">
    if($(window).width() > 767)
    {
        $('#our-suppliers-block .col-sm-12.col-md-4').theiaStickySidebar({
            additionalMarginTop: 20
        });
    }
    $(document).ready(function () {
            if(localStorage.getItem('add_wishlist_flag') == 1){
             $.toast({
                    heading: 'Success',
                     bgColor: '#007bff',
                    hideAfter: 5000,
                    text: 'This is added into wishlist.',
                    showHideTransition: 'slide',
                    icon: 'success',
                    position: 'top-right',
                })
             localStorage.setItem('add_wishlist_flag',0)
    }  
    if(localStorage.getItem('add_wishlist_flag') == 2){
             $.toast({
                    heading: 'Information',
                     bgColor: '#007bff',
                    hideAfter: 5000,
                    text: 'This is already added into wishlist.',
                    showHideTransition: 'slide',
                    icon: 'info',
                    position: 'top-right',
                })
             localStorage.setItem('add_wishlist_flag',0)
    }  
        <?php
if(isset($vendors)){
foreach($vendors as $key=>$vendorsdata){
  ?>
DoActionAnalytics("{{$key}}","{{$user_id}}","{{ $vendorsdata->ssid }}","impressions","");
  <?php
}
}
?>
		$(function () {


                                console.log("DoActionSearch method call search");  
                                DoActionSearch("{{$user_id}}","{{$service['id']}}","{{ $event['id'] ?? NULL }}","{{$location ?? NULL}}");
                            });
        // $('#select_year, #select_year_mobile').each(function() {
        //   var year = (new Date()).getFullYear();
        //   var current = year;
        //   for (var i = 0; i < 100; i++) {
        //     if ((year+i) == current)
        //       $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
        //     else
        //       $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
        //     }
        // })
        $("form[name='profilelogincustomer']").validate({
        rules: {
            email: {
                required: !0,
                email: !0
            },
            password: {
                required: !0,
                minlength: 6
            }
        },
        messages: {
            name: "Please enter your name",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address."
            }
        },
        submitHandler: function(e) {
            $('.error_login').empty();
            var data = $('.profilelogincustomer').serialize();
          $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url  : "{{route('profile.logincusstomer')}}",
                data : data,
                success : function(data){
                    if(data.success == true){
                        if(data.type == "add_wish"){
                            if(data.flag == 1){
                                localStorage.setItem('add_wishlist_flag', 1);
                            } else {
                                localStorage.setItem('add_wishlist_flag', 2);
                            }
                        }
                        location.reload(true);
                    }else{
                        if(data.role == "invalid"){
                            $('.error_login').append('<div class="alert alert-danger" role="alert">'+data.message+'</div>');
                        }else{
                            $('.error_login').append('<div class="alert alert-success" role="alert">'+data.message+'</div>');
                        }
                    }
                }
            });
        }
    })
        $('.add_wishlist_new').on('click',function (){
            $(".email_login").val("");
            $(".password_login").val("");
            $('.error_login').empty();
            $('.supplier_service_id_popup').val($(this).parent().find('.supplier_service_id').val());
            $('.customer_action').val('add_wish');
            $("#login_modal").modal();
        });
        $('.add_wishlist').on('click',function(){
            var selected = $(this);
            var supplier_service_id = $(this).parent().find('.supplier_service_id').val();
            if($(this).children().hasClass('wishlist-active'))
            {
               $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url  : "{{ route('customer.wishlistRemove') }}",
                data : { 'supplier_service_id': supplier_service_id },
                success : function(data){
                    if(data.success == true){
                        var list = selected.parents('.our-block-list');
                        // console.log
                       var ssid = list.attr('data-supplier-service');
                       var cid = list.attr('data-user');
                        // $('.our-block-list').attr('data-supplier');
                        $('.our-block-list').each(function(){
                            if($(this).attr('data-supplier-service') == ssid && $(this).attr('data-user') == cid )
                            {
                                $(this).find('i').removeClass('wishlist-active');
                            }
                        })
                         $.toast({
                            heading: 'Success',
                            bgColor: '#007bff',
                            hideAfter: 5000,
                            text: data.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'top-right',
                        })
                    }
                    else{
                        // $("#myReviewModal").modal();
                        $.toast({
                        heading: 'Error',
                        hideAfter: 5000,
                        text: 'Please login first with customer account!',
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                        })
                    }
                }
            });
            }
            else {
                $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url  : "{{ route('customer.wishlist') }}",
                data : { 'supplier_service_id': supplier_service_id},
                success : function(data){
                    if(data.success == true){
                        var list = selected.parents('.our-block-list');
                        // console.log
                        var ssid = list.attr('data-supplier-service');
                       var cid = list.attr('data-user');
                        // $('.our-block-list').attr('data-supplier');
                        $('.our-block-list').each(function(){
                            if($(this).attr('data-supplier-service') == ssid && $(this).attr('data-user') == cid)
                            {
                                $(this).find('i').addClass('wishlist-active');
                            }
                        })
                         $.toast({
                            heading: 'Success',
                            bgColor: '#007bff',
                            hideAfter: 5000,
                            text: data.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'top-right',
                        })
                    }
                    else{
                        // $("#myReviewModal").modal();
                        $.toast({
                        heading: 'Error',
                        hideAfter: 5000,
                        text: 'Please login first with customer account!',
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                        })
                    }
                }
            });
            }

        })
    })
</script>
<script type="text/javascript">
    $(window).parallaxmouse({
        invert: true,
        range: 400,
        elms: [{
            el: $('#our-supplier-layer-1'),
            rate: 0.2
        }, {
            el: $('#our-supplier-layer-2'),
            rate: 0.4
        }, {
            el: $('#our-supplier-layer-3'),
            rate: 0.2
        },
        {
            el: $('#our-supplier-layer-4'),
            rate: 0.2
        }]
    });
</script>
@endsection

