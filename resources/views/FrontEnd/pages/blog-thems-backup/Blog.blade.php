@extends('layouts.master',['title' => 'Blog'])
    @section('content')




		<div id="parallax">
			<img id="blog-layer-1"  class="parallax" src="{{asset('images/layers/shape-2.svg')}}">
			<img id="blog-layer-2"  class="parallax" src="{{asset('images/layers/shape-2.svg')}}">

		 </div>
	<section class="home-page-banner">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="banner">
									@if(isset($blogbanner['image']))
										<img src="{{ asset($blogbanner['image']) }} ">
									@else
										<img src="<img src="{{ asset('images/blog-bg.jpg') }}">
									@endif
								</div>
								<div class="banner-text">
									<h2 class="">Blog</h2>
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
							<li><a href="#" class="active">BLOG</a></li>
						</ul>
					</div>
				</section>
				<section id="blog-section">
					<div id="parallax">
						<img id="blog-layer-3"  class="parallax left" src="{{asset('images/layers/circle.svg')}}">
					</div> 

	 <div class="container">
        <div class="row">
		<div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div align="center">
            <button class="btn black-btn  filter-button" data-filter="all">
			<span class="title">All</span>	
			</button>
            <button class="btn black-btn filter-button" data-filter="most_recent">
			<span class="title">Most Recent</span>	
			</button>
			<button class="btn black-btn filter-button" data-filter="oldest">
			<span class="title">Oldest</span>	
			</button>
        </div>
        </div>
			@if(isset($blogs) && count($blogs) > 0)
						<ul class="blog-listing">
							@foreach($blogs as $blogdetails)
							<li class="filter {{$blogdetails['filter_by']}}">
								<div class="blog-item">
									<div class="blog-img">
										@if(isset($blogdetails['banner_image']))
											<img src="{{ asset($blogdetails['banner_image']) }} ">
										@else
											<img src="<img src="{{ asset('images/blog/blog-1.jpg') }}">
										@endif
									</div>
									<div class="blog-description">
										<h5>{{$blogdetails['title']}}</h5>
										<div class="blog-date">
											@php
												$blogid = base64_encode($blogdetails['blog_id']);
												$date=date_create($blogdetails['date']);
												echo $date =  date_format($date,"d/m/Y");
											@endphp
										</div>
										<p>
											  @php
                                                    if(strlen($blogdetails['quote']) > 150){
                                                        $blog_str = trim($blogdetails['quote'],' ');
                                                        $pos=strpos($blog_str, " ", 150);
                                                        echo substr($blog_str,0,$pos );
                                                    }else{

                                                        echo $blogdetails['quote'];
                                                    }
                                                @endphp
										</p>
										<a class="btn common-btn" href="{{ route('ArticleBlogPage',['slug' =>  $blogid])}}" tabindex="0">read more</a>
									</div>
								</div>
							</li>
							@endforeach
						</ul>
						@else
							<div class="row">
								<div class="col-12">
									<div class="alert-warning alerting" role="alert">
										No Blogs Available...
									</div>
								</div>
							</div>
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
				el: $('#blog-layer-1'),
				rate: 0.4
			},
			{
				el: $('#blog-layer-2'),
				rate: 0.4
			},
			{
				el: $('#blog-layer-3'),
				rate: 0.4
			},

			]
		});
	</script>   


<script>
$(document).ready(function(){

$(".filter-button").click(function(){
	var value = $(this).attr('data-filter');
	
	if(value == "all")
	{
		//$('.filter').removeClass('hidden');
		$('.filter').show('1000');
	}
	else
	{
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
		$(".filter").not('.'+value).hide('3000');
		$('.filter').filter('.'+value).show('3000');
		
	}
});

if ($(".filter-button").removeClass("active")) {
$(this).removeClass("active");
}
$(this).addClass("active");

});

</script>
	
	 @endsection