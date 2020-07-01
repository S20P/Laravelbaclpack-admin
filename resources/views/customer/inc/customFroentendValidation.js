// Wait for the DOM to be ready



$.validator.addMethod(
  "regex",
  function (value, element, regexp) {
    var re = new RegExp(regexp);
    return this.optional(element) || re.test(value);
  });
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


$(function () {

  getBooking();
  // getCustomerBooking();
  // getCustomerWishlist();
// ---------------------------------------------------------------------------------------------------------------
//                                      Profile Signup Form Validation
//----------------------------------------------------------------------------------------------------------------


  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='registration']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      name: "required",
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true,
        remote: {
          url: "check_email_exists",
          type: "post",
          data: {
            email: function () {
              return $("#profileemail").val();
            },
            profile_type: function () {
              return $("#profile_type_check").val();
            }
          }
        }
      },
      password: {
        required: true,
        minlength: 6
      },
      password_confirmation: {
        minlength: 6,
        equalTo: "#profilepassword"
      }
    },
    // Specify validation error messages
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
      },
    },
    submitHandler: function (form) {

      //  form.submit();
      register();
      // return false;
    }
  });

    // Contact Us validations
    $("form[name='contact_form']").validate({
        // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            name: "required",
            email: {
                required: true,
                // Specify that email should be validated
                // by the built-in "email" rule
            },
           subject: "required",
           message: {
                required: true,
                minlength: 5,
            }
        },
        // Specify validation error messages
        messages: {
            name: "Please enter your name",

            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
            },
           subject : "Please enter your subject",
          message : {
            required: "Please enter your message.",
            minlength: "Your message must be at least 6 characters long.",
          }

        },
        submitHandler: function (form) {
           
             form.submit();
            return false;
        }
    });



// ---------------------------------------------------------------------------------------------------------------
//                                      Subscribe Form Validation
//----------------------------------------------------------------------------------------------------------------
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='form_subscription']").validate({
    // Specify validation rules
    rules: {

      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true,
        remote: {
          url: "check_subscribe_exists",
          type: "post",
          data: {
            email: function () {
              return $("#newsletter_email").val();
            },

          }
        }
      },

    },
    // Specify validation error messages
    messages: {

      email: {
        required: "Please enter your email address.",
        email: "Please enter a valid email address.",
        remote: "You are already subscribed!"
      },

    },
    submitHandler: function (form) {
      
       // form.submit();
      subscription();
      // return false;
    }
  });
// ---------------------------------------------------------------------------------------------------------------
//                                      Profile Login Form Validation
//----------------------------------------------------------------------------------------------------------------

  $("form[name='profilelogin']").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 6
      },
    },
    // Specify validation error messages
    messages: {
      name: "Please enter your name",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
      email: {
        required: "Please enter your email address.",
        email: "Please enter a valid email address.",
      },
    },
    submitHandler: function (form) {
      form.submit();
      return false;
    }
  });


// ---------------------------------------------------------------------------------------------------------------
//                                      Become a SupplierSignup  Form Validation
//----------------------------------------------------------------------------------------------------------------

  $("form[name='BecomeSupplierSignup']").validate({
    rules: {
      name: "required",
      service_name: "required",
      business_name: "required",
      services: "required",
      events: "required",
      location: "required",
      service_description: "required",
      phone: {
        // required: true,
        number: true
      },
      email: {
        required: true,
        email: true,
        remote: {
          url: "check_email_exists",
          type: "post",
          data: {
            email: function () {
              return $(".BecomeSupplierEmail").val();
            },
            profile_type: function () {
              return "supplier";
            }
          }
        }
      },
      password: {
        required: true,
        minlength: 6
      },
      password_confirmation: {
        minlength: 6,
        equalTo: ".BecomeSupplierPassword"
      },
      remember2:"required",
    },
    // Specify validation error messages
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
      remember2: "Please select terms and conditions",
    },
    submitHandler: function (form) {
      form.submit();
      return false;
    },
    errorPlacement: function (error, element) {
      if (element.is("select.chosen-select")) {
        // placement for chosen
        element.next("div.chosen-container").append(error);
      }
       else if (element.is("select.services_desktop")) {
      // placement for chosen
      $("div.services_error").html(error);
    } 
     else {
        // standard placement
        error.insertAfter(element);
      }
    }
  });




