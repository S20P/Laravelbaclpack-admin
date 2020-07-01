@extends('layouts.master',['title' => 'Supplier Details'])
    @section('content')
        <div id="parallax">
            <img id="supplier-details-layer-1"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="supplier-details-layer-2"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
        </div>
                  @section('footer_scripts')
                        <script type="text/javascript">
                                $(function () {
                                console.log("DoActionAnalytics method call impressions");  
                                DoActionAnalytics("","{{$user_id}}","{{$vendors['supplier_service_id']}}","clicks_view","");
                            });
                    </script>
                    @stop
                     <div class="company-carousel">
                    <div class="container">
                        <div class="company-slider">
                            @if(isset($servicedetailsbanner) && $servicedetailsbanner != '')
                                @foreach($servicedetailsbanner as $servicedetailsbannerimage)
                                    @if(isset($servicedetailsbannerimage))
                                   
                                    <img src="{{ asset($servicedetailsbannerimage['image']) }}">
                                    @else
                                    <img src="{{ asset('images/company/company-img.jpg') }}">
                                    @endif
                                @endforeach
                                @else
                                <img src="{{ asset('images/company/company-img.jpg') }}">
                                <img src="{{ asset('images/company/company-img.jpg') }}">
                                <img src="{{ asset('images/company/company-img.jpg') }}">
                            @endif
                       </div>
                    </div>
                </div>
                @if(isset($vendors))
                <section class="breadcrumb-block">
                    <div class="container">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('OurSuppliers') }}">OUR SUPPLIERS</a></li>
                            <li><a  class="active">{{$vendors['business_name']}}</a></li>
                        </ul>
                    </div>
                </section>
                <section class="company-profile related-profile">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7 col-lg-8 left-part">
                                <div class="company-name">
                                    <span class="sub-heading gradient-pink-text">{{$vendors['supplier_name']}}</span>
                                     <h2>{{$vendors['business_name']}}</h2>
                                    <div class="share-btns">
                                        <a href="javascript:void(0)" class="{{ $user_id ? 'add_wishlist' : 'add_wishlist_new' }}"><i  class="far fa-heart {{ wishExistDetails($vendors['supplier_service_id'],$user_id ? $user_id : 0) }}"></i></a>
                                        <a data-toggle="modal" data-target="#share_modal" class="a2a_dd" href="#"><i class="fal fa-share"></i></a>

                                        <!-- <script async src="https://static.addtoany.com/menu/page.js"></script> -->
                                    </div>
                                    <div class="company-description wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.5s">
                                        <p>
                                          {{$vendors['service_description']}}
                                        <p>
                                    </div>
                                    <div class="company-info wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.5s">
                                        <ul>
                                            @if($vendors['facebook_title'] != '' && $vendors['facebook_link'] != '' )
                                            <li>
                                                <a href="{{$vendors['facebook_link']}}" target="_blank"><i class="fab fa-facebook-f"></i>{{$vendors['facebook_title']}}</a>
                                            </li>
                                            @endif
                                            @if($vendors['instagram_title'] != '' && $vendors['instagram_link'] != '')
                                            <li>
                                                <a href="{{$vendors['instagram_link']}}" target="_blank"><i class="fab fa-instagram"></i><span>@</span>{{$vendors['instagram_title']}}</a>
                                            </li>
                                                @endif
                                        </ul>
                                    </div>
                                </div>
                               <!--  <div class="event-details">
                                    <div class="row">
                                        <div class="col-md-12 event-service">
                                               <div class="table-responsive">
                                            <table class="table">
                                                  <thead>
                                                    <tr>
                                                      <th class="TYPE OF SERVICE" scope="col">TYPE OF SERVICE</th>
                                                      <th class="PRICE RANGE" scope="col">PRICE RANGE</th>
                                                      <th class="TYPE OF EVENT" scope="col">TYPE OF EVENT</th>
                                                      <th class="LOCATION(S)" scope="col">LOCATION(S)</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>

                                                    <tr>
                                                      <td data-th="TYPE OF SERVICE" class="service_dd"><p>{{$vendors['service_name']}}</p></th>
                                                      <td data-th="PRICE RANGE" class="range_dd">
                                                        <p>@if($vendors['price_range'] == "1") €
                                                    @elseif($vendors['price_range'] == "2")€ €
                                                    @elseif($vendors['price_range'] == "3") € € €
                                                    @else @endif</p></td>
                                                      <td data-th="TYPE OF EVENT" class="event_dd">

                                                        @if(isset($events))
                                                            @foreach($events as $key=>$event_id)
                                                                  @php
                                                                      echo '<p>'.getEventName($event_id['event_id']).'</p>';
                                                                  @endphp

                                                              @endforeach
                                                          @endif

                                                        </td>
                                                        <td>
                                                        @if(isset($vendors['location']))
                                                            @php
                                                                foreach ($vendors['location'] as $loc_id){
                                                                    echo "<p>".getLocationName($loc_id)."</p>";
                                                                }
                                                            @endphp
                                                        @endif
                                                        </td>

                                                    </tr>
                                                  </tbody>
                                                </table>
                                                </div>
                                        </div>
                                     
                                    </div>
                                </div> -->
                                <div class="event-details">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6">
                                            <div class="event-title">TYPE OF SERVICE</div>
                                            <ul>
                                                <li>{{$vendors['service_name']}}</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="event-title">PRICE RANGE</div>
                                            <ul>
                                                <li><p>@if($vendors['price_range'] == "1") €
                                                    @elseif($vendors['price_range'] == "2")€ €
                                                    @elseif($vendors['price_range'] == "3") € € €
                                                    @else @endif</p></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="event-title">TYPE OF EVENT</div>
                                            <ul>
                                                @if(isset($events))
                                                            @foreach($events as $key=>$event_id)
                                                                  @php
                                                                      echo '<li>'.getEventName($event_id['event_id']).'</li>';
                                                                  @endphp

                                                              @endforeach
                                                          @endif
                                               
                                            </ul>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="event-title">LOCATION(S)</div>
                                            <ul>
                                                @if(isset($vendors['location']))
                                                            @php
                                                                foreach ($vendors['location'] as $loc_id){
                                                                    echo "<li>".getLocationName($loc_id)."</li>";
                                                                }
                                                            @endphp
                                                        @endif
                                              
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="review">
                                    <h3>Reviews</h3>
                                   
                                    @if(isset($customerreviews))
                                    <div class="reviews-slider">
                                    @foreach($customerreviews as $reviewsdata)
                                    <div class="comment-block">
                                        <div class="user-img">
                                            @if(isset($reviewsdata->image))
                                                <img src="{{ asset($reviewsdata->image) }} ">
                                            @else
                                                 <img src="{{ asset('images/review-user.jpg') }}">
                                            @endif
                                        </div>
                                        <div class="user-comments">
                                            <div class="user-name">{{ $reviewsdata->name }}</div>
                                            <ul class="gradient-rating">
                                                @for($j=1;$j <= 5; $j++)
                                                    @if($j <= $reviewsdata->rates)
                                                        <li><a  class="checked"> <i class="fas fa-star"></i></a></li>
                                                    @else
                                                        <li><a ><i class="fal fa-star"></i></a></li>
                                                    @endif
                                                @endfor
                                            </ul>
                                            <p>{{ $reviewsdata->content_review }}</p>
                                        </div> 
                                    </div>
                                    @endforeach
                                    </div>
                                    @endif

                                    <form method="post" class="review_form" id="review_form" name="review_form" >
                                        @csrf
                                        <div class="leave-review">
                                            <div class="row align-items-center">
                                               
                                                <div class="col-md-9">
                                                    <div class="row align-items-center">
                                                        <input type="hidden" name="supplier_service_id" id="supplier_service_id" value="{{ $vendors['supplier_service_id'] }}">
                                                        <input type="hidden" name="user_id" id="user_id" value="{{$user_id ? $user_id : ''}}">
                                                        <!-- <div class="col-md-6"><p>LEAVE A REVIEW SUBMIT</p></div> -->
                                                        <div class="col-md-6">
                                                            <p>
                                                              <input type="text" name="text_reviews" placeholder="LEAVE A REVIEW" >
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                             <div class="rate">
                                                                    <input type="radio" id="star5" name="rate" value="5" />
                                                                    <label for="star5" title="text">5 stars</label>
                                                                    <input type="radio" id="star4" name="rate" value="4" />
                                                                    <label for="star4" title="text">4 stars</label>
                                                                    <input type="radio" id="star3" name="rate" value="3" />
                                                                    <label for="star3" title="text">3 stars</label>
                                                                    <input type="radio" id="star2" name="rate" value="2" />
                                                                    <label for="star2" title="text">2 stars</label>
                                                                    <input type="radio" id="star1" name="rate" value="1" />
                                                                    <label for="star1" title="text">1 star</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                <button type="submit" name="review_submit" id="review_submit" class="btn white-btn review_submit">   <span>submit</span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-4 right-part">
                                <div class="sidebar-block get-touch">
                                    <div class="title-block">
                                         <a href="#" data-toggle="modal" data-target="#get-in-touch"><h2>Get in Touch</h2>
                                           <i class="far fa-chevron-up new-btn-right"></i>
                                           <!-- <span><img src="{{asset('images/mobile-btn-drop.svg')}}"></span> -->
                                        </a>
                                        <div class="modal fade" id="get-in-touch" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="sidebar-block get-touch">         
                                                        <div class="get-touch-btn-block">
                                                                <h2>Get in Touch</h2>  <a class="modal-close" data-dismiss="modal"><img src="{{ asset('images/modal-close.svg')}}"></a>
                                                           <div id="accordion">
                                          <div class="card">
                                            <div class="card-header" id="headingOne">
                                              <h5 class="mb-0">
                                                <button class="btn white-btn"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                  <span class="gradient-pink-text">SEND A MESSAGE</span>
                                                </button>
                                              </h5>
                                            </div>

                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body inquiry-block">
                                                    <form method="post" name="inquiry_form" class="inquiry_form">
                                                        @csrf
                                                        <div class="get-touch-btn-block">
                                                            <div class="form-group">
                                                                <input type="hidden" name="supplier_service_id" value="{{ $vendors['supplier_service_id'] }}">
                                                                <input type="hidden" name="supplier_id" value="{{ $vendors['supplier_id'] }}">
                                                                <input type="hidden" name="supplier_name" value="{{ $vendors['supplier_name'] }}">
                                                                <input type="hidden" name="supplier_email" value="{{ $vendors['email'] }}">
                                                                <input type="hidden" name="service_name" value="{{ $vendors['service_name'] }}">
                                                              </div>
                                                             <div class="form-group">
                                                                <textarea  name="message" class="inquiry_message" rows="3" placeholder="Your message" required></textarea>
                                                            </div>
                                                            <button type="submit"  class="btn white-btn submit_inquiry"><span class="gradient-pink-text">SUBMIT ENQUIRY</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="card">
                                            <div class="card-header" id="headingTwo">
                                              <h5 class="mb-0">
                                                <button class="btn white-btn collapsed" OnClick='DoActionAnalytics("","{{$user_id}}","{{$vendors['supplier_service_id']}}","mobile_view","");' id="show_phone_btn" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                  SHOW PHONE NUMBER
                                                </button>
                                              </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                              <div class="card-body">
                                                {{$vendors['phone']}}
                                              </div>
                                            </div>
                                          </div>
                                          <div class="card">
                                            <div class="card-header" id="headingThree">
                                              <h5 class="mb-0">
                                                <button class="btn white-btn collapsed" OnClick='DoActionAnalytics("","{{$user_id}}","{{$vendors['supplier_service_id']}}","email_view","");' data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                 SHOW EMAIL ADDRESS
                                                </button>
                                              </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                              <div class="card-body">
                                                 {{$vendors['email']}}
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="get-touch-btn-block">
                                       <!--  <button type="submit" class="btn white-btn">SEND A MESSAGE</button>
                                        <button type="submit" class="btn white-btn">SHOW PHONE NUMBER </button>
                                        <button type="submit" class="btn white-btn">SHOW EMAIL ADDRESS</button> -->
                                        <div id="accordion">
                                          <div class="card">
                                            <div class="card-header" id="headingOne">
                                             <!--  <h5 class="mb-0">
                                                <button class="btn white-btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                  <span class="gradient-pink-text">SEND A MESSAGE</span>
                                                </button>
                                              </h5> -->
                                            </div>

                                            <div id="collapseOne" class="collapse1" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body inquiry-block">
                                                    <form method="post" name="inquiry_form2" class="inquiry_form2">
                                                        @csrf
                                                        <div class="get-touch-btn-block">
                                                            <div class="form-group">
                                                                <input type="hidden" name="mobile_popup" class="mobile_popup">
                                                                <input type="hidden" name="supplier_service_id" value="{{ $vendors['supplier_service_id'] }}">
                                                                <input type="hidden" name="supplier_id" value="{{ $vendors['supplier_id'] }}">
                                                                <input type="hidden" name="supplier_name" value="{{ $vendors['supplier_name'] }}">
                                                                <input type="hidden" name="supplier_email" value="{{ $vendors['email'] }}">
                                                                <input type="hidden" name="service_name" value="{{ $vendors['service_name'] }}">
                                                              </div>
                                                            <div class="form-group">
                                                                <textarea  name="message" class="inquiry_message" rows="3" placeholder="Your message" required></textarea>
                                                            </div>
                                                            <button type="submit" class="btn white-btn submit_inquiry"><span class="gradient-pink-text">SUBMIT ENQUIRY</span></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="card">
                                            <div class="card-header" id="headingTwo">
                                              <h5 class="mb-0">
                                                <button class="btn white-btn collapsed" OnClick='DoActionAnalytics("","{{$user_id}}","{{$vendors['supplier_service_id']}}","mobile_view","");' data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                  <span class="gradient-pink-text">SHOW PHONE NUMBER</span>
                                                </button>
                                              </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                              <div class="card-body">
                                                {{$vendors['phone']}}
                                              </div>
                                            </div>
                                          </div>
                                          <div class="card">
                                            <div class="card-header" id="headingThree">
                                              <h5 class="mb-0">
                                                <button class="btn white-btn collapsed" OnClick='DoActionAnalytics("","{{$user_id}}","{{$vendors['supplier_service_id']}}","email_view","");' data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                 <span class="gradient-pink-text">SHOW EMAIL ADDRESS</span>
                                                </button>
                                              </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                              <div class="card-body">
                                                 {{$vendors['email']}}
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Modal -->
                @endif
                <section class="featured-vendors related_suppliers">
                    <div class="container">
                        <div class="title-text wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                                <span class="sub-heading">Related</span>
                                <h2>Suppliers</h2>
                        </div>
                        <div class="vendor-slider">
                            @if(isset($featuredvendors))
                             @php
                                $j = 0.10;
                             @endphp
                                @foreach($featuredvendors as $featuredvendorsdata)
                                @php
                                    $sid = base64_encode($featuredvendorsdata['id']);
                                @endphp
                                <div class="vendor-item wow fadeInUp" data-wow-duration="{{$j}}s" data-wow-delay="0.1s">
                                    <div class="vendor-img">
                                        @if(isset($featuredvendorsdata['image']))
                                            <img src="{{ asset($featuredvendorsdata['image']) }} ">
                                        @else
                                            <img src="{{ asset('images/vendors/vendor-1.jpg') }}">
                                        @endif
                                    </div>
                                    <div class="company-desc">
                                        <div class="company-name">
                                            {{$featuredvendorsdata['business_name']}}
                                            <span>{{$featuredvendorsdata['service_name']}}</span>
                                        </div>
                                        <div class="vendor-detail">
                                            <p>
                                              @php
                                                    if(strlen($featuredvendorsdata['service_description']) > 120){
                                                        $vendors_str = trim($featuredvendorsdata['service_description'],' ');
                                                        $pos=strpos($vendors_str, " ", 125);
                                                        echo substr($vendors_str,0,$pos );
                                                    }else{

                                                        echo $featuredvendorsdata['service_description'];
                                                    }
                                                @endphp
                                            </p>
                                            <a class="btn common-btn" href="{{ route('SupplierDetailsPage',['slug' =>  $sid])}}">read more</a>
                                        </div>
                                    </div>
                                </div>
                                 @php
                                     $j += 1;
                                 @endphp
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myReviewModal" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                              <p id="success_messsage"></p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div> 
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="share_modal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                                <h2>Share page</h2> 

                            <div class="share_button">
                         
                             <a class="modal-close" data-dismiss="modal"><img src="{{asset('images/modal-close.svg')}}"></a>

                       <button class="btn white-btn" onclick="redirect_facebook('{{Request::url()}}','{{$vendors['business_name']}}')">
                                <span class="gradient-pink-text"> <i class="fab fa-facebook-f"></i>  share on facebook</span>
                        </button>

                        <button class="btn white-btn" onclick="redirect_instagram('https://www.instagram.com/')">
                                <span class="gradient-pink-text"> <i class="fab fa-instagram"></i> share on instagram</span>
                        </button>

                        <button class="btn white-btn" onclick="redirect_whatsapp('{{Request::url()}}','{{$vendors['business_name']}}')">
                                <span class="gradient-pink-text"> <i class="fab fa-whatsapp"></i> share in whatsapp</span>
                        </button>

                          </div>
                          <div class="cpy_link">
                            <input type="text" id="copy_link" name="copy_link" value="{{Request::url()}}" readonly>
                            <button class="btn white-btn copy_link" type="button" onclick="copy_text()"><span>copy link</span></button>
                              
                          </div> 
                         
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
                             </div>
                       </div>

                     </div>
                   </div>
                </section>






