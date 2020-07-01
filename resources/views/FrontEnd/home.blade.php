@extends('layouts.master',['title' => 'Home'])
@section('content')

    <style>
        .content{
            position: relative;
        }
    </style>
    <div id="parallax">
        <img id="home-layer-1" class="parallax left"  data-depth="0.50" src="{{asset('images/layers/circle.svg')}}">
        <img id="home-layer-2"  class="parallax"   src="{{asset('images/layers/shape-1.svg')}}">
        <img id="home-layer-3" class="parallax" data-depth="0.25" src="{{asset('images/layers/shape-2.svg')}}">
        <img id="home-layer-4" class="parallax" data-depth="0.25" src="{{asset('images/layers/shape-4.svg')}}">
        <img id="home-layer-5" class="parallax " data-depth="0.20" src="{{asset('images/layers/shape-4.svg')}}">
        <img id="home-layer-6" class="parallax" data-depth="0.10" src="{{asset('images/layers/orange-circle.svg')}}">
        <img id="home-layer-7" class="parallax" data-depth="0.10" src="{{asset('images/layers/blue-circle.svg')}}">
        <img id="home-layer-8" class="parallax" data-depth="0.10" src="{{asset('images/layers/shape-5.svg')}}">
        <img id="home-layer-9" class="parallax" data-depth="0.10" src="{{asset('images/layers/shape-5.svg')}}">
        <img id="home-layer-10" class="parallax" data-depth="0.10" src="{{asset('images/layers/shape-5.svg')}}">
    </div>
    <section class="home-page-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="banner">
                       @if(isset($homebanner['image']))
                            <img src="{{ asset($homebanner['image']) }} ">
                        @else
                            <img src="{{ asset('images/banner.jpg') }}">
                        @endif
                    </div>
                    <div class="banner-text">
                        <h2 class="wow fadeInUp" data-wow-duration="1s"
                            data-wow-delay="0.5s">@if(isset($homebanner['content'])) {{ $homebanner['content'] }} @else
                                Optional Banner Text @endif </h2>
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
                </div>
            </div>
        </div>
    </section>
    <!-- <a href="#" OnClick='DoActionAnalytics(0,"","impressions","","Home","/home");'> Click </a> -->

    <section class="filter-search wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">
        <div class="container">
            <div class="filter_search">
                <div class="search-box">
                    <form id="filter-form" class="filter-form" action="{{route('OurSuppliers')}}" method="post">
                        @csrf
                       <!--  <div class="search-field-custom"><input type="text" name="service_name"
                                                                placeholder="TYPE OF EVENT (eg: wedding)"></div> -->

                        <div class="row">  
                      
                        <div class="col-md-10">                                   
                        <div class="row">   
                        <div class="col-md-4">                                   
                        <div class="search-field-custom custom-select">
                            <select class="events" name="event_name">
                                <option value="">EVENT TYPE (ex: wedding)</option>
                                @if(isset($events) && $events != "")
                                    @foreach($events as $key=>$event)
                                        <option value="{{$event->id}}">{{$event->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        </div> 
                        <div class="col-md-4"> 
                        <div class="search-field-custom custom-select">
                            <select class="events" name="service_name">
                                <option value="">SERVICE TYPE (ex: catering)</option>
                                @if(isset($services) && $services != "")
                                    @foreach($services as $key=>$service)
                                        <option value="{{$service->id}}">{{$service->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        </div> 
                        <!-- <div class="search-field-custom"><input type="text" name="event_name"
                                                                placeholder="TYPE OF SERVICE (eg: catering)"></div> -->
                        <div class="col-md-4"> 
                        <div class="search-field-custom custom-select">
                            <select class="location" name="location">
                                <option value="">SELECT LOCATION</option>
                                @if(isset($locations) && $locations != "")
                                    @foreach($locations as $key=>$location)
                                        <option value="{{$location->id}}">{{$location->location_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        </div> 
                        </div> 
                        </div> 
                        <div class="col-md-2"> 
                        <div class="search-field-custom filter-btn">
                            <button class="btn white-btn filter-search-btn" type="submit"><i class="fas fa-search"></i>
                                <span>SEARCH</span></button>
                        </div>
                        </div> 

                        </div>  
                    </form>

                </div>
            </div>
        </div>
    </section>
    <section class="category-item">
        <div class="container">
            <ul class="category-slider wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.5s">
                @if(isset($services))
                    @foreach($services as $servicesdata)
                        <a  href="{{ route('OurSuppliersCat',['slug' => $servicesdata['slug']])}}">
                        <li class="cat-logo">
                            <div class="cat-img">
                                @if(isset($servicesdata['image']))
                                    <img class="svg" src="{{ asset($servicesdata['image']) }} ">
                                @else
                                    <img class="svg" src="{{ asset('images/category-img/cat-1.png') }}">
                                @endif
                                    @if(isset($servicesdata['image_hover']))
                                        <img class="img-top" src="{{ asset($servicesdata['image_hover']) }} ">
                                    @else
                                        <img class="img-top" src="{{ asset('images/category-img/djs.png') }}">
                                    @endif
                            </div>
                            <span class="cat-name">{{$servicesdata['name']}}</span>
                        </li>
                        </a>
                    @endforeach
                @endif
            </ul>
            <div class="col-12 text-center">
                <a class="btn common-btn" href="{{ route('BrowseSuppliers')}}">see all</a>
            </div>

        </div>
    </section>

    <section class="how-does-it-work">
        <div class="container">
            <div class="title-text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.5s">
                <span class="sub-heading">How does</span>
                <h2>It Work?</h2>
            </div>
            <div class="work-block">
                <div class="row">
                    @if(isset($howitworks))
                        @foreach($howitworks as $howitworksdata)
                            <div class="col-md-12 col-sm-12">
                                <div class="how-work-items wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.5s">
                                    <div class="work-img">
                                        @if(isset($howitworksdata['image']))
                                            <img src="{{ asset($howitworksdata['image']) }} ">
                                        @else
                                            <img src="{{ asset('images/work-1.png') }}">
                                        @endif
                                    </div>
                                    <p><span class="no">{{$howitworksdata['step_number']}}<span>.</span></span>
                                        @if(isset($howitworksdata['content'])){{ $howitworksdata['content'] }} @else Sed
                                        ut perspiciatis unde omnis iste natus error sit oluptatem accusantium doloremque
                                        laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et
                                        quasi architecto. @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="client-say">
        <div class="container">
            <div class="title-text wow fadeInUp" data-wow-duration="0.10s" data-wow-delay="0.8s">
                <span class="sub-heading">What our</span>
                <h2>Clients say</h2>
            </div>
            @php
                $i = 0.10;
            @endphp
            <div class="client-slider">
                @if(isset($testimonials))
                    @foreach($testimonials as $testimonialsdata)
                        <div class="client-item wow fadeInUp" data-wow-duration="{{$i}}s" data-wow-delay="0.1s">
                            <div class="details">
                                <div class="quote">
                                    <img id="quotes" class="left top" src="images/client-quotes.png">
                                </div>
                                <p>
                                    @php

                                        if(strlen($testimonialsdata['content_review_message']) > 130){
                                            $testimonials = trim($testimonialsdata['content_review_message'],' ');
                                            $pos=strpos($testimonials, " ", 125);
                                            echo substr($testimonials,0,$pos );
                                        }else{

                                            echo $testimonialsdata['content_review_message'];
                                        }
                                    @endphp
                                </p>
                            </div>
                            <div class="client-info">
                                <p>{{$testimonialsdata['client_name']}}</p>
                            </div>
                        </div>
                        @php
                            $i += 1;
                        @endphp
                    @endforeach
                @endif
            </div>

        </div>

    </section>

    <section class="the-benefits">
        <div class="container">
            <div class="title-text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.5s">
                <span class="sub-heading">The</span>
                <h2>Benefits</h2>
            </div>
            <div class="row no-gutters wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.8s">

                @if(isset($benefits))
                    @foreach($benefits as $benefitsdata)
                        <div class="col-md-3 col-sm-6 benifit-item">
                            <div class="benifit-img">
                                @if(isset($benefitsdata['banner_image']))
                                    <img src="{{ asset($benefitsdata['banner_image']) }} ">
                                @else
                                    <img src="{{ asset('images/benefits/benefit-1.jpg') }}">
                                @endif
                            </div>
                            <div class="benifit-description">
                                <h4>{{$benefitsdata['title']}}</h4>
                                <p>
                                    @php
                                    	echo $benefitsdata['quote'];
                                    @endphp
                                </p>
                            </div>
                        </div>

                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section class="featured-vendors">
        <div class="container">
            <div class="title-text wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <span class="sub-heading">Featured</span>
                <h2>Vendors</h2>
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
                                            $vendors = trim($featuredvendorsdata['service_description'],' ');
                                            $pos=strpos($vendors, " ", 120);
                                            echo substr($vendors,0,$pos );
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
    </section>
@endsection

@section('page_plugin_script')
    <script type="text/javascript">
        $(window).parallaxmouse({
            invert: true,
            range: 400,
            elms: [{
                el: $('#home-layer-1'),
                rate: 0.2
            }, {
                el: $('#home-layer-2'),
                rate: 0.4
            }, {
                el: $('#home-layer-3'),
                rate: 0.6
            },
            {
                el: $('#home-layer-4'),
                rate: 0.2
            },
            {
                el: $('#home-layer-5'),
                rate: 0.4
            },
            {
                el: $('#home-layer-6'),
                rate: 0.6
            },
            {
                el: $('#home-layer-7'),
                rate: 0.6
            },
            {
                el: $('#home-layer-8'),
                rate: 0.6
            },
            {
                el: $('#home-layer-9'),
                rate: 0.6
            },
            {
                el: $('#home-layer-10'),
                rate: 0.6
            },
            ]
        });
    </script>
@endsection