// ---------------------------------------------------------------------------------------------------------------
//                                      Supplier profile & account  Form Validation
//----------------------------------------------------------------------------------------------------------------


$("form[name='upload_profile_picture_form']").validate({
  rules: {
    image: {
      extension: "jpg|jpeg|png|ico|bmp"
    },
  },
  messages: {
    image: {
      extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
    },
  },
  submitHandler: function (form) {
    form.submit();
    return false;
  }
});



  $("form[name='supplier_profile_form']").validate({
    rules: {
      name: "required",
      service_name: "required",
      business_name: "required",
      service_description: "required",
      phone: {
        // required: true,
        minlength: 10,
        number: true
      },
      email: {
        required: true,
        email: true,
      },
    },
    messages: {
      name: "Please enter your name",
      service_name: "Please enter service name",
      business_name: "Please enter business name",
      service_description: "Please enter service description",
      email: {
        required: "Please enter your email address.",
        email: "Please enter a valid email address.",
      },
      phone: {
        minlength: "Your phone number is too short."
      },
    },
    submitHandler: function (form) {
      // form.submit();
      UpdateSupplierProfile();
      return false;
    }
  });

  $("form[name='customer_profile_form']").validate({
    rules: {
      name: "required",
      phone: {
        minlength: 10,
        // required: true,
        number: true
      },
      email: {
        required: true,
        email: true,
      },
    },
    messages: {
      name: "Please enter your name",
      email: {
        required: "Please enter your email address.",
        email: "Please enter a valid email address.",
      },
      phone: {
        minlength: "Your phone number is too short."
      },
    },
    submitHandler: function (form) {
      // form.submit();
      UpdateCustomerProfile();
      return false;
    }
  });

  $("form[name='supplier_account_change_email_form']").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
    },
    messages: {
      email: {
        required: "Please enter your email address.",
        email: "Please enter a valid email address.",
      },
    },
    submitHandler: function (form) {
        changeSupplierEmail();
      // form.submit();
      return false;
    }
  });

  $("form[name='supplier_account_change_phone_form']").validate({
    rules: {
      phone: {
        // required: true,
         minlength: 10,
        number: true
      },
    },
    messages: {
       phone: {
        minlength: "Your phone number is too short."
      },
    },
    submitHandler: function (form) {
      // form.submit();
      changeSupplierPhone();
      return false;
    }
  });

  $("form[name='supplier_account_change_password_form']").validate({
    rules: {
      password: {
        required: true,
        minlength: 6
      },
    },
    messages: {
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
    },
    submitHandler: function (form) {
      changeSupplierPassword();
      // form.submit();
      return false;
    }
  });

  


  //Booking forms validation ---------------

  $.validator.setDefaults({
    debug: true,
    success: "valid"
  });

  // Customer Account Validation
  $("form[name='customer_account_change_email_form']").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
    },
    messages: {
      email: {
        required: "Please enter your email address.",
        email: "Please enter a valid email address.",
      },
    },
    submitHandler: function (form) {
      changeAccountEmail();
      return false;
    }
  });

  $("form[name='customer_account_change_password_form']").validate({
    rules: {
      password: {
        required: true,
        minlength: 6
      },
    },
    messages: {
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
    },
    submitHandler: function (form) {
      changeAccountPassword();
      return false;
    }
  });

  $("form[name='customer_account_change_phone_form']").validate({
    rules: {
      phone: {
        // required: true,
        minlength: 10,
        number: true
      },
    },
    messages: {
      phone: {
        minlength: "Your phone number is too short."
      },
    },
    submitHandler: function (form) {
      changeAccountPhone();
      return false;
    }
  });
  
