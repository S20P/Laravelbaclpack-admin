@extends('layouts.master',['title' => 'Contact Us'])
    @section('content')

				<section class="home-page-banner">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="banner">
                                    @if(isset($contactbanner['image']))
                                        <img src="{{ asset($contactbanner['image']) }} ">
                                    @else
                                        <img src="{{ asset('images/faq-bg.jpg') }}">
                                    @endif
								</div>
								<div class="banner-text">
									<h2 class="">{{$contactbanner['content']}}</h2>
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
							<li><a href="#" class="active">Contact Us</a></li>
						</ul>
					</div>
				</section>


				<section id="contact-section">
					 <div class="container">
             
                <!-- form -->
                <div class="row justify-content-center">
                    <div class="col-lg-8 m-15px-tb">
                        <div class="sidebar-block">
                            <div class="contact_succcess"></div>
                            <h3 class="dark-color white-text">Contact Us</h3>
                            <form id="contact_form" method="post" name="contact_form" >
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="name" id="name_contact" placeholder="Name *" type="text">
                                            <span class="input-focus-effect theme-bg"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="email" id="email_contact" placeholder="Email *" type="email">
                                            <span class="input-focus-effect theme-bg"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input name="subject" id="subject_contact" placeholder="Subject *" type="text">
                                            <span class="input-focus-effect theme-bg"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" id="message_contact" placeholder="Your message *" rows="3"></textarea>
                                            <span class="input-focus-effect theme-bg"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="send text-center">
                                            <button type="submit" class="btn white-btn" id="btn_send_contact" value="Send"><span>send message</span></button>
                                        </div>
                                        <span id="suce_message" class="text-success" style="display: none">Message Sent Successfully</span>
                                        <span id="err_message" class="text-danger" style="display: none">Message Sending Failed</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- col -->
                    @php
                        $footers_data = getFooterDetails();
                    @endphp
                    <div class="col-lg-4 m-15px-tb col-sm-6 location-box">
                        <div class="contact-info media box-shadow">
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="dark-color font-alt">Our Address</h6>
                                <p>{{$footers_data->address}}</p>
                            </div>
                        </div>
                        <div class="contact-info media box-shadow">
                            <div class="icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="dark-color font-alt">Our Phone</h6>
                                <a href="tel:{{$footers_data->contact_number}}" target="_top">+{{$footers_data->contact_number}}</a>
                            </div>
                        </div>
                        <div class="contact-info media box-shadow">
                            <div class="icon">
                                <i class="fas fa-envelope-open"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="dark-color font-alt">Our Email</h6>
                                <a href="mailto:{{$footers_data->contact_email}}" target="_top">{{$footers_data->contact_email}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end form -->
            </div>

        <div id="parallax">
            <img id="contact-us-layer-1"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="contact-us-layer-2"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
            <img id="contact-us-layer-3"   class="parallax" src="{{asset('images/layers/circle.svg')}}">
        </div>

			</section>
			
	
    @endsection
@section('page_plugin_script')
<script type="text/javascript">
    $(window).parallaxmouse({
        invert: true,
        range: 400,
        elms: [ {
            el: $('#contact-us-layer-1'),
            rate: 0.4
        },
        {
            el: $('#contact-us-layer-2'),
            rate: 0.4
        },
        {
            el: $('#contact-us-layer-3'),
            rate: 0.2
        },
        ]
    });
</script>
@endsection