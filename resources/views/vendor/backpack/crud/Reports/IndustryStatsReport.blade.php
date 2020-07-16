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
    background: transparent url({{url('images/ajax-loader.gif')}}) no-repeat center center;
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

.error{
  color: red;
}

</style>

<main class="main pt-2">
   <nav aria-label="breadcrumb" class="d-none d-lg-block">
      <ol class="breadcrumb bg-transparent justify-content-end p-0">
         <li class="breadcrumb-item text-capitalize">
<a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a>
         </li>
         <li class="breadcrumb-item text-capitalize">
           <a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a>
         </li>
         <li class="breadcrumb-item text-capitalize active" aria-current="page">Preview</li>
      </ol>
   </nav>
   <section class="container-fluid">
      <h2>
         <span class="text-capitalize">{{ $crud->entity_name }}</span>
        
        
      </h2>
   </section>
   <div class="container-fluid animated fadeIn">
      <div class="row">
         <div class="col-md-10">
                      
          <p></p>
            
               <hr>
                <div class="row loader-height">
                  <div class="form-group col-sm-12">
                  <form method="post" id="analytics_email_form">
                  
 <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                   <label for="report_type" class="report_type_error">Select Reports Type:</label>
                   <select name="report_type" id="report_type" required>
                      <option value="">Select Reports Type</option>
                     
                       <option value="reportQ1">1. How many of a supplier type on PP</option>
                       <option value="reportQ2">2. How many people viewed a supplier type</option>
                       <option value="reportQ3">3. How many people contacted a supplier type
</option>
                       <option value="reportQ4">4. How many people booked a supplier type
</option>

                       
                   </select>
</div>
                  </div>
              
                  <div class="col-md-6 col-sm-6">
                         <div class="form-group">
                   <label for="report_by">Report by</label>
                   <select name="report_by" id="report_by" required>
                      <option value="">Select Report by</option>
                      <option value="price">Price</option>
                      <option value="location">Location</option>
                   </select>
</div>
                  </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                    <label>Select Start Date</label>
                    <input type="date" id="start_date" name="start_date">
                 </div>
              </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                    <label>Select End Date</label>
                    <input type="date" id="end_date" name="end_date">
                 </div>
                 </div>
                       </div>
                 
                    <button type="button" class="find-btn btn btn-primary" id="generate_report"><i class="fas fa-search"></i>Find</button> 
             
                     </form>
                     <div class="template_loader hide"></div>
                     <div id="content_result" class="hide"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script type="text/javascript">

  $(document).ready(function(){

   $(document).on('click','#generate_report',function() {
      

      var report_type= $("#report_type").val();
      var error_status = true;
      if(report_type==null){
error_status = false;
$("#report_type_error").addClass("error");

      }
if(error_status){
$('#generate_report').attr('disabled','disabled');
$("#report_type_error").removeClass("error");


      $('.template_loader').show();
      var data = $('#analytics_email_form').serialize();
       $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url  : "{{route('GenerateReport')}}",
                data : data,
                success : function(data){
                  if(data.success == true){
                    if(data.count > 0){
                      $('.template_block').show();
                    }
                    $('#content_result').show();
                     $('#content_result').html(data.html);
                     
                  }
                  $('#generate_report').removeAttr('disabled');
                  $('.template_loader').hide();
                 // location.reload(true);
                }
            });
   }
 });

 
 });


</script>