// ---------------------------------------------------------------------------------------------------------------
//                                      Create Booking  Form Validation
//----------------------------------------------------------------------------------------------------------------


  $("form[name='booking_add']").validate({
    rules: {
      booking_date: "required",
      supplier_services_id: "required",
      amount: {
        required: true,
        number: true
      },
      event_id: {
        required: true
      },
      customer_email: {
        required: true,
        email: true,
        remote: {
          url: "check_customer_exists",
          type: "post",
          data: {
            customer_email: function () {
              return $("#customer_email").val();
            },
          }
        }
      },
    },
    // Specify validation error messages
    messages: {
      booking_date: "Please enter Booking date",
      supplier_services_id: "Please select Service",
      event_id: {
        required: "Please select an event"
      },
      amount: {
        required: "Please enter amount",
      },
      customer_email: {
        required: "Please enter email address.",
        email: "Please enter a valid email address.",
        remote: "Customer not found for this Email address!"
      },
    },
     errorPlacement: function (error, element) {
         console.log(element);
    if (element.is("select.select_custom")) {
   
      // placement for chosen
      $("div.add_erros").html(error);
    } else if(element.is("select.select_custom_event")){
       $("div.add_erros_event").html(error);
    }else {
      // standard placement
      error.insertAfter(element);
    }
  },
    submitHandler: function (form) {    
       
       // form.submit();
     $('.loader').removeClass('hide');
     var serializeData = $('.booking_add_form').serialize();
   
     $.ajax({
      type: "POST",
      url: APP_URL + '/booking/add',
      data: serializeData,
      success: function (data) {  
        $('.loader').addClass('hide');
        $('#booking_add_model').modal('hide');
        getBooking("add");
        $('.booking_add_form').trigger("reset");
  if(data.success){
        $.toast({
          heading: 'Success',
          bgColor: '#007bff',
          hideAfter: 5000,
          text: data.success,
          position: 'top-right',
          stack: false,
          icon: 'success'
        });
      }
      else if(data.info){
        $.toast({
          heading: 'Success',
          hideAfter: 5000,
          text: data.info,
          position: 'top-right',
          stack: false,
          icon: 'info'
      })
      }
      else{
        $.toast({
          heading: 'Error',
          hideAfter: 5000,
          text: data.error,
          position: 'top-right',
          stack: false,
          icon: 'error'
        });
      }
        },
       
      error: function (data) {
        $('.loader').addClass('hide');
        $.toast({
          heading: 'Error',
          hideAfter: 5000,
          text: data.error,
          position: 'top-right',
          stack: false,
          icon: 'error'
        })
      }
    })

      return false;
    },
  });


// ---------------------------------------------------------------------------------------------------------------
//                                      Edit Booking  Form Validation
//----------------------------------------------------------------------------------------------------------------


  //edit booking form
  $("form[name='booking_update']").validate({
    rules: {
      booking_date: "required",
      service_name: "required",
      amount: {
        required: true,
        number: true
      },
      event_id: {
        required: true
      },
    },
    // Specify validation error messages
    messages: {
      booking_date: "Please enter Booking date",
      service_name: "Please enter Service Name",
      event_id: {
        required: "Please select an item!"
      },
      amount: {
        required: "Please enter amount",
      }
    },
    submitHandler: function (form) {
      $('.loader').removeClass('hide');

     var serializeData = $('.booking_update').serialize();
     
     $.ajax({
      type: "POST",
      url: APP_URL + '/booking/update',
      data: serializeData,
      success: function (data) {
        $('.loader').addClass('hide');
        $('#booking_edit_model').modal('hide');
        getBooking("update");
  if(data.success){
        $.toast({
          heading: 'Success',
          bgColor: '#007bff',
          hideAfter: 5000,
          text: data.success,
          position: 'top-right',
          stack: false,
          icon: 'success'
        });
        
      }else{
        $.toast({
          heading: 'Error',
          hideAfter: 5000,
          text: data.error,
          position: 'top-right',
          stack: false,
          icon: 'error'
        });
      }
        },
      error: function (data) {
        $('.loader').addClass('hide');
        $.toast({
          heading: 'Error',
          hideAfter: 5000,
          text: data.error,
          position: 'top-right',
          stack: false,
          icon: 'error'
        })
      }
    })
    //  form.submit();
      return false;
    },
  });



