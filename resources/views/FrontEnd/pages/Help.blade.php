@extends('layouts.master',['title' => 'Help'])
    @section('content')
		<div id="parallax">
			<img id="help-layer-1" class="parallax"   src="{{asset('images/layers/circle.svg')}}">
		</div>
    <section class="home-page-banner">
					<div class="container">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="banner">
									@if(isset($helpsbanner['image']))
										<img src="{{ asset($helpsbanner['image']) }} ">
									@else
										<img src="{{ asset('images/help-bg.jpg') }}">
									@endif
								</div>
								<div class="banner-text">
									<h2 class="">Help</h2>
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
							<li><a href="#" class="active">Help</a></li>
						</ul>
					</div>
				</section>
				<section>
					<div class="container">
						<div class="row">
							<div class="col-sm-12 col-md-12 help-block">
								@if(isset($pagecontent))
									<div class="d-none d-md-block help-title text-center">
									<h2>{{$pagecontent->title}}</h2>
									<p>@php echo $pagecontent->content;  @endphp</p>
									</div>
								@endif
								 <form method="post" action="{{route('Help')}}"> 
									@csrf
									<div class="gradiant-block search-block">
									<input  id="search" type="text" @if(isset($filter)) value="{{$filter}}"  @endif  name="search_keyword" placeholder="WHAT CAN WE HELP YOU WITH?">
									<button class="btn white-btn filter-search-btn"  type="submit"><i class="fas fa-search"></i>
                                		<span>SEARCH</span>
                                	</button>
									</div>
								 </form> 

                                
<div class="list-accordion-section-neww">
</div>

				<!-- <div class="list-accordion-section-neww">
									@if(isset($helps) && count($helps) > 0)
										@foreach($helps as $hdepsdetails)
									<div class="list-accordion">
										<div class="list-title">
											<h5>{{$hdepsdetails['question']}}</h5>
											<span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
										</div>
										<div class="list-accordion-content">
											<div class="list-accordion-content-box"><p>{{$hdepsdetails['answers']}}</p>
										</div>
									</div>
								</div>
								@endforeach
								@else
								<div class="row" id="">
											<div class="col-12">
												<div class="alert-warning alerting" role="alert">
													No Helps Available...
												</div>
											</div>
								</div>
								@endif

							</div>   -->


						</div>
<!-- 						<div class="col-sm-4 col-md-4">
							<div class="sidebar-block planning-block">
								<div class="title-block">
									<h2>Chat with us!</h2>
									<a href="#" data-api="smartsupp" data-operation="send" id="chat_box" class="sidebar-drop-btn"><i class="far fa-chevron-down"></i></a> 
								</div>
							</div>
						</div> -->
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
			el: $('#help-layer-1'),
			rate: 0.2
		}]
	});
</script>

<script type="text/javascript">
	/* Simple Accordion 2 */
    function make_accordian(){
    	$('.list-title').click(function () {
	    	console.log("HI1");
	        var This = $(this);
	        $('.list-accordion').removeClass('open-accordion');
	        $('.list-accordion-content').slideUp();
	        MyAccordions(This);
	    });
    }

	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

serachHelp("");
$('#search').on('keyup',function(){
$value=$(this).val();
   serachHelp($value);
});


function serachHelp($value) {
	console.log("Seraching...help");


$.ajax({
type : 'get',
url : "{{route('HelpsAjex')}}",
data:{'search_keyword':$value},
success:function(data){
$('.list-accordion-section-neww').html(data);
make_accordian();
}
});
}


</script>

<script>
 /* Accordions */
    function MyAccordions(This) {
        if ($(This).next().is(":visible")) {
            $(This).parent().removeClass('open-accordion');
            $(This).next().slideUp();
        } else {
            $(This).parent().addClass('open-accordion');
            $(This).next().slideDown();
        }
    }

    $(document).ready(function(){
    	// make_accordian();
    });


    $('#help-list .list-title').click(function () {
    	console.log("HI2");
        var This = $(this);
        $('#help-list .list-accordion').removeClass('open-accordion');
        $('#help-list .list-accordion-content').slideUp();
        MyAccordions(This);
    });
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);

</script>


@endsection
