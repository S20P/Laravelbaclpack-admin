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

/*analytics result css*/
#account-details .card-body {
    align-items: center;
    justify-content: center;
    display: flex;
    flex-direction: column;
}

.gradient-pink-text {
    background: linear-gradient(to right, #f84e6b 0, #5973e6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}


.dash-data-card {
    min-height: 190px;
    color: #fff;
    margin-bottom: 30px;
}

.card {
    background: linear-gradient(to right, #f84e6b 0, #5973e6 100%);
    border: none;
    border-radius: 5px;
}
.text-center {
    text-align: center!important;
}
#account-details .card-body {
    align-items: center;
    justify-content: center;
    display: flex;
    flex-direction: column;
}
.dash-data-card .card-body h3 {
    font-size: 22px;
    color: #fff;
    margin-bottom: 15px;
    font-family: Avenir-Medium;
}
</style>

<main class="main pt-2">
   <nav aria-label="breadcrumb" class="d-none d-lg-block">
     
   </nav>
   <section class="container-fluid">
      <h2>
         <span class="text-capitalize">Analytics Report</span>
       
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
                   <label for="report_type" class="report_type_error">Supplier</label>
                    <select name="supplier_id" id="supplier_id" required>
                      <option value="">Select Supplier</option>
                      @if(isset($Supplier))
                          @foreach($Supplier as $item)
                             <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach
                      @endif
                   </select>
</div>
                  </div>
              
                 
                       </div>
                 
                    <button type="button" class="find-btn btn btn-primary" id="generate_analytics_report"><i class="fas fa-search"></i>Find</button> 
             
                     </form>
                     <div class="template_loader hide"></div>
                     <div id="content_result" class="hide">
                        <div class="tab-pane fade active show" id="account-details">
      <h2 class="gradient-pink-text">Analytics details for <span id="supplier_name"></span></h2>
    
      <div class="row">
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-eye"></i></div>
                  <h3 id="total_impressions"></h3>
                  <h6 class="font-14">Number of impressions</h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-hand-pointer"></i></div>
                  <h3 id="total_clicks"></h3>
                  <h6 class="font-14">Number of clicks</h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-image"></i></div>
                  <h3 id="total_viewed_photo"></h3>
                  <h6 class="font-14">Most viewed photo</h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-question-circle"></i></div>
                  <h3 id="total_enquiries"></h3>
                  <h6 class="font-14">No. of enquiries through PP </h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="fas fa-mobile-alt"></i></div>
                  <h3 id="total_viewed_mobile"></h3>
                  <h6 class="font-14">No of people who clicked to call (mobile)</h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-envelope-open"></i></div>
                  <h3 id="total_viewed_email"></h3>
                  <h6 class="font-14">No. of people who clicked to email/message </h6>
               </div>
            </div>
         </div>
      </div>
      

  <h2 class="gradient-pink-text">Most viewed Image</h2>
  <div>
    <img src="" id="most_viewed_image" width="400px">
  </div>
    

   </div>
                     </div>
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

   $(document).on('click','#generate_analytics_report',function() {
      

      var supplier_id= $("#supplier_id").val();
      var supplier_name = $("#supplier_id option:selected").html();
       $("#supplier_name").text(supplier_name);

      var error_status = true;
      if(supplier_id==null || supplier_id==""){
error_status = false;
$("#report_type_error").addClass("error");
                    $('#content_result').hide();

      }
if(error_status){
//$('#generate_analytics_report').attr('disabled','disabled');
$("#report_type_error").removeClass("error");

          

      $('.template_loader').show();


      var action_url ="{{backpack_url('reports/supplier_analytics_details')}}/"+supplier_id;
$('#most_viewed_image').attr("src",""); 
       $.ajax({
                type : 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url  : action_url,
                success : function(data){
                  if(data.success == true){
                    if(data.count > 0){
                      $('.template_block').show();
                    }
                    $('#content_result').show();

 $('#total_clicks').text(data.html.total_clicks);
 $('#total_enquiries').text(data.html.total_enquiries);
 $('#total_impressions').text(data.html.total_impressions);
 $('#total_viewed_email').text(data.html.total_viewed_email);
 $('#total_viewed_mobile').text(data.html.total_viewed_mobile);
 $('#total_viewed_photo').text(data.html.total_viewed_photo); 

 $('#most_viewed_image').attr("src",data.html.most_viewed_image); 



                   
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