// ---------------------------------------------------------------------------------------------------------------
//                                      Edit Supplier-service  Form Validation
//----------------------------------------------------------------------------------------------------------------


  //edit booking form
  $("form[name='supplier_services_update_form']").validate({
    rules: {
      business_name: "required",
        },
    // Specify validation error messages
    messages: {
      business_name: {
        required: "Please enter Business name."
      },
    },
    submitHandler: function (form) {
      $('.loader').removeClass('hide');

     var serializeData = $('.supplier_services_update_form').serialize();
     
     $.ajax({
      type: "POST",
      url: APP_URL + '/supplier_services/update',
      data: serializeData,
      success: function (data) {
        $('.loader').addClass('hide');
         $('#edit_supplier_services_model').modal('hide');
         getSupplierServices("update");
  if(data.success){
        $.toast({
          heading: 'Success',
          bgColor: '#007bff',
          text: data.success,
          hideAfter: 5000,
          position: 'top-right',
          stack: false,
          icon: 'success'
        });
        
      }else{
        $.toast({
          heading: 'Error',
          hideAfter: 5000,
          text: data.error,
          position: 'top-right',
          stack: false,
          icon: 'error'
        });
      }
        },
      error: function (data) {
        $('.loader').addClass('hide');
        $.toast({
          heading: 'Error',
          hideAfter: 5000,
          text: data.error,
          position: 'top-right',
          stack: false,
          icon: 'error'
        })
      }
    })
    //  form.submit();
      return false;
    },
  });




// ---------------------------------------------------------------------------------------------------------------
//                                      Edit Supplier-service-slider  Form Validation
//----------------------------------------------------------------------------------------------------------------


  //edit booking form
  $("form[name='services_slider_form']").validate({
    rules: {
      heading: "required",
        },
    // Specify validation error messages
    messages: {
      heading: {
        required: "Please enter slide heading."
      },
    },
    submitHandler: function (form) {
      $('.loader').removeClass('hide');

     var serializeData = $('.services_slider_form').serialize();
     var file_data = $('#image-upload').prop('files');
     var formData = new FormData();
     
     for(var i=0;i<file_data.length;i++){
      formData.append('image[]', file_data[i]);
     }
   
  
     console.log("Arra",file_data); 
    var content =   $('.edit_content').val();
    var heading =  $('.edit_heading').val();
    var supplier_services_id =  $('.edit_service_slide_id').val();
 
    formData.append('content',content);
    formData.append('heading',heading);
    formData.append('supplier_services_id',supplier_services_id);

     $.ajax({
      type: "POST",
      url: APP_URL + '/service_slider/update',
       data: formData,
       contentType: false,
       processData: false,   
       cache: false,        
      success: function (data) {
        $('.loader').addClass('hide');
         $('#edit_services_slider_model').modal('hide');
  if(data.success){
        $.toast({
          heading: 'Success',
          bgColor: '#007bff',
          hideAfter: 5000,
          text: data.success,
          position: 'top-right',
          stack: false,
          icon: 'success'
        });
        
      }else{
        $.toast({
          heading: 'Error',
          hideAfter: 5000,
          text: data.error,
          position: 'top-right',
          stack: false,
          icon: 'error'
        });
      }
        },
      error: function (data) {
        $('.loader').addClass('hide');
        $.toast({
          heading: 'Error',
          hideAfter: 5000,
          text: data.error,
          position: 'top-right',
          stack: false,
          icon: 'error'
        })
      }
    })
    //  form.submit();
      return false;
    },
  });



