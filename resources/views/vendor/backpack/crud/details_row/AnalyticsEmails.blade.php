@extends(backpack_view('blank'))
@section('content')
<style type="text/css">
   .show{
   	display: block;
   }
   .hide{
   	display: none;
   }
   #analytics_email_form{
    background: #fff;
    padding: 20px;
   }
   #analytics_email_form select{
    width: 100%;
    padding: 8px 5px;
   }
   #analytics_email_form input[type=date] {
    padding: 5px 5px;
    width: 100%;
  }
   #content_result{
    background: #fff;
    padding: 15px;
  }
  .find-btn {
    line-height: normal;
    display: flex;
    justify-content: center;
    align-items: center;    
    margin: 20px auto 0;
}
  .find-btn i{
    font-size: 14px;
    padding-right: 8px;
  }
  #analytics_email_form .row > div{padding: 0 8px;}
.template_loader {
    position: absolute;
    top: 55%;
    height: 100px;
    width: 100px;
    background: transparent url(../public/images/ajax-loader.gif) no-repeat center center;
    left: 0;
    right: 0;
    z-index: 9999;
    margin: 50px auto 0;/*
    transform: translateY(-50%);*/
}
.email-loader {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    left: 0;
    right: 0;
    margin: 0 auto;
    text-align: center;
    z-index: 999;
    height: 100%;
    width: 100%;
}
.email-loader img {
position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 0;
    right: 0;
    margin: 0 auto;
    text-align: center;
    z-index: 9;
}
.email-loader:before {
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, .5);
    position: absolute;
    content: "";
    left: 0;
    right: 0;
}
.loader-height{height: 100%;}

#analytics_email_form input[type="date"]::-webkit-inner-spin-button, 
#analytics_email_form input[type="date"]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}

</style>
<main class="main pt-2">
  <div class="email-loader hide"><img src="{{asset('images/ajax-loader.gif')}}"></div>
   <section class="container-fluid">
      <h2>
         <span class="text-capitalize">Email Template</span>
      </h2>
   </section>
   <div class="container-fluid animated fadeIn">
      	<div class="row">
         	<div class="col-md-8">
         		<p> Find suppliers and analytics, Send template to searched suppliers.</p>
               <!-- <div>
                  <p>Send report for number of service in this location signed up to the service.</p>
                  <p>Send report for number of people who have searched for service in this area.</p>
                  <p>Send report for number of people who have contacted service in this area.</p>
                  <p>Send report for number of people who have booked service in this area.</p>
               </div> -->
              	<hr>
                <div class="row loader-height">
               	<div class="form-group col-sm-12">
	               <form method="post" id="analytics_email_form">
                  <div class="row">
                  <div class="col-md-3 col-sm-6">
                             @csrf
                   <label for="service">Select Service:</label>
                   <select name="service" id="service" required>
                      <option value="">Select Service</option>
                      @if(isset($services))
                          @foreach($services as $service)
                             <option value="{{$service->id}}">{{$service->name}}</option>
                          @endforeach
                      @endif
                   </select>
                  </div>
	        
            <div class="col-md-3 col-sm-6">
	                 <label for="location">Select Location:</label>
	                 <select name="location" id="location" required>
	                    <option value="">Select Location</option>
	                    @if(isset($locations))
	                        @foreach($locations as $location)
	                           <option value="{{$location->id}}">{{$location->location_name}}</option>
	                        @endforeach
	                    @endif
	                 </select>
                 </div>
	           
                    <div class="col-md-3 col-sm-6">
	                 <label>Select Start Date</label>
	                 <input type="date" id="start_date" name="start_date">
                 </div>
	           
                    <div class="col-md-3 col-sm-6">
	                 <label>Select End Date</label>
	                 <input type="date" id="end_date" name="end_date">
                 </div>
                       </div>
	                <!--  <input type="radio" id="report_type1" name="report_type" value="weekly">
	                 <label for="report_type1"> Last Week </label>
	                 <input type="radio" id="report_type2" name="report_type" value="monthly"> 
	                 <label for="report_type2"> Last Month </label> -->
	               
	                 <button type="button" class="find-btn btn btn-primary" id="send_mail"><i class="fas fa-search"></i>Find</button> 
             
	               	</form>
	               	<div class="template_loader hide"></div>
               		<div id="content_result" class="hide"></div>
           		</div>
            </div>
				<div class="form-group template_block hide">
					<hr>
					<form method="post" name="send_template_form" id="send_template_form">
						 @csrf
						<label>Email Template </label>
				   		<textarea class="ckeditor" cols="80" id="template" name="template" rows="10">
				   			This is default template.
				   		</textarea>
				   		<br>
				   		<input type="button" class="btn btn-success" id="send_mail_template" value="Send">
				   	</form>	
    			</div>
         	</div>
      	</div>
   </div>
</main>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="../packages/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('template');
</script>
<script type="text/javascript">

  $(document).ready(function(){
   $(document).on('click','#send_mail',function() {
      $(this).attr('disabled','disabled');
      $('.template_loader').show();
      var data = $('#analytics_email_form').serialize();
       $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url  : "{{route('SendReport')}}",
                data : data,
                success : function(data){
                	if(data.success == true){
                    if(data.count > 0){
                      $('.template_block').show();
                    }
                    $('#content_result').show();
                		$('#content_result').html(data.html);
                		
                	}
                  $('#send_mail').removeAttr('disabled');
                  $('.template_loader').hide();
                 // location.reload(true);
                }
            });
   });
   $(document).on('click','#send_mail_template',function() {
    $('.email-loader').show();
      var data = $('#send_template_form').serialize();
      var mailContents = CKEDITOR.instances['template'].getData(); 

       $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('send_template_form[name="csrf-token"]').attr('content')
                },
                url  : "{{route('SendTemplate')}}",
                data : { 'template' : CKEDITOR.instances['template'].getData() },
                success : function(data){
                	if(data.success == true){
                		location.reload(true);
                	}
                	else{
                		alert('Something went to wrong!');
                    $('.email-loader').hide();
                		return false;
                	}
                }
            });
   });
 });

</script>
