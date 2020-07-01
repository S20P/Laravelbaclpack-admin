$(document).ready(function(){

     console.log("Welcome js Admin Dashboard base");

    $(document).on('click','#payment_action',function() {
 
 console.log("HI");

    var supplier_id = $(this).data("id");
    var action_url = $(this).data("url");


    console.log("supplier_id",supplier_id);

    var formContent = '<div>';
        formContent += '<form id="payment_action_form" action="'+action_url+'">';
        formContent += '<input type="hidden" id="supplier_id" name="supplier_id" value="'+supplier_id+'">';
        formContent += '<label>Comments</label><br>';
        formContent += '<textarea name="comment" id="comment"></textarea>';
        formContent += '</form>';
        formContent +='</div>';

      paymentModal("Pay",formContent);

     });

//BookingDetailsModel

    $(document).on('click','#BookingDetailsModel',function() {
 
    var booking_id = $(this).data("id");    
    var action_url = $(this).data("url");


    console.log("URL-action_url",action_url);
      $.ajax({
        type: "get",
        url: action_url,
        success: function (data) {
    console.log("data",data);
        var formContent = data.content;
        var heading = "Booking";
    BookingDetailsModal(heading,formContent);
             }
         }); 

     });



function BookingDetailsModal(heading, formContent) {
    html =  '<div id="bookingdetailsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
    html += '<div class="modal-dialog">';
    html += '<div class="modal-content">';
    html += '<div class="modal-header">';
    html += '<h4>'+heading+'</h4>';
    html += '<a class="close" data-dismiss="modal">×</a>';
    html += '</div>';
    html += '<div class="modal-body">';
    html += formContent;
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '<span class="btn btn-primary" data-dismiss="modal">Close</span>';
    html += '</div>';  // content
    html += '</div>';  // dialog
    html += '</div>';  // footer
    html += '</div>';  // modalWindow
    $('body').append(html);
    $("#bookingdetailsModal").modal();
    $("#bookingdetailsModal").modal('show');


    $('#bookingdetailsModal').on('hidden.bs.modal', function (e) {
        $(this).remove();
    });

     $('#bookingdetailsModal').on('#save', function (e) {
        console.log(":::");
    });

}
function paymentModal(heading, formContent) {
    html =  '<div id="dynamicModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">';
    html += '<div class="modal-dialog">';
    html += '<div class="modal-content">';
    html += '<div class="modal-header">';
    html += '<h4>'+heading+'</h4>';
    html += '<a class="close" data-dismiss="modal">×</a>';
    html += '</div>';
    html += '<div class="modal-body">';
    html += formContent;
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '<span class="btn btn-primary" id="save">Pay</span>';
    html += '<span class="btn btn-primary" data-dismiss="modal">Close</span>';

    html += '</div>';  // content
    html += '</div>';  // dialog
    html += '</div>';  // footer
    html += '</div>';  // modalWindow
    $('body').append(html);
    $("#dynamicModal").modal();
    $("#dynamicModal").modal('show');


    $('#dynamicModal').on('hidden.bs.modal', function (e) {
        $(this).remove();
    });

     $('#dynamicModal').on('#save', function (e) {
        console.log(":::");
    });

}


 $(document).on('click','#save',function() {
          var action_url = $('#payment_action_form').attr("action");


var formdata = $("#payment_action_form").serialize();
console.log("formdata",formdata);
console.log("URL-action_url",action_url);
  $.ajax({
    type: "get",
    url: action_url,
    data:formdata,
      success: function (data) {
console.log("data",data);
 $('#dynamicModal').hide();
 location.reload();
         }
     });
});
});