// ---------------------------------------------------------------------------------------------------------------
//                                      Send-invoice Form Validation
//----------------------------------------------------------------------------------------------------------------


  $("form[name='sendinvoicefrom']").validate({
    rules: {
      booking_date: "required",
      service_name: "required",
      event_id: "required",
      amount: {
        required: true,
        number: true
      },
    },

    // Specify validation error messages
    messages: {
      booking_date: "Please enter Booking date",
      service_name: "Please enter Service Name",
      event_id: "Please select Event Type",

      amount: {
        required: "Please enter amount",
      }
    },
    errorPlacement: function (error, element) {
         console.log(element);
    if (element.is("select.add_invoice_select")) {
   
      // placement for chosen
      $("div.add_invoice_event").html(error);
    } else {
      // standard placement
      error.insertAfter(element);
    }
  },
    submitHandler: function (form) {
      $('.loader').removeClass('hide');
      
      var serializeData = $('.sendinvoicefrom').serialize();
      $.ajax({
       type: "POST",
       url: APP_URL + '/supplier/Sendinvoice',
       data: serializeData,
       success: function (data) {
        $('.loader').addClass('hide');
          $('#invoice').modal('hide');
   if(data.success){
         $.toast({
           heading: 'Success',
          bgColor: '#007bff',
           hideAfter: 5000,
           text: data.success,
           position: 'top-right',
           stack: false,
           icon: 'success'
         });
         
       }else{
         $.toast({
           heading: 'Error',
           hideAfter: 5000,
           text: data.error,
           position: 'top-right',
           stack: false,
           icon: 'error'
         });
       }
         },
       error: function (data) {
        $('.loader').addClass('hide');
         $.toast({
           heading: 'Error',
           hideAfter: 5000,
           text: data.error,
           position: 'top-right',
           stack: false,
           icon: 'error'
         })
       }
     })
   //   form.submit();
      return false;
    },
  });

  //Booking forms validation end---------------




// ---------------------------------------------------------------------------------------------------------------
//                                      Payment Transfer info Supplier Form Validation
//----------------------------------------------------------------------------------------------------------------


  $("form[name='payment_transfer_info_supplier_form']").validate({
    rules: {
      account_holder_name: "required",
      account_number: {
          required: true,
          minlength: 8
        },
      bank_name : "required",
      ifsc: {
          required: true,
          minlength: 11
        },
      iban: {
          required: true,
          minlength: 10
        },
      sortcode: {
          required: true,
          minlength: 3
        },
    },
    // Specify validation error messages
    messages: {
      account_holder_name: "Please enter Account Holder Name",
      account_number : {
         required: "Please enter Account Number",
         minlength: "Please enter valid Account Number",
      },
      bank_name: "Please enter Bank Name",
       ifsc : {
         required: "Please enter IFSC",
         minlength: "Please enter valid IFSC",
      },
      iban : {
         required: "Please enter IBAN",
         minlength: "Please enter valid IBAN",
      },
       sortcode : {
         required: "Please enter Sort or Swift code",
         minlength: "Code is too sort",
      },
    },
    submitHandler: function (form) {
      $('.loader').removeClass('hide');
      var serializeData = $('.payment_transfer_info_supplier_form').serialize();
      $.ajax({
       type: "POST",
       url: APP_URL + '/supplier/payment_transfer_info',
       data: serializeData,
       success: function (data) {
        $('.loader').addClass('hide');
   if(data.success){
         $.toast({
           heading: 'Success',
           hideAfter: 5000,
            bgColor: '#007bff',
           text: data.success,
           position: 'top-right',
           stack: false,
           icon: 'success'
         });
         
       }else{
         $.toast({
           heading: 'Error',
           hideAfter: 5000,
           text: data.error,
           position: 'top-right',
           stack: false,
           icon: 'error'
         });
       }
         },
       error: function (data) {
        $('.loader').addClass('hide');
         $.toast({
           heading: 'Error',
           hideAfter: 5000,
           text: data.error,
           position: 'top-right',
           stack: false,
           icon: 'error'
         })
       }
     })

      //form.submit();
      return false;
    },
  });

