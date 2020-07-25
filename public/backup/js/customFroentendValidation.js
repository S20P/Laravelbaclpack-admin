function register() {
    $('.success_signup_main').empty();
    var e = $("form[name='registration']").serializeArray();
    $.ajax({
        type: "POST",
        url: APP_URL + "/register",
        data: e,
        success: function(e) {

            if(e.error){
            $('.success_signup_main').append('<div class="alert alert-danger success_hide" role="alert">'+e.error+'</div>');
             setTimeout(function(){ $('.success_hide').fadeOut();    }, 3000);     
            }
             if(e.success){
             $('.success_signup_main').append('<div class="alert alert-success success_hide" role="alert">'+e.success+'</div>');
             setTimeout(function(){ $('.success_hide').fadeOut();    }, 3000);
         }
             $('.cus_name').val('');
             $('.cus_email').val('');
             $('.cus_pass').val('');
             $('.cus_con_pass').val('');
             $( ".cus_agree" ).attr( "checked", false );

            // $("form[name='registration']").trigger("reset"), $(".signup-form-content, .offcanvas-overly").removeClass("active"), $.toast({
            //     heading: "Success",
            //     bgColor: "#007bff",
            //     hideAfter: 5e3,
            //     text: e.success,
            //     position: "top-right",
            //     stack: !1,
            //     icon: "success"
            // })
        },
        error: function(e) {}
    })
}

// function getBooking(e = null) {
//     "add" == e && ($("#booking-crud").html(""), $("#booking-crud").prepend(""));
//     var r = $(".supplier_id").val();
//     $.ajax({
//         type: "get",
//         url: APP_URL + "/booking",
//         data: {
//             supplier_id: r
//         },
//         success: function(e) {
//         	console.log(e);
//             if (e.length > 0) {
//                 for (var r = "", s = "", a = 0; a < e.length; a++) s = 1 == e[a].booking_status ? "Completed" : "Pending", r += '<tr id="booking_id_' + e[a].id + '"><td>' + e[a].booking_date + "</td><td>" + e[a].service_name + "</td><td>" + e[a].event_name + "</td><td>" + e[a].amount + "</td><td>" + e[a].customer_name + "</td><td>" + e[a].event_address + "</td><td>" + s + "</td>", r += '<td colspan="2"><a href="javascript:void(0)" id="edit_booking" data-id="' + e[a].id + '" class="btn common-btn"> <i class="fal fa-edit"></i></a></td>', r += '<td colspan="2"><a href="javascript:void(0)" id="delete_booking" data-id="' + e[a].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
//                 $("#booking-crud").html(r)
//             } else $("#booking-crud").html('<tr><td colspan="6"><p class="text-danger">No bookings available.</p></td></tr>')
//         },
//         error: function(e) {}
//     })
// }
function getBooking(action=null) {

if(action=="add"){
  $("#booking-crud").html("");
  $("#booking-crud").prepend("");
}

var supplier_id = $('.supplier_id').val();
 
  $.ajax({
    type: "get",
    url: APP_URL + '/booking',
    data :{
      "supplier_id":supplier_id
    },
      success: function (data) {
      	
if(data.booking.length>0){
  var bookingdata = "";
  var status = '';
  for(var i=0;i<data.booking.length;i++){

    status =  data.booking[i].booking_status;

    // if(data.booking[i].booking_status == 1){
    //   status = "Completed";
    // }else{
    //    status = "Pending";
    // }
    bookingdata += '<tr id="booking_id_' + data.booking[i].id + '"><td>' + data.booking[i].book_date + '</td><td>' + data.booking[i].service_name + '</td><td>' + data.booking[i].event_name +'</td><td>' + data.symbol + data.booking[i].amount + '</td><td>' + data.booking[i].customer_name+ '</td><td>' + data.booking[i].event_address + '</td><td>' + status + '</td>';
     if(data.booking[i].booking_status != 1){
        bookingdata += '<td colspan="2"><a href="javascript:void(0)" id="send_booking_confirmation_mail" class="btn btn-sm btn-link" data-id="' + data.booking[i].id + '"> <i class="fa fa-paper-plane-o"></i>Resend Confirmation Email</a></td>';
        bookingdata += '<td colspan="2"><a href="'+APP_URL+'/invoice/'+data.booking[i].encoded_id+'" target="_blank"  class="btn btn-sm btn-link"> <i class="fa fa-paper-plane-o"></i>View invoice</a></td>';
        bookingdata += '<td colspan="2"><a href="javascript:void(0)"  id="invoice_download" data-id="' + data.booking[i].id + '" class="btn btn-sm btn-link"> <i class="fa fa-download"></i>Download invoice</a></td>';
    	bookingdata += '<td colspan="2"><a href="javascript:void(0)" id="edit_booking" data-id="' + data.booking[i].id + '" class="btn common-btn"> <i class="fal fa-edit"></i></a></td>';
    } else {
    	bookingdata += '<td colspan="2"> --- </td>';
    }
    bookingdata += '<td colspan="2"><a href="javascript:void(0)" id="delete_booking" data-id="' + data.booking[i].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
    // if(action=="update"){
    //   $("#booking_id_" + data[i].id).replaceWith(bookingdata);
    //   return false;
    // }


  }
  $("#booking-crud").html(bookingdata);


} else{
  $("#booking-crud").html('<tr><td colspan="6"><p class="text-danger">No bookings available.</p></td></tr>');
}
         },
    error: function (data) {
   
    }
  })
}

