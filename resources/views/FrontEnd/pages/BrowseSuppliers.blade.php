@extends('layouts.master',['title' => 'Browse Suppliers'])
    @section('content')
    <div id="parallax">
        <img id="browse-layer-1" class="parallax left"  data-depth="0.50" src="{{asset('images/layers/circle.svg')}}">
    </div>

     <section class="home-page-banner">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="banner">
                                    @if(isset($supplierstbanner['image']))
                                        <img src="{{ asset($supplierstbanner['image']) }} ">
                                    @else
                                        <img src="{{ asset('images/banner.jpg') }}">
                                    @endif
                                </div>
                                <div class="banner-text">
                                    <h2 class="">@if(isset($supplierstbanner['content'])) {{ $supplierstbanner['content'] }} @else
                                Browse our Supplierst @endif </h2>
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
                <section class="breadcrumb-block">
                    <div class="container">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="#" class="active">OUR SUPPLIERS</a></li>
                        </ul>
                    </div>
                </section>
                <section class="category-section">
                    <div class="container">
                        <ul class="category-list">
                            @if(isset($services))
                                @foreach($services as $servicesdata)
                                    <li @if(isset($eventscatName)) @if($eventscatName == $servicesdata['slug']) class="active" @endif @endif>
                                        <a href="{{ route('OurSuppliersCat',['slug' => $servicesdata['slug']])}}">
                                        <div class="category-block">
                                           <div class="category-icon">
                                                @if(isset($servicesdata['image']))
                                                    <img class="svg" src="{{ asset($servicesdata['image']) }} ">
                                                @else
                                                    <img class="svg" src="{{ asset('images/category-img/djs.png') }}">
                                                @endif
                                                    @if(isset($servicesdata['image_hover']))
                                                        <img class="img-top" src="{{ asset($servicesdata['image_hover']) }} ">
                                                    @else
                                                        <img class="img-top" src="{{ asset('images/category-img/djs.png') }}">
                                                    @endif

                                            </div>
                                            <span class="category-name">{{ $servicesdata['name'] }}</span> 
                                        </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                    </div>
                </section>
                <section class="category-list-section">
                    <div class="container">
                        <div class="row">
                            <div class="category-list-block">
                                @if(isset($services_up))
                                <ul class="category-list-nav">
                                    @foreach($services_up as $services_updata)
                                    <li><a href="{{ route('OurSuppliersCat',['slug' => $servicesdata['slug']])}}" class="category-name"> {{ $services_updata['name'] }}</a></li>
                                     @endforeach
                            
                                   <!--  <li><a href="javascript:void(0)">Venues</a></li>
                                    <li><a href="javascript:void(0)">Bakeries</a></li>
                                    <li><a href="javascript:void(0)">Marquee Hire</a></li>
                                    <li><a href="javascript:void(0)">Transport</a></li> -->
                                </ul>
                                @endif
                            </div>
                            <!-- <div class="category-list-block">
                                <ul class="category-list-nav">
                                    <li><a href="javascript:void(0)">CATERING</a></li>
                                    <li><a href="javascript:void(0)">BAR SERVICE</a></li>
                                    <li><a href="javascript:void(0)">PHOTOGRAPHY</a></li>
                                    <li><a href="javascript:void(0)">CONFERENCE</a></li>
                                    <li><a href="javascript:void(0)">LIVE BANDS</a></li>
                                </ul>
                            </div>
                            <div class="category-list-block">
                                <ul class="category-list-nav">
                                    <li><a href="javascript:void(0)">DJ’S </a></li>
                                    <li><a href="javascript:void(0)">VENUES</a></li>
                                    <li><a href="javascript:void(0)"></a><a href="javascript:void(0)">BAKERIES</a></li>
                                    <li><a href="javascript:void(0)"></a><a href="javascript:void(0)">MARQUEE HIRE</a></li>
                                    <li><a href="javascript:void(0)"></a><a href="javascript:void(0)">TRANSPORT</a></li>
                                </ul>
                            </div>
                            <div class="category-list-block">
                                <ul class="category-list-nav">
                                    <li><a href="javascript:void(0)"></a><a href="javascript:void(0)">CATERING</a></li>
                                    <li><a href="javascript:void(0)">BAR SERVICE</a></li>
                                    <li><a href="javascript:void(0)">PHOTOGRAPHY</a></li>
                                    <li><a href="javascript:void(0)">CONFERENCE</a></li>
                                    <li><a href="javascript:void(0)">LIVE BANDS</a></li>
                                </ul>
                            </div>
                            <div class="category-list-block">
                                <ul class="category-list-nav">
                                    <li><a href="javascript:void(0)">DJ’S </a></li>
                                    <li><a href="javascript:void(0)">VENUES</a></li>
                                    <li><a href="javascript:void(0)">BAKERIES</a></li>
                                    <li><a href="javascript:void(0)">MARQUEE HIRE</a></li>
                                    <li><a href="javascript:void(0)">TRANSPORT</a></li>
                                </ul>
                            </div>
                            <div class="category-list-block">
                                <ul class="category-list-nav">
                                    <li><a href="javascript:void(0)">CATERING</a></li>
                                    <li><a href="javascript:void(0)">BAR SERVICE</a></li>
                                    <li><a href="javascript:void(0)">PHOTOGRAPHY</a></li>
                                    <li><a href="javascript:void(0)">CONFERENCE</a></li>
                                    <li><a href="javascript:void(0)">LIVE BANDS</a></li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </section>
                <section class="featured-vendors">
                <div id="parallax">
                    <img id="browse-layer-2"  class="parallax" src="{{asset('images/layers/shape-5.svg')}}">
                    <img id="browse-layer-3" class="parallax" data-depth="0.25" src="{{asset('images/layers/shape-5.svg')}}">
                    <img id="browse-layer-4" class="parallax" src="{{asset('images/layers/shape-5.svg')}}">
                </div>
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
                el: $('#browse-layer-1'),
                rate: 0.2
            }, {
                el: $('#browse-layer-2'),
                rate: 0.4
            }, {
                el: $('#browse-layer-3'),
                rate: 0.6
            },{
                el: $('#browse-layer-4'),
                rate: 0.6
            },
            ]
        });
    </script>
@endsection
         

  