//--------------end

  


$("form[name='BecomeSupplierSignupmobile']").validate({
  rules: {
    name: "required",
    service_name: "required",
    business_name: "required",
    services: "required",
    events: "required",
    location: "required",
    service_description: "required",
    phone: {
      // required: true,
      number: true
    },
    email: {
      required: true,
      email: true,
      remote: {
        url: "check_email_exists",
        type: "post",
        data: {
          email: function () {
            return $(".BecomeSupplierEmailmob").val();
          },
          profile_type: function () {
            return "supplier";
          }
        }
      }
    },
    password: {
      required: true,
      minlength: 6
    },
    password_confirmation: {
      minlength: 6,
      equalTo: ".BecomeSupplierPasswordmob"
    }
  },
  // Specify validation error messages
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
  },
  errorPlacement: function (error, element) {
    if (element.is("select.chosen-select")) {
      // placement for chosen
      element.next("div.chosen-container").append(error);
    } 
    else if (element.is("select.services_mobile")) {
      // placement for chosen
      $("div.services_mobile_error").html(error);
    } 
    else {
      // standard placement
      error.insertAfter(element);
    }


  },
  submitHandler: function (form) {
    form.submit();
    return false;
  },

});


 
});

function register() {
  var serializeData = $("form[name='registration']").serializeArray();

  $.ajax({
    type: "POST",
    url: APP_URL + '/register',
    data: serializeData,
    success: function (data) {
  
      $("form[name='registration']").trigger("reset");
      $(".signup-form-content, .offcanvas-overly").removeClass("active");

      $.toast({
        heading: 'Success',
        bgColor: '#007bff',
        hideAfter: 5000,
        text: data.success,
        position: 'top-right',
        stack: false,
        icon: 'success'
      });
    },
    error: function (data) {
     
    }
  })
}


$('body').on('click', '.bookingrefresh', function () {
  $("#booking-crud").html("");
  $("#booking-crud").prepend("");
    getCustomerBooking("add");
    getBooking("add");

  });




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
      