function getCustomerWishlist(e = null) {
    "add" == e && $("#customer-wishlist-crud").html("");
    var r = $(".customer_id").val();
    $.ajax({
        type: "get",
        url: APP_URL + "/get-wishlist-account",
        data: {
            customer_id: r
        },
        success: function(e) {
            if (e.length > 0) {
                for (var r = "", s = 0; s < e.length; s++) r += '<tr id="wishlist_id_' + e[s].wish_id + '"><td>' + e[s].business_name + "</td><td>" + e[s].service_name + "</td><td>" + e[s].created_at + "</td>", r += '<td><a href="javascript:void(0)" id="delete_wish" data-id="' + e[s].wish_id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
                $("#customer-wishlist-crud").html(r)
            } else $("#customer-wishlist-crud").html('<tr><td colspan="6"><p class="text-danger">No Wishlist available.</p></td></tr>')
        },
        error: function(e) {}
    })
}

// function getCustomerBooking(e = null) {
//     "add" == e && $("#customer-booking-crud").html("");
//     var r = $(".customer_id").val();
//     $.ajax({
//         type: "get",
//         url: APP_URL + "/booking_by_customer",
//         data: {
//             customer_id: r
//         },
//         success: function(r) {
//             if (r.length > 0) {
//                 for (var s = "", a = "", i = 0; i < r.length; i++) a = 1 == r[i].booking_status ? "Completed" : "Pending", s += '<tr id="booking_id_' + r[i].id + '"><td>' + r[i].booking_date + "</td><td>" + r[i].service_name + "</td><td>" + r[i].event_name + "</td><td>" + r[i].amount + "</td><td>" + r[i].business_name + "</td><td>" + r[i].event_address + "</td><td>" + a + "</td>", s += '<td><a href="javascript:void(0)" id="delete_booking" data-id="' + r[i].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
//                 "update" == e ? $("#booking_id_" + r[i].id).replaceWith(s) : $("#customer-booking-crud").html(s)
//             } else $("#customer-booking-crud").html('<tr><td colspan="6"><p class="text-danger">No bookings available.</p></td></tr>')
//         },
//         error: function(e) {}
//     })
// }
function getCustomerBooking(action=null) {

  if(action=="add"){
    $("#customer-booking-crud").html("");
  }
  var customer_id = $('.customer_id').val();
   
    $.ajax({
      type: "get",
      url: APP_URL + '/booking-by-customer',
      data :{
        "customer_id":customer_id
      },
        success: function (data) {

  if(data.booking.length>0){
    var bookingdata = "";
    var status = "";
    for(var i=0;i<data.booking.length;i++){
        //if(data.booking[i].booking_status == 1){
    //   status = "Completed";
    // }else{
    //    status = "Pending";
    // }
    status = data.booking[i].booking_status;

       bookingdata += '<tr id="booking_id_' + data.booking[i].id + '"><td>' + data.booking[i].book_date + '</td><td>' + data.booking[i].service_name + '</td><td>' + data.booking[i].event_name +'</td><td>' + data.symbol + data.booking[i].amount + '</td><td>' + data.booking[i].business_name+ '</td><td>' + data.booking[i].event_address + '</td><td>' + status + '</td>';
       bookingdata += '<td colspan="2"><a href="'+APP_URL+'/invoice/'+data.booking[i].encoded_id+'" target="_blank" class="btn btn-sm btn-link"> <i class="fa fa-paper-plane-o"></i>View invoice</a></td>';
       bookingdata += '<td colspan="2"><a href="javascript:void(0)"  id="invoice_download" data-id="' + data.booking[i].id + '" class="btn btn-sm btn-link"> <i class="fa fa-download"></i>Download invoice</a></td>';
       bookingdata += '<td><a href="javascript:void(0)" id="delete_booking" data-id="' + data.booking[i].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
      
    }
    if(action=="update"){
      $("#booking_id_" + data.booking[i].id).replaceWith(bookingdata);
    }
    else{
      $("#customer-booking-crud").html(bookingdata);
    }
  }
  else{
    $("#customer-booking-crud").html('<tr><td colspan="6"><p class="text-danger">No bookings available.</p></td></tr>');
  }
  },
  error: function (data) {

  }
})
}

