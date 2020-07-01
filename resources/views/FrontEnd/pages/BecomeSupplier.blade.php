@extends('layouts.master',['title' => 'Become Supplier'])
    @section('content')
    
        <div id="parallax">
            <img id="become-supplier-layer-1"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="become-supplier-layer-2"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="become-supplier-layer-3"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
        </div>
    <section class="home-page-banner">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="banner">
                                    @if(isset($becomeSupplierbanner['image']))
                                        <img src="{{ asset($becomeSupplierbanner['image']) }} ">
                                    @else
                                        <img src="{{ asset('images/become-a-supplier.jpg') }}">
                                    @endif

                                <div class="banner-text">
                                    <h2 class="">                                   
                                    @if(isset($becomeSupplierbanner['content'])) {{ $becomeSupplierbanner['content'] }} @else
                                    Become a Supplier @endif 
                                    </h2>
                                </div>
                                    
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
                                    <a data-toggle="modal" data-target="#createanaccount">Create an account <span><img src="{{asset('images/mobile-btn-drop.svg')}}"></span></a>
                                </div>
                                <div id="createanaccount" class="mobile-modal modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="sidebar-block">
                                                <div class="title-block">
                                                    <h2>Create an account</h2>
                                                    <a class="modal-close" data-dismiss="modal"><img src="{{asset('images/modal-close.svg')}}"></a>
                                                </div>
                                                <div class="planning-filter">
                                                    <form method="POST" action="{{ route('BecomeSupplierSignup') }}" name="BecomeSupplierSignupmobile">
                                                        @csrf
                                                        <div class="form-group">
                                                            <input type="text" name="name" placeholder="Your name">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" name="business_name" placeholder="Your Business name">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" name="email" class="BecomeSupplierEmailmob" placeholder="Your email address">
                                                        </div>
                                                        <div class="form-group">
                                                            <input min="0" type="number" name="phone" placeholder="Your phone number">
                                                        </div>
                                                        <div class="form-group">
                                                            <input class="BecomeSupplierPasswordmob" type="password"  name="password" placeholder="Your Password" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <input id="" type="password" name="password_confirmation" placeholder="Your Confirm Password" autocomplete="off">
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <textarea rows="3" name="address" placeholder="Your full address"></textarea>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <div class="custom-select">
                                                                <select class="services services_mobile" name="services">
                                                                    <option value="">TYPE OF SERVICE</option>
                                                                    @if(isset($services) && $services != "")
                                                                        @foreach($services as $key=>$value)
                                                                            <option value="{{$value->id}}">{{$value->name}} ({{$currency_symbol}}{{$value->price}})</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="services_mobile_error"></div>
                                                        </div>
                                                        <div class="form-group">

                                                            <div class="output"></div>
                                                            <select data-placeholder="Choose Events" name="events[]" multiple class="chosen-select" required>
                                                                @if(isset($events) && $events != "")
                                                                    @foreach($events as $key=>$value)
                                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="output"></div>
                                                            <select data-placeholder="Choose Locations" name="location[]" multiple class="chosen-select" required>
                                                                @if(isset($locations) && $locations != "")
                                                                    @foreach($locations as $key=>$location)
                                                                        <option value="{{$location->id}}">{{$location->location_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea rows="6" name="service_description" placeholder="Service description"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <input id="remember" class="custom-checkbox" type="checkbox">
                                                            <label for="remember" class="custom-checkbox-label">I agree to Terms &amp; Conditions</label>
                                                        </div>
                                                        <div class="form-group text-center">
                                                            <button class="btn white-btn create-acc disabled" id="mobile_submit_supplier" disabled="disabled" type="submit" name="" > <span>CREATE ACCOUNT</span></button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
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
                            <li><a href="#" class="active">Become a Supplier</a></li>
                        </ul>
                    </div>
                </section>
                <section id="atveroeos">
                    <div class="container">
                        <div class="row">
                        	@if(isset($pagecontent))
                            <div class="col-sm-12 col-md-6">
                                <h2>{{$pagecontent->title}}</h2>
                                <p>@php echo $pagecontent->content; @endphp</p>
                            </div>
                            @endif
                            <div class="col-sm-6 col-md-6">
                                <div class="sidebar-block planning-block">
                                    <div class="title-block">
                                        <h2>Create an account</h2>
                                        <!-- <a href="javascript:void(0);" class="sidebar-drop-btn"><i class="far fa-chevron-up"></i></a> -->
                                    </div>
                                    <div class="planning-filter">
                                        <form method="POST" action="{{ route('BecomeSupplierSignup') }}" name="BecomeSupplierSignup" id="BecomeSupplierSignup">
                                             @csrf
                                        <div class="form-group">
                                            <input type="text" name="name" placeholder="Your name">
                                        </div>
                                        <div class="form-group">    
                                            <input type="text" name="business_name" placeholder="Your Business name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="email" class="BecomeSupplierEmail" placeholder="Your email address">
                                        </div>
                                        <div class="form-group">
                                            <input min="0" type="number" name="phone" placeholder="Your phone number">
                                        </div>
                                        <div class="form-group">
                                            <input class="BecomeSupplierPassword" type="password"  name="password" placeholder="Your Password" autocomplete="off">
                                         </div>
                                        <div class="form-group">
                                                    <input id="" type="password" name="password_confirmation" placeholder="Your Confirm Password" autocomplete="off">
                                        </div>
                                        <!-- <div class="form-group">
                                            <textarea rows="3" name="address" placeholder="Your full address"></textarea>
                                        </div> -->
                                        <div class="form-group">
                                            <div class="custom-select">
                                                <select class="services services_desktop" name="services">
                                                    <option value="">TYPE OF SERVICE</option>
                                                       @if(isset($services) && $services != "")
                                                        @foreach($services as $key=>$value)
                                                            <option value="{{$value->id}}">{{$value->name}} ({{$currency_symbol}}{{$value->price}})</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                              <div class="services_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="output"></div>
                                            <select data-placeholder="Choose Events" name="events[]" multiple class="chosen-select" required>
                                                @if(isset($events) && $events != "")
                                                    @foreach($events as $key=>$value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="output"></div>
                                            <select data-placeholder="Choose Locations" name="location[]" multiple class="chosen-select" required>
                                                @if(isset($locations) && $locations != "")
                                                    @foreach($locations as $key=>$location)
                                                        <option value="{{$location->id}}">{{$location->location_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea rows="6" name="service_description" placeholder="Service description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input id="remember2" name="remember2" class="remember-checkbox" type="checkbox">
                                            <label for="remember2" class="remember-label">I agree to Terms &amp; Conditions</label>
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn white-btn create-acc disabled" id="desk_submit_supplier" type="submit" name="" disabled="disabled"> <span>CREATE ACCOUNT</span></button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


               <!--  <section class="featured-vendors">
                    <div class="container">
                        <span class="sub-heading">Featured</span>
                        <h2>Vendors</h2>
                        <div class="vendor-slider">
                            <div class="vendor-item">
                                <div class="vendor-img">
                                    <img src="images/vendors/vendor-1.jpg">
                                </div>
                                <div class="company-desc">
                                    <div class="company-name">
                                        Name company
                                        <span>Sound</span>
                                    </div>
                                    <div class="vendor-detail">
                                        <p>
                                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis...
                                        </p>
                                        <a class="btn common-btn" href="#">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="vendor-item">
                                <div class="vendor-img">
                                    <img src="images/vendors/vendor-2.jpg">
                                </div>
                                <div class="company-desc">
                                    <div class="company-name">
                                        Name company
                                        <span>Sound</span>
                                    </div>
                                    <div class="vendor-detail">
                                        <p>
                                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis...
                                        </p>
                                        <a class="btn common-btn" href="#">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="vendor-item">
                                <div class="vendor-img">
                                    <img src="images/vendors/vendor-3.jpg">
                                </div>
                                <div class="company-desc">
                                    <div class="company-name">
                                        Name company
                                        <span>Sound</span>
                                    </div>
                                    <div class="vendor-detail">
                                        <p>
                                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis...
                                        </p>
                                        <a class="btn common-btn" href="#">read more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="vendor-item">
                                <div class="vendor-img">
                                    <img src="images/vendors/vendor-1.jpg">
                                </div>
                                <div class="company-desc">
                                    <div class="company-name">
                                        Name company
                                        <span>Sound</span>
                                    </div>
                                    <div class="vendor-detail">
                                        <p>
                                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis...
                                        </p>
                                        <a class="btn common-btn" href="#">read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
           
    @endsection
@section('page_plugin_script')
    <script type="text/javascript">
        $(document).ready(function () {
            document.getElementsByClassName('output').innerHTML = location.search;
            $(".chosen-select").chosen();
        });
        $(window).parallaxmouse({
            invert: true,
            range: 400,
            elms: [ {
                el: $('#become-supplier-layer-1'),
                rate: 0.2
            },
            {
                el: $('#become-supplier-layer-2'),
                rate: 0.2
            },{
                el: $('#become-supplier-layer-3'),
                rate: 0.2
            }]
        });
    </script>
@endsection