if(data.length>0){
  var bookingdata = "";
  var status = '';
  for(var i=0;i<data.length;i++){
    if(data[i].booking_status == 1){
      status = "Completed";
    }else{
       status = "Pending";
    }
    bookingdata += '<tr id="booking_id_' + data[i].id + '"><td>' + data[i].booking_date + '</td><td>' + data[i].service_name + '</td><td>' + data[i].event_name +'</td><td>' + data[i].amount + '</td><td>' + data[i].customer_name+ '</td><td>' + data[i].event_address + '</td><td>' + status + '</td>';
    bookingdata += '<td colspan="2"><a href="javascript:void(0)" id="edit_booking" data-id="' + data[i].id + '" class="btn common-btn"> <i class="fal fa-edit"></i></a></td>';
    bookingdata += '<td colspan="2"><a href="javascript:void(0)" id="delete_booking" data-id="' + data[i].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
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


// Customer Wishlist :
function getCustomerWishlist(action=null) {
  if(action=="add"){
    $("#customer-wishlist-crud").html("");

  }
  var customer_id = $('.customer_id').val();

  $.ajax({
    type: "get",
    url: APP_URL + '/get_wishlist_account',
    data :{
      "customer_id":customer_id
    },
    success: function (data) {

      if(data.length>0){
        var wishdata = "";
        for(var i=0;i<data.length;i++){

          wishdata += '<tr id="wishlist_id_' + data[i].wish_id +'"><td>' + data[i].business_name + '</td><td>' + data[i].service_name + '</td><td>' + data[i].created_at+ '</td>';
              wishdata+= '<td><a href="javascript:void(0)" id="delete_wish" data-id="' + data[i].wish_id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';

        }
        $("#customer-wishlist-crud").html(wishdata);
      }
      else{
        $("#customer-wishlist-crud").html('<tr><td colspan="6"><p class="text-danger">No Wishlist available.</p></td></tr>');
      }
    },
    error: function (data) {

    }
  })
}



function getCustomerBooking(action=null) {

  if(action=="add"){
    $("#customer-booking-crud").html("");
  }
  var customer_id = $('.customer_id').val();
   
    $.ajax({
      type: "get",
      url: APP_URL + '/booking_by_customer',
      data :{
        "customer_id":customer_id
      },
        success: function (data) {

  if(data.length>0){
    var bookingdata = "";
    var status = "";
    for(var i=0;i<data.length;i++){
        if(data[i].booking_status == 1){
      status = "Completed";
    }else{
       status = "Pending";
    }
       bookingdata += '<tr id="booking_id_' + data[i].id + '"><td>' + data[i].booking_date + '</td><td>' + data[i].service_name + '</td><td>' + data[i].event_name +'</td><td>' + data[i].amount + '</td><td>' + data[i].business_name+ '</td><td>' + data[i].event_address + '</td><td>' + status + '</td>';
           bookingdata += '<td><a href="javascript:void(0)" id="delete_booking" data-id="' + data[i].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
  

  
    }
    if(action=="update"){
      $("#booking_id_" + data[i].id).replaceWith(bookingdata);
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

getSupplierServices();
function getSupplierServices(action=null) {

  if(action=="add"){
    $("#supplier_services_crud").html("");
  }
  
  var supplier_id = $('.supplier_id').val();
   
    $.ajax({
      type: "get",
      url: APP_URL + '/supplier_services/'+supplier_id,
      success: function (data) {
          console.log("supplier_services_crud-data",data);
  if(data.length>0){
    var facebook_title = "";
    var facebook_link = "";
    var instagram_link = "";
    var instagram_title = "";
    for(var i=0;i<data.length;i++){
       facebook_title = data[i].facebook_title;
       facebook_link = data[i].facebook_link;
       if(facebook_title != "" && facebook_title != null && facebook_link != "" && facebook_link != null){
          facebook_title = data[i].facebook_title;
          facebook_link = data[i].facebook_link;
       }else{
        facebook_title = "";
        facebook_link  = "";
       }
      if(instagram_title != "" && instagram_title != null && instagram_link != "" && instagram_link != null){
          instagram_title = data[i].instagram_title;
          instagram_link = data[i].instagram_link;
       }else{
        instagram_title = "";
        instagram_link  = "";
       }
     var supplier_service_data = '<tr id="supplier_services_crud_id_' + data[i].id + '"><td>' + data[i].service_name + '</td><td>' + data[i].event_name + '</td><td>' +data[i].business_name + '</td><td>' + data[i].price_range + '</td><td>' + data[i].location + '</td><td><a class="supplier_media_link" href='+ facebook_link+'  target="_blank">' + facebook_title+ '</a></td><td><a class="supplier_media_link" href='+ instagram_link+'  target="_blank">' + instagram_title + '</a></td>';
      supplier_service_data += '<td><a href="javascript:void(0)" id="edit_services_slider" data-id="' + data[i].id + '" class="btn common-btn"> <i class="fal fa-edit"></i></a></td>';
      supplier_service_data += '<td><a href="javascript:void(0)" id="edit_supplier_services" data-id="' + data[i].id + '" class="btn common-btn"> <i class="fal fa-edit"></i></a></td>';
      supplier_service_data += '<td><a href="javascript:void(0)" id="delete_supplier_services" data-id="' + data[i].id + '" class="btn common-btn"><i class="fal fa-trash"></i></a></td></tr>';
        if(action=="update"){
            $("#supplier_services_crud_id_" + data[i].id).replaceWith(supplier_service_data);
        }
        else{
          $("#supplier_services_crud").prepend(supplier_service_data);
        }
    }
  }            
  },
      error: function (data) {
     
      }
    })
  }



