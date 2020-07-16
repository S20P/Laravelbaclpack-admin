@extends(backpack_view('blank'))
@section('content')

<style type="text/css">
   .common-btn{
    border: 1px solid;
    padding: 5px 20px;
    border-radius: 60px;
    background: white;
    color: #000;
    font-weight: 700;order: 1px solid;
    padding: 5px 20px;
    border-radius: 60px;
    background: white;
    color: #000;
    font-weight: 700;
   }
</style>

<input type="hidden" class="supplier_id" value="{{$supplier_id}}">

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
         <span class="text-capitalize">Supplier
Payment information</span>
        
        
      </h2> 

      <h5>Supplier Name : <b>{{$supplier_name}} </b></h5>
   </section>
   <div class="container-fluid animated fadeIn">
      <div class="row">
         <div class="col-md-12">
          <p></p>
               <hr>
                <div class="row loader-height">
     <!--             <div class="payment-main">
         <h5>Payments due</h5>
         <div class="event-service">
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                     <th class="DATE" scope="col">BOOKING DATE</th>
                     <th class="" scope="col">TYPE OF SERVICE</th>
                     <th class="" scope="col">EVENT NAME</th>
                     <th class="" scope="col">CUSTOMER NAME</th>
                     <th class="PAYMENT" scope="col">PAYMENT AMOUNT</th>
                     <th class="DATE" scope="col">PAYMENT Status</th>
                     <th class="DATE" scope="col">PAYMENT DATE</th>
                     </tr>
                  </thead>
                  <tbody  id="payment_due_tbody">
                  </tbody>

                  </tbody>
               </table>
            </div>
         </div>
      </div> -->
      <div class="payment-main">
         <h5>Payment history</h5>
         <div class="event-service">
            <div class="table-responsive">
            <table class="table">
                  <thead>
                     <tr>
                     <th class="DATE" scope="col">BOOKING DATE</th>
                     <th class="" scope="col">TYPE OF SERVICE</th>
                     <th class="" scope="col">EVENT NAME</th>
                     <th class="" scope="col">CUSTOMER NAME</th>
                     <th class="PAYMENT" scope="col">PAYMENT AMOUNT</th>
                     <th class="DATE" scope="col">PAYMENT Status</th>
                      <th class="DATE" scope="col">PAYMENT DATE</th>
                     </tr>
                  </thead>
                  <tbody id="payment_done_tbody">
                 
                  </tbody>
               </table>
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

    $(document).on('click','#supplier_payment_pay',function() {
 
    var booking_id = $(this).data("id");
     var update_payment_status_url = "{{backpack_url('reports/update_payment_status')}}/"+booking_id;
     $.get(update_payment_status_url, function (e)
    {
      console.log("payment_date");
      getPaymetBySupplier();
    })
       });


getPaymetBySupplier();
   function getPaymetBySupplier(action=null) {

if(action=="add"){
  $("#booking-crud").html("");
  $("#booking-crud").prepend("");
}

var id = $('.supplier_id').val();
   
    var url_use = "{{backpack_url('reports/supplier_payment_details/ajex/')}}/"+id;

console.log("URL-use",url_use);
  $.ajax({
    type: "get",
    url: url_use,
    
      success: function (data) {
        
      console.log(data);
      
if(data.length>0){
  var payment_due_response = "";
  var payment_done_response = "";


  var status = '';
  for(var i=0;i<data.length;i++){
    if(data[i].paid_unpaid == 1){
      status = "Successed";
payment_done_response += '<tr id="booking_id_' + data[i].id + '"><td>' + data[i].booking_date + '</td><td>' + data[i].service_name + '</td><td>' + data[i].event_name +'</td><td>' +  data[i].customer_name + '</td><td>' + data[i].amount+ '</td><td>' + status + '</td><td>' + data[i].payment_date + '</td>';
//payment_done_response += '<td colspan="2"> </td>';
    }
    if(data[i].paid_unpaid == 0){
       status = "Pending";
payment_done_response += '<tr id="booking_id_' + data[i].id + '"><td>' + data[i].booking_date + '</td><td>' + data[i].service_name + '</td><td>' + data[i].event_name +'</td><td>' +  data[i].customer_name + '</td><td>' + data[i].amount+ '</td><td>' + status + '</td><td>' + data[i].payment_date + '</td>';

       // if(data[i].paid_unpaid != 1){
       //      payment_due_response += '<td colspan="2"><a href="javascript:void(0)" id="supplier_payment_pay" data-id="' + data[i].id + '" class="btn common-btn">Pay</a></td>';
       //    } else {
       //      payment_due_response += '<td colspan="2"> --- </td>';
       //    }
    }

   
    
    // if(action=="update"){
    //   $("#booking_id_" + data[i].id).replaceWith(Result_response);
    //   return false;
    // }


  }
  //$("#payment_due_tbody").html(payment_due_response);
  $("#payment_done_tbody").html(payment_done_response);



} else{
  // $("#payment_due_tbody").html('<tr><td colspan="6"><p class="text-danger">No bookings available.</p></td></tr>');
  $("#payment_done_tbody").html('<tr><td colspan="6"><p class="text-danger">No bookings available.</p></td></tr>');

}
         },
    error: function (data) {
   
    }
  })
}

 
 });


</script>