@endsection
@section('page_plugin_script')
<script type="text/javascript">
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
    if(localStorage.getItem('add_review_flag') == 1){
             $.toast({
                    heading: 'Success',
                     bgColor: '#007bff',
                    hideAfter: 5000,
                    text: 'Your review is submitted successfully.',
                    showHideTransition: 'slide',
                    icon: 'success',
                    position: 'top-right',
                })
             localStorage.setItem('add_review_flag',0)
    }  
    if(localStorage.getItem('add_inquiry_flag') == 1){
         $.toast({
                heading: 'Success',
                bgColor: '#007bff',
                hideAfter: 5000,
                text: 'Your inquiry is submitted successfully.',
                showHideTransition: 'slide',
                icon: 'success',
                position: 'top-right',
            })
         localStorage.setItem('add_inquiry_flag',0)
    }  
console.log("load...footer...");

         




                          console.log("image view call analytics1");

                        <?php
                        

                 if(isset($servicedetailsbanner) && $servicedetailsbanner != ''){

                        foreach($servicedetailsbanner as $key =>  $supplierdetailsbannerimage){
                        //if(isset($supplierdetailsbannerimage['image'])){
                          ?>
                         
                          DoActionAnalytics("{{$key}}","{{$user_id}}","{{$vendors['supplier_service_id']}}","photo_view","{{ asset($supplierdetailsbannerimage['image']) }}");
                          <?php
                        // }
                        // else
                        // {
                        ?>
                         // DoActionAnalytics("{{$key}}","{{$user_id}}","{{$vendors['supplier_service_id']}}","photo_view","{{ asset('images/company/company-img.jpg') }}");

                        <?php
                        // }
                        }
                        }
                        else{
                            ?>
                            console.log("No banner image");
                               DoActionAnalytics("{{$key}}","{{$user_id}}","{{$vendors['supplier_service_id']}}","photo_view","{{ asset('images/company/company-img.jpg') }}");

                      <?php  }
                        ?>




        $('#desk_event_id').on('change',function(){

           $('input[name="event_name_data"]').val($('option:selected', this).attr('data-name'));
        });
        $('.add_wishlist_new').on('click',function (){
            $(".email_login").val("");
            $(".password_login").val("");
            $('.error_login').empty();
            $('.supplier_service_id_popup').val($('input[name="supplier_service_id"]').val());
            $('.customer_action').val("add_wish");
            $("#login_modal").modal();
        });
        // Review validations
        $("form[name='review_form']").validate({
            rules: {
                text_reviews: "required",
            },
            // Specify validation error messages
            messages: {
                text_reviews: "Please enter your review ",
            },
            submitHandler: function (form) {
                if($('#user_id').val() == ""){
                    $(".email_login").val("");
                    $(".password_login").val("");
                    $('.error_login').empty();
                    $('.supplier_service_id_popup').val($('input[name="supplier_service_id"]').val());
                    $('.customer_action').val("add_review");
                    $("#login_modal").modal();
                    return false;
                }
                submitReview();
                return false;
            }
        });
        // Review validations
        $("form[name='inquiry_form']").validate({
            rules: {
                message: "required",
            },
            // Specify validation error messages
            messages: {
                message: "Please enter your message ",
            },
            submitHandler: function (form) {
                if($('#user_id').val() == ""){
                    $(".email_login").val("");
                    $(".password_login").val("");
                    $('.error_login').empty();
                    $('.supplier_service_id_popup').val($('input[name="supplier_service_id"]').val());
                    $('.customer_action').val("add_inquiry");
                    $('.mobile_popup').val("yes");
                    $("#login_modal").modal();
                    $("#get-in-touch").modal('hide');
                    return false;
                }
                $('.loader').removeClass('hide');
                $('.submit_inquiry').attr('disabled','disabled');
                var data =  $('.inquiry_form').serialize();
                $.ajax({
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url  : "{{ route('customer.inquiry') }}",
                    data : data,
                    success : function(data){

                        if(data.success == true){
                            $('.loader').addClass('hide');
                            $('.submit_inquiry').removeAttr('disabled','disabled');
                            $('.inquiry_message').val('');
                            $('.select_events').val('');
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
                            $('.loader').addClass('hide');
                            $('.submit_inquiry').removeAttr('disabled','disabled');
                            $.toast({
                                heading: 'Error',
                                hideAfter: 5000,
                                text: 'Please login first with customer account!',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-right',
                            })
                        }
                    },

                });
                return false;
            }
        });
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
            if($('.mobile_popup').val() == 'yes'){
                var data = $('.profilelogincustomer, .review_form, .inquiry_form').serialize();
            }
            else{
                var data = $('.profilelogincustomer, .review_form, .inquiry_form2').serialize();
            }
            
            // var data = $('.review_form').serialize();
          $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url  : "{{route('profile.logincusstomer')}}",
                data : data,
                success : function(data){
                    if(data.success == true){
                        if(data.type == "add_review"){
                            if(data.flag == 1){
                                localStorage.setItem('add_review_flag', 1);
                            }
                        }
                        if(data.type == "add_inquiry"){
                            if(data.flag == 1){
                                localStorage.setItem('add_inquiry_flag', 1);
                            }
                        }
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
        $("form[name='inquiry_form2']").validate({
            rules: {
                message: "required",
            },
            // Specify validation error messages
            messages: {
                message: "Please enter your message ",
            },
            submitHandler: function (form) {
                if($('#user_id').val() == ""){
                    $(".email_login").val("");
                    $(".password_login").val("");
                    $('.error_login').empty();
                    $('.supplier_service_id_popup').val($('input[name="supplier_service_id"]').val());
                    $('.customer_action').val("add_inquiry");
                    $("#login_modal").modal();
                    return false;
                }
                $('.loader').removeClass('hide');
                $('.submit_inquiry').attr('disabled','disabled');
                var data =  $('.inquiry_form2').serialize();
                $.ajax({
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url  : "{{ route('customer.inquiry') }}",
                    data : data,
                    success : function(data){

                        if(data.success == true){
                            $('.loader').addClass('hide');
                            $('.submit_inquiry').removeAttr('disabled','disabled');
                            $('.inquiry_message').val('');
                            $('.select_events').val('');
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
                            $('.loader').addClass('hide');
                            $('.submit_inquiry').removeAttr('disabled','disabled');
                            $.toast({
                                heading: 'Error',
                                hideAfter: 5000,
                                text: 'Please login first with customer account!',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-right',
                            })
                        }
                    },

                });
                return false;
            }
        });
         function submitReview() {
             // $('.loader').removeClass('hide');
            // e.preventDefault();
            $('.review_submit').attr('disabled','disabled');
            var supplier_service_id = $('input[name="supplier_service_id"]').val();
            var text_reviews = $('input[name="text_reviews"]').val();
            var rate = $('input[name="rate"]:checked').val();
            $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url  : "{{ route('customer.review') }}",
                data : { 'supplier_service_id': supplier_service_id, 'text_reviews': text_reviews, 'rate': rate },
                success : function(data){
                    if(data.success == true){
                       
                        // $('.loader').addClass('hide');
                         $.toast({
                            heading: 'Success',
                             bgColor: '#007bff',
                            hideAfter: 5000,
                            text: data.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'top-right',
                        })
                        $('input[name="text_reviews"]').val('');
                        $('input[name="rate"]').val('');
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
                     $('.review_submit').removeAttr('disabled','disabled');

                }
             });
        }
        $('.add_wishlist').on('click',function(){
            var selected = $(this);
            var supplier_service_id = $('input[name="supplier_service_id"]').val();
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
                            selected.children().removeClass('wishlist-active');
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
                    data : { 'supplier_service_id': supplier_service_id },
                    success : function(data){
                        if(data.success == true){
                            selected.children().addClass('wishlist-active')
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
        elms: [ {
            el: $('#supplier-details-layer-1'),
            rate: 0.4
        },
        {
            el: $('#supplier-details-layer-2'),
            rate: 0.4
        }
        ]
    });
    function redirect_facebook(url, business) {
        window.location.href = "https://www.facebook.com/sharer/sharer.php?u="+url+"&t="+business+"&quote=";
    }
    function redirect_whatsapp(url, business) {
        window.location.href = "https://api.whatsapp.com/send?text="+url;
    }
    function redirect_instagram(url) {
        window.location.href = url;
    }
    function copy_text() {
      /* Get the text field */
      var copyText = document.getElementById("copy_link");
      /* Select the text field */
      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/
      /* Copy the text inside the text field */
      document.execCommand("copy");
        $.toast({
                heading: 'Success',
                 bgColor: '#007bff',
                hideAfter: 2000,
                text: "Text Copied",
                showHideTransition: 'slide',
                icon: 'success',
                position: 'top-right',
            })
    }
</script>
@endsection
   
