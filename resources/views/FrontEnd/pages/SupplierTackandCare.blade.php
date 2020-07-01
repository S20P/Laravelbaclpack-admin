@extends('layouts.master',['title' => "Suppliers T&C’s"])
    @section('content')
        <div id="parallax">
            <img id="supplier-take-care-layer-1"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="supplier-take-care-layer-2"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="supplier-take-care-layer-3"   class="parallax" src="{{asset('images/layers/circle.svg')}}">
        </div>
    <section class="home-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="banner">
                    @if(isset($takeandcarebanner['image']))
                        <img src="{{ asset($takeandcarebanner['image']) }} ">
                    @else
                        <img src="{{ asset('images/supplier.jpg') }}">
                    @endif
                </div>
                <div class="banner-text">
                    <h2 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.5s">{{$takeandcarebanner['content']}}</h2>
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
                        <li><a  class="active">SUPPLIERS T&C’S</a></li>
                    </ul>
                </div>
        </section>
        <section class="supplier-block">
            <div class="container">
                <div class="row">
                    @if(isset($pagecontent))
                        @php
                             echo $pagecontent['content'];
                        @endphp
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
        elms: [ {
            el: $('#supplier-take-care-layer-1'),
            rate: 0.4
        },
        {
            el: $('#supplier-take-care-layer-2'),
            rate: 0.4
        },
        {
            el: $('#supplier-take-care-layer-3'),
            rate: 0.2
        },
        ]
    });
</script>
@endsection