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
				<section id="blog-search-section">
					<div class="container">
						<form method="post" action="{{route('Blog')}}">
							@csrf
						<div class="gradiant-block search-block ">
								<input  type="text" name="search_key" @if(isset($filter['search_key'])) value="{{$filter['search_key']}}"  @endif placeholder="KEY WORDS">
								<div class="search-field-custom custom-select">
								<select name="blog_filter_by" >
									<option value="all">FILTER BY</option>
									<option  @if(isset($filter['blog_filter_by'])) @if($filter['blog_filter_by'] == 'all') selected="selected"  @endif @endif value="all" value="all">All</option>
									<option @if(isset($filter['blog_filter_by'])) @if($filter['blog_filter_by'] == 'most_recent') selected="selected"  @endif @endif value="most_recent">Most Recent</option>
									<option @if(isset($filter['blog_filter_by'])) @if($filter['blog_filter_by'] == 'oldest') selected="selected"  @endif @endif value="oldest">Oldest</option>
								</select>
							</div>
								<button class="btn white-btn filter-search-btn" type="submit"><i class="fas fa-search"></i>
                                <span>SEARCH</span></button>
						</div>
						</form>
					</div>
				</section>
				<section id="blog-section">
					<div id="parallax">
						<img id="blog-layer-3"  class="parallax left" src="{{asset('images/layers/circle.svg')}}">
					</div>
					<div class="container">
						@if(isset($blogs) && count($blogs) > 0)
						<ul class="blog-listing">
							@foreach($blogs as $blogdetails)
							<li>
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

						<div class="blog-pagination">
							{{ $blogs->links() }}

						</div>
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
	</script>    @endsection