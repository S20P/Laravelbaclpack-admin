@extends('layouts.master',['title' => "Faq's"])
    @section('content')
		<div id="parallax">
			<img id="supplier-faq-layer-1"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
			<img id="supplier-faq-layer-2"   class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
			<!-- <img id="supplier-faq-layer-3"   class="parallax" src="{{asset('images/layers/circle.svg')}}"> -->
		</div>
				<section class="home-page-banner">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="banner">
									@if(isset($faqabanner['image']))
										<img src="{{ asset($faqabanner['image']) }} ">
									@else
										<img src="{{ asset('images/faq-bg.jpg') }}">
									@endif
								</div>
								<div class="banner-text">
									<h2 class="">{{$faqabanner['content']}}</h2>
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
							<li><a href="#" class="active">FAQ’S</a></li>
						</ul>
					</div>
				</section>
				<section id="faq-section">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 col-md-12">
								@if(isset($pagecontent))
								<div class="faq-title">
									<div  class="text-center">
										<h2>{{$pagecontent->title}}</h2>
									<div>
									<p>@php echo $pagecontent->content;  @endphp</p>
								</div>
								@endif
							</div>
						</div>
						<form method="post" action="{{route('Faq')}}">
							@csrf
							<div class="gradiant-block search-block">

									<input @if(isset($filter)) value="{{$filter}}"  @endif type="text" name="search_keyword" placeholder="WHAT CAN WE HELP YOU WITH?">
									<button class="btn white-btn filter-search-btn" type="submit"><i class="fas fa-search"></i>
                        <span>SEARCH</span></button>

							</div>
						</form>
								@if(isset($faqs) && count($faqs) > 0)
									@foreach($faqs as $faqsdetails)
									<div class="list-accordion-section-neww">
										<div class="list-accordion">
											<div class="list-title">
												<h5>{{$faqsdetails['question']}}</h5>
												<span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
											</div>
											<div class="list-accordion-content">
												<div class="list-accordion-content-box"><p>{{$faqsdetails['answers']}}</p>
											</div>
										</div>
									</div>
										@endforeach
										@else
											<div class="row">
												<div class="col-12">
													<div class="alert-warning alerting" role="alert">
														No Faqs Available...
													</div>
												</div>
											</div>
								@endif
							</div>
						</div>
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
				el: $('#supplier-faq-layer-1'),
				rate: 0.2
			},
			{
				el: $('#supplier-faq-layer-2'),
				rate: 0.2
			},
			// {
			// 	el: $('#supplier-faq-layer-3'),
			// 	rate: 0.2
			// },
			]
		});
	</script>
@endsection