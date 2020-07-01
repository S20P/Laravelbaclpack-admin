@extends('layouts.master',['title' => 'Our Story'])
    @section('content')
        <div id="parallax">
            <img id="our-story-layer-1"   class="parallax" src="{{asset('images/layers/svg_round-small.svg')}}">
            <img id="our-story-layer-2"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="our-story-layer-3"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="our-story-layer-4"   class="parallax" src="{{asset('images/layers/orange-circle.svg')}}">
            <img id="our-story-layer-5"   class="parallax" src="{{asset('images/layers/shape-4.svg')}}">
            <img id="our-story-layer-6"   class="parallax" src="{{asset('images/layers/shape-4.svg')}}">
            <img id="our-story-layer-7"   class="parallax" src="{{asset('images/layers/blue-circle.svg')}}">
            <img id="our-story-layer-8"  class="parallax" src="{{asset('images/layers/shape-5.svg')}}">
        </div>
            <section class="home-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="banner">

                    @if(isset($ourstorybanner['image']))
                        <img src="{{ asset($ourstorybanner['image']) }} ">
                    @else
                        <img src="<img src="{{ asset('images/our-story.jpg') }}">
                    @endif
                </div>
                <div class="banner-text">
                    <h2 class="">{{$ourstorybanner['content']}}</h2>
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
                    <li><a href="#" class="active">OUR STORY</a></li>
                </ul>
            </div>
        </section>
@if(isset($our_story))
<section class="our-story">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="sub-heading">{{$our_story['section1_subtitle']}}</div>
                <h2 class="gradient-pink-text">{{$our_story['section1_title']}}</h2>
            </div>
            <div class="col-md-7">
                <div class="story-desc">
                <h3 class="story-title">{{$our_story['section1_description_title']}}</h3>
                <p>{{$our_story['section1_description']}}</p>
            </div>

            </div>
        </div>
    </div>
</section>
@endif
    @if(isset($gallery))
    <section class="our-gallery">
        <div class="gallery-gradient-block" style="background: linear-gradient(to right, {{$our_story['color1']}} 0%, {{$our_story['color2']}} 50%, {{$our_story['color3']}} 100%);"></div>
        <div class="container">
            <div class="sub-heading">Our</div>
            <h2>Gallery</h2>
                <ul class="gallery-slider">
                    @foreach($gallery['image'] as  $gallerydata)
                        {{$gallerydata}}
                    <li>
                        @if(isset($gallerydata))
                            <img src="{{ asset($gallerydata) }} ">
                        @else
                            <img src="{{asset('images/gallery/gallery-1.jpg')}}" alt="">
                        @endif

                    </li>
                    @endforeach
                </ul>
        </div>
        
    </section>
    @endif
    @if(isset($our_story))
<section class="our-story-2">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="sub-heading">{{$our_story['section2_subtitle']}}</div>
                <h2 class="gradient-orange-text">{{$our_story['section2_tile']}}</h2>
            </div>
            <div class="col-md-7">
                <div class="story-desc">
                <h3 class="story-title">{{$our_story['section2_description_title']}}</h3>
                <p>{{$our_story['section2_description']}}</p>
            </div>

            </div>
        </div>
    </div>
</section>
@endif
<section class="the-benefits">
    <div class="container">
        <span class="sub-heading">The</span>
        <h2>Benefits</h2>
        <div class="row no-gutters">
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
    @if(isset($our_story))
<section class="our-story-3">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="sub-heading">{{$our_story['section3_subtitle']}}</div>
                <h2 class="gradient-blue-text">{{$our_story['section3_title']}}</h2>
            </div>
            <div class="col-md-7">
                <div class="story-desc">
                <h3 class="story-title">{{$our_story['section3_description_title']}}</h3>
                <p>{{$our_story['section3_description']}}</p>
            </div>

            </div>
        </div>
    </div>
</section>
@endif

    @endsection
@section('page_plugin_script')
    <script type="text/javascript">
        $(window).parallaxmouse({
            invert: true,
            range: 400,
            elms: [ {
                el: $('#our-story-layer-1'),
                rate: 0.4
            },
                {
                    el: $('#our-story-layer-2'),
                    rate: 0.2
                },
                {
                    el: $('#our-story-layer-3'),
                    rate: 0.2
                },
                {
                    el: $('#our-story-layer-4'),
                    rate: 0.2
                },
                {
                    el: $('#our-story-layer-5'),
                    rate: 0.2
                },
                {
                    el: $('#our-story-layer-6'),
                   rate: 0.2
                },
                {
                    el: $('#our-story-layer-7'),
                    rate: 0.2
                },{
                    el: $('#our-story-layer-8'),
                    rate: 0.2
                }

            ]
        });
    </script>
@endsection