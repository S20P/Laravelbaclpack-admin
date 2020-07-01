<div class="loader hide">
    <div class="loading">
        <img src="{{asset('images/loader.png')}}">
    </div>
</div>
<section class="account-information">
    <div class="container">
        <div class="row">
         <div class="col-sm-6 col-md-4 col-lg-3 profile-picture">
            <div class="profile">
                @if(isset($user_details['image']))
                <img src="{{ asset($user_details['image']) }}">
                @else
                <img src="{{ asset('images/profile-img.jpg') }}">
                @endif
            </div>
            <div class="edit-profile">
            <form method="POST" name="upload_profile_picture_form" id="upload_profile_picture_form" action="{{ route('supplier.profile') }}" enctype="multipart/form-data">
                 @csrf
                <input type="file" id="upload_profile" name="image" onChange="validate(this.value)" style="display: none;" accept="image/*"  />
            </form>
               <a href="javascript:;" class="upload_profile">
                    <i class="fal fa-edit"></i>
                </a>
            </div>
         </div>
        <div class="col-sm-12 col-md-8 col-lg-9 contact-informations">
            <div class="contact-area">                
                <div class="single-contact-box">
                    <span class="gradient-pink-text change_name">{{$user_details['name']}}</span>
                    <h1 class="business_title">{{$supplier_service_details[0]->business_name}}</h1>
                   
                    <a href="tel:{{$user_details['phone']}}" class="change_phone">
                    @if($user_details['phone'] != '')  
                    +@php
                         echo chunk_split($user_details['phone'], 3, ' ');
                         @endphp
                         @endif
                    </a>
                   
                    <a href="mailto:{{$user_details['email']}}" class="change_email">{{$user_details['email']}}</a>
                    <!-- <div id="customer_edit_account"><i class="fa fa-edit"></i></div> -->
                </div>
                <!-- <div class="account-nav">
                         <a class="common-btn" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </div> -->
                                 <div class="edit-btn">
                    <a href="javascript:;"  id="edit_account_profile"><i class="fal fa-edit"></i></a>
                    
                </div>
            </div>           
         </div>
        </div>
    </div>
</section>
<section class="breadcrumb-block">
    <div class="container">
        <ul class="breadcrumb-nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="#" class="active">SUPPLIERS T&C’S</a></li>
        </ul>
</section>