function getSupplierServices(e = null) {

        $("#supplier_services_crud").html("");
        $("#supplier_services_crud").prepend("");
      
   
    var r = $(".supplier_id").val();
    $.ajax({
        type: "get",
        url: APP_URL + "/supplier-services/" + r,
        success: function(r) {
            if (console.log("supplier_services_crud-data", r), r.length > 0)
                for (var s = "", a = "", i = "", t = "", n = 0; n < r.length; n++) {
                    s = r[n].facebook_title, a = r[n].facebook_link, "" != s && null != s && "" != a && null != a ? (s = r[n].facebook_title, a = r[n].facebook_link) : (s = "", a = ""), "" != t && null != t && "" != i && null != i ? (t = r[n].instagram_title, i = r[n].instagram_link) : (t = "", i = "");
                    var o = '<tr id="supplier_services_crud_id_' + r[n].id + '"><td>' + r[n].service_name + "</td><td>" + r[n].events + "</td><td>" + r[n].business_name + "</td><td>" + r[n].price_range + "</td><td>" + r[n].location + '</td><td><a class="supplier_media_link" href=' + a + '  target="_blank">' + s + '</a></td><td><a class="supplier_media_link" href=' + i + '  target="_blank">' + t + "</a></td>";
                    o += '<td><a href="javascript:void(0)" id="edit_services_slider" data-id="' + r[n].id + '" class="btn common-btn"> <i class="fal fa-edit"></i></a></td>', o += '<td><a href="javascript:void(0)" id="edit_supplier_services" data-id="' + r[n].id + '" class="btn common-btn"> <i class="fal fa-edit"></i></a></td>', o += '<td><a href="javascript:void(0)" id="delete_supplier_services" data-id="' + r[n].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>', "update" == e ? $("#supplier_services_crud_id_" + r[n].id).replaceWith(o) : $("#supplier_services_crud").prepend(o)
                }
        },
        error: function(e) {}
    })
}
$.validator.addMethod("regex", function(e, r, s) {
    var a = new RegExp(s);
    return this.optional(r) || a.test(e)
}), $.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
}), $(function() {
    $("form[name='registration']").validate({
        rules: {
            name: "required",
            email: {
                required: !0,
                email: !0,
                // remote: {
                //     url: "check_email_exists",
                //     type: "post",
                //     data: {
                //         email: function() {
                //             return $("#profileemail").val()
                //         },
                //         profile_type: function() {
                //             return $("#profile_type_check").val()
                //         }
                //     }
                // }
            },
            password: {
                required: !0,
                minlength: 6
            },
            password_confirmation: {
                minlength: 6,
                equalTo: "#profilepassword"
            }
        },
        messages: {
            name: "Please enter your name",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                remote: "Email already in use!"
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Confirm Password and Password do not match"
            }
        },
        submitHandler: function(e) {
            register()
        }
    }), $("form[name='form_subscription']").validate({
        rules: {
            email: {
                required: !0,
                email: !0,
                remote: {
                    url: "check_subscribe_exists",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#newsletter_email").val()
                        }
                    }
                }
            }
        },
        messages: {
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                remote: "You are already subscribed!"
            }
        },
        submitHandler: function(e) {
            subscription()
        }
    }),  $("form[name='BecomeSupplierSignup']").validate({
        rules: {
            name: "required",
            service_name: "required",
            business_name: "required",
            services: "required",
            events: "required",
            location: "required",
            service_description: "required",
            phone: {
                number: !0
            },
            email: {
                required: !0,
                email: !0,
                remote: {
                    url: "check_email_exists",
                    type: "post",
                    data: {
                        email: function() {
                            return $(".BecomeSupplierEmail").val()
                        },
                        profile_type: function() {
                            return "supplier"
                        }
                    }
                }
            },
            password: {
                required: !0,
                minlength: 6
            },
            password_confirmation: {
                minlength: 6,
                equalTo: ".BecomeSupplierPassword"
            },
            remember2: "required"
        },
        messages: {
            name: "Please enter your name",
            business_name: "Please enter business name",
            service_description: "Please enter service description",
            services: "Please enter service type",
            events: "Please enter events type",
            location: "Please enter location",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                remote: "Email already in use!"
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Confirm Password and Password do not match"
            },
            remember2: "Please select terms and conditions"
        },
        submitHandler: function(e) {
            return e.submit(), !1
        },
        errorPlacement: function(e, r) {
            r.is("select.chosen-select") ? r.next("div.chosen-container").append(e) : r.is("select.services_desktop") ? $("div.services_error").html(e) : e.insertAfter(r)
        }
    }), $("form[name='upload_profile_picture_form']").validate({
        rules: {
            image: {
                extension: "jpg|jpeg|png|ico|bmp"
            }
        },
        messages: {
            image: {
                extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
            }
        },
        submitHandler: function(e) {
            return e.submit(), !1
        }
    }), $("form[name='supplier_profile_form']").validate({
        rules: {
            name: "required",
            service_name: "required",
            business_name: "required",
            service_description: "required",
            phone: {
                minlength: 10,
                number: !0
            },
            email: {
                required: !0,
                email: !0
            }
        },
        messages: {
            name: "Please enter your name",
            service_name: "Please enter service name",
            business_name: "Please enter business name",
            service_description: "Please enter service description",
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address."
            },
            phone: {
                minlength: "Your phone number is too short."
            }
        },
        submitHandler: function(e) {
            return UpdateSupplierProfile(), !1
        }
    }), $("form[name='customer_profile_form']").validate({
        rules: {
            name: "required",
            phone: {
                minlength: 10,
                number: !0
            },
            email: {
                required: !0,
                email: !0
            }
        },
        messages: {
            name: "Please enter your name",
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address."
            },
            phone: {
                minlength: "Your phone number is too short."
            }
        },
        submitHandler: function(e) {
            return UpdateCustomerProfile(), !1
        }
    }), $("form[name='supplier_account_change_email_form']").validate({
        rules: {
            email: {
                required: !0,
                email: !0
            }
        },
        messages: {
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address."
            }
        },
        submitHandler: function(e) {
            return changeSupplierEmail(), !1
        }
    }), $("form[name='supplier_account_change_phone_form']").validate({
        rules: {
            phone: {
                minlength: 10,
                number: !0
            }
        },
        messages: {
            phone: {
                minlength: "Your phone number is too short."
            }
        },
        submitHandler: function(e) {
            return changeSupplierPhone(), !1
        }
    }), $("form[name='supplier_account_change_password_form']").validate({
        rules: {
            password: {
                required: !0,
                minlength: 6
            },
            password_confirmation: {
                minlength: 6,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Confirm Password and Password do not match"
            }
        },
        submitHandler: function(e) {
            return changeSupplierPassword(), !1
        }
    }), $.validator.setDefaults({
        debug: !0,
        success: "valid"
    }), $("form[name='customer_account_change_email_form']").validate({
        rules: {
            email: {
                required: !0,
                email: !0
            }
        },
        messages: {
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address."
            }
        },
        submitHandler: function(e) {
            return changeAccountEmail(), !1
        }
    }), $("form[name='customer_account_change_password_form']").validate({
        rules: {
            password: {
                required: !0,
                minlength: 6
            },
            password_confirmation: {
                minlength: 6,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Confirm Password and Password do not match"
            }
        },
        submitHandler: function(e) {
            return changeAccountPassword(), !1
        }
    }), $("form[name='customer_account_change_phone_form']").validate({
        rules: {
            phone: {
                minlength: 10,
                number: !0
            }
        },
        messages: {
            phone: {
                minlength: "Your phone number is too short."
            }
        },
        submitHandler: function(e) {
            return changeAccountPhone(), !1
        }
    }), $("form[name='booking_add']").validate({
        rules: {
            booking_date: "required",
            supplier_services_id: "required",
            amount: {
                required: !0,
                number: !0
            },
            event_id: {
                required: !0
            },
            customer_email: {
                required: !0,
                email: !0,
                remote: {
                    url: "check_customer_exists",
                    type: "post",
                    data: {
                        customer_email: function() {
                            return $(".customer_email").val()
                        }
                    }
                }
            }
        },
        messages: {
            booking_date: "Please enter Booking date",
            supplier_services_id: "Please select Service",
            event_id: {
                required: "Please select an event"
            },
            amount: {
                required: "Please enter amount"
            },
            customer_email: {
                required: "Please enter email address.",
                email: "Please enter a valid email address.",
                remote: "Customer not found for this Email address!"
            }
        },
        errorPlacement: function(e, r) {
            console.log(r), r.is("select.select_custom") ? $("div.add_erros").html(e) : r.is("select.select_custom_event") ? $("div.add_erros_event").html(e) : e.insertAfter(r)
        },
        submitHandler: function(e) {
            $(".loader").removeClass("hide");
            var r = $(".booking_add_form").serialize();
            return $.ajax({
                type: "POST",
                url: APP_URL + "/booking/add",
                data: r,
                success: function(e) {
                    $(".loader").addClass("hide"), $("#booking_add_model").modal("hide"), getBooking("add"), $(".booking_add_form").trigger("reset"), e.success ? $.toast({
                        heading: "Success",
                        bgColor: "#007bff",
                        hideAfter: 5e3,
                        text: e.success,
                        position: "top-right",
                        stack: !1,
                        icon: "success"
                    }) : e.info ? $.toast({
                        heading: "Success",
                        hideAfter: 5e3,
                        text: e.info,
                        position: "top-right",
                        stack: !1,
                        icon: "info"
                    }) : $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                },
                error: function(e) {
                    $(".loader").addClass("hide"), $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                }
            }), !1
        }
    }), $("form[name='booking_update']").validate({
        rules: {
            booking_date: "required",
            service_name: "required",
            amount: {
                required: !0,
                number: !0
            },
            event_id: {
                required: !0
            }
        },
        messages: {
            booking_date: "Please enter Booking date",
            service_name: "Please enter Service Name",
            event_id: {
                required: "Please select an item!"
            },
            amount: {
                required: "Please enter amount"
            }
        },
        submitHandler: function(e) {
            $(".loader").removeClass("hide");
            var r = $(".booking_update").serialize();
            return $.ajax({
                type: "POST",
                url: APP_URL + "/booking/update",
                data: r,
                success: function(e) {
                    $(".loader").addClass("hide"), $("#booking_edit_model").modal("hide"), getBooking("update"), e.success ? $.toast({
                        heading: "Success",
                        bgColor: "#007bff",
                        hideAfter: 5e3,
                        text: e.success,
                        position: "top-right",
                        stack: !1,
                        icon: "success"
                    }) : $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                },
                error: function(e) {
                    $(".loader").addClass("hide"), $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                }
            }), !1
        }
    }), $("form[name='supplier_services_update_form']").validate({
        rules: {
            business_name: "required"
        },
        messages: {
            business_name: {
                required: "Please enter Business name."
            }
        },
        submitHandler: function(e) {
            $(".loader").removeClass("hide");
            var r = $(".supplier_services_update_form").serialize();
            return $.ajax({
                type: "POST",
                url: APP_URL + "/supplier_services/update",
                data: r,
                success: function(e) {
                    $(".loader").addClass("hide"), $("#edit_supplier_services_model").modal("hide"), getSupplierServices("update"), e.success ? $.toast({
                        heading: "Success",
                        bgColor: "#007bff",
                        text: e.success,
                        hideAfter: 5e3,
                        position: "top-right",
                        stack: !1,
                        icon: "success"
                    }) : $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                },
                error: function(e) {
                    $(".loader").addClass("hide"), $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                }
            }), !1
        }
    }), $("form[name='services_slider_form']").validate({
        rules: {
            heading: "required"
        },
        messages: {
            heading: {
                required: "Please enter slide heading."
            }
        },
        submitHandler: function(e) {
            $(".loader").removeClass("hide"), $(".services_slider_form").serialize();
            for (var r = $("#image-upload").prop("files"), s = new FormData, a = 0; a < r.length; a++) s.append("image", r[a]);
            console.log("Arra", r); 
            var i = $(".edit_content").val(),
                t = $(".edit_heading").val(),
                n = $(".edit_service_slide_id").val();
            return s.append("content", i), s.append("heading", t), s.append("supplier_services_id", n), $.ajax({
                type: "POST",
                url: APP_URL + "/service_slider/update",
                data: s,
                contentType: !1,
                processData: !1,
                cache: !1,
                success: function(e) {

                    serviceSliderData(n);

                    $(".loader").addClass("hide"), $("#edit_services_slider_model").modal("hide"), e.success ? $.toast({
                        heading: "Success",
                        bgColor: "#007bff",
                        hideAfter: 5e3,
                        text: e.success,
                        position: "top-right",
                        stack: !1,
                        icon: "success"
                    }) : $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                },
                error: function(e) {
                    $(".loader").addClass("hide"), $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                }
            }), !1
        }
    }), $("form[name='sendinvoicefrom']").validate({
        rules: {
            booking_date: "required",
            service_name: "required",
            event_id: "required",
            amount: {
                required: !0,
                number: !0
            }
        },
        messages: {
            booking_date: "Please enter Booking date",
            service_name: "Please enter Service Name",
            event_id: "Please select Event Type",
            amount: {
                required: "Please enter amount"
            }
        },
        errorPlacement: function(e, r) {
            console.log(r), r.is("select.add_invoice_select") ? $("div.add_invoice_event").html(e) : e.insertAfter(r)
        },
        submitHandler: function(e) {
            $(".loader").removeClass("hide");
            var r = $(".sendinvoicefrom").serialize();
            return $.ajax({
                type: "POST",
                url: APP_URL + "/supplier/Sendinvoice",
                data: r,
                success: function(e) {
                    $(".loader").addClass("hide"), $("#invoice").modal("hide"), e.success ? $.toast({
                        heading: "Success",
                        bgColor: "#007bff",
                        hideAfter: 5e3,
                        text: e.success,
                        position: "top-right",
                        stack: !1,
                        icon: "success"
                    }) : $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                },
                error: function(e) {
                    $(".loader").addClass("hide"), $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                }
            }), !1
        }
    }), $("form[name='payment_transfer_info_supplier_form']").validate({
        rules: {
            account_holder_name: "required",
            account_number: {
                required: !0,
                minlength: 8
            },
            bank_name: "required",
            ifsc: {
                required: !0,
                minlength: 11
            },
            iban: {
                required: !0,
                minlength: 10
            },
            sortcode: {
                required: !0,
                minlength: 3
            }
        },
        messages: {
            account_holder_name: "Please enter Account Holder Name",
            account_number: {
                required: "Please enter Account Number",
                minlength: "Please enter valid Account Number"
            },
            bank_name: "Please enter Bank Name",
            ifsc: {
                required: "Please enter IFSC",
                minlength: "Please enter valid IFSC"
            },
            iban: {
                required: "Please enter IBAN",
                minlength: "Please enter valid IBAN"
            },
            sortcode: {
                required: "Please enter Sort or Swift code",
                minlength: "Code is too sort"
            }
        },
        submitHandler: function(e) {
            $(".loader").removeClass("hide");
            var r = $(".payment_transfer_info_supplier_form").serialize();
            return $.ajax({
                type: "POST",
                url: APP_URL + "/supplier/payment_transfer_info",
                data: r,
                success: function(e) {
                    $(".loader").addClass("hide"), e.success ? $.toast({
                        heading: "Success",
                        hideAfter: 5e3,
                        bgColor: "#007bff",
                        text: e.success,
                        position: "top-right",
                        stack: !1,
                        icon: "success"
                    }) : $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                },
                error: function(e) {
                    $(".loader").addClass("hide"), $.toast({
                        heading: "Error",
                        hideAfter: 5e3,
                        text: e.error,
                        position: "top-right",
                        stack: !1,
                        icon: "error"
                    })
                }
            }), !1
        }
    }), $("form[name='BecomeSupplierSignupmobile']").validate({
        rules: {
            name: "required",
            service_name: "required",
            business_name: "required",
            services: "required",
            events: "required",
            location: "required",
            service_description: "required",
            phone: {
                number: !0
            },
            email: {
                required: !0,
                email: !0,
                remote: {
                    url: "check_email_exists",
                    type: "post",
                    data: {
                        email: function() {
                            return $(".BecomeSupplierEmailmob").val()
                        },
                        profile_type: function() {
                            return "supplier"
                        }
                    }
                }
            },
            password: {
                required: !0,
                minlength: 6
            },
            password_confirmation: {
                minlength: 6,
                equalTo: ".BecomeSupplierPasswordmob"
            }
        },
        messages: {
            name: "Please enter your name",
            business_name: "Please enter business name",
            service_description: "Please enter service description",
            services: "Please enter service type",
            events: "Please enter events type",
            location: "Please enter location",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                remote: "Email already in use!"
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Confirm Password and Password do not match"
            }
        },
        errorPlacement: function(e, r) {
            r.is("select.chosen-select") ? r.next("div.chosen-container").append(e) : r.is("select.services_mobile") ? $("div.services_mobile_error").html(e) : e.insertAfter(r)
        },
        submitHandler: function(e) {
            return e.submit(), !1
        }
    })
}), $(document).on("click", ".bookingrefresh", function() {
    $("#booking-crud").html(""), $("#booking-crud").prepend(""), getCustomerBooking("add"), getBooking("add")
}), getSupplierServices("add");


$("form[name='supplier_services_add_form']").validate({
    rules: {
        business_name: "required"
    },
    messages: {
        business_name: {
            required: "Please enter Business name."
        }
    },
    submitHandler: function(e) {
        $(".loader").removeClass("hide");
        var r = $(".supplier_services_add_form").serialize();
        return $.ajax({
            type: "POST",
            url: APP_URL + "/supplier/supplier_services/add",
            data: r,
            success: function(e) {
                $(".loader").addClass("hide"), $("#add_supplier_services_model").modal("hide"), getSupplierServices("add"), e.success ? $.toast({
                    heading: "Success",
                    bgColor: "#007bff",
                    text: e.success,
                    hideAfter: 5e3,
                    position: "top-right",
                    stack: !1,
                    icon: "success"
                }) : $.toast({
                    heading: "Error",
                    hideAfter: 5e3,
                    text: e.error,
                    position: "top-right",
                    stack: !1,
                    icon: "error"
                })
            },
            error: function(e) {
                $(".loader").addClass("hide"), $.toast({
                    heading: "Error",
                    hideAfter: 5e3,
                    text: e.error,
                    position: "top-right",
                    stack: !1,
                    icon: "error"
                })
            }
        }), !1
    }
});