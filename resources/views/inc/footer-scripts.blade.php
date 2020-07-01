<!-- Bootstrap core JavaScript
================================================= -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-Interactive-Multi-layer-Parallax-Effect-Parallaxmouse/dist/jquery.parallaxmouse.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.js"></script>--}}
{{--<script>--}}
{{--    $('.client-item').tilt({--}}
{{--        scale:1.1,--}}
{{--    });--}}
{{--</script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
@yield('page_plugin_script')

<!-- <script src="{{ asset('js/jquery.nice-select.js') }}"></script> -->
<script src="{{ asset('js/wow.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script src="{{ asset('js/jquery.toast.js') }}"></script>


<script type="text/javascript">
    /* Accordions */
    var APP_URL = "{{url('/')}}";
    console.log("api",APP_URL);


    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>



<script src="{{asset('js/select2.js')}}"></script>
<script src="{{asset('js/dashbord_accordion.js')}}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/customFroentendValidation.js') }}"></script>
<script src="{{ asset('js/customAnalytics.js') }}"></script>
{{--<script src="{{ asset('js/jquery.parallaxmouse.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/parallax.min.js') }}"></script>--}}


<script type="text/javascript">
    // $(window).parallaxmouse({
    //     invert: true,
    //     range: 400,
    //     elms: [
    //         {el: $('#layer-1'), rate: 0.1},
    //         {el: $('#layer-2'), rate: 0.1},
    //         {el: $('#layer-3'), rate: 0.2},
    //         {el: $('#quotes'), rate: 0.2},
    //         {el: $('#quotes-1'), rate: 0.2},
    //         {el: $('#quotes-2'), rate: 0.48},
    //         {el: $('#quotes-3'), rate: 0.7},
    //     ]
    // });

</script>
<script type="text/javascript">
    $(document).ready(function() {
            $("form[name='contact_form']").validate({
            rules: {
                name: "required",
                email: {
                    required: !0
                },
                subject: "required",
                message: {
                    required: !0,
                    minlength: 5
                }
            },
            messages: {
                name: "Please enter your name",
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                },
                subject: "Please enter your subject",
                message: {
                    required: "Please enter your message.",
                    minlength: "Your message must be at least 6 characters long."
                }
            },
            submitHandler: function(e) {
                $('.loader').removeClass('hide');
                $('.contact_succcess').empty();
                var data = $('#contact_form').serialize();
                // return e.submit(), !1
                $.ajax({
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url  : "{{route('contactUsSendAction')}}",
                    data : data,
                    success : function(data){
                        if(data.success == true){
                            $('#name_contact').val('');
                            $('#email_contact').val('');
                            $('#subject_contact').val('');
                            $('#message_contact').val('');

                            $('.contact_succcess').append('<div class="alert alert-success success_hide" role="alert">'+data.message+'</div>');
                            setTimeout(function(){ $('.success_hide').fadeOut(); }, 3000);

                        } else {
                            $.toast({
                                heading: "Error",
                                hideAfter: 5e3,
                                text: "Something went to wrong!",
                                position: "top-right",
                                stack: !1,
                                icon: "error"
                            })
                        }
                         $('.loader').addClass('hide');
                    }
                });
            }
        });
        $("form[name='profilelogin']").validate({
            rules: {
                email: {
                    required: !0,
                    email: !0
                },
                password: {
                    required: !0,
                    minlength: 6
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
                    email: "Please enter a valid email address."
                }
            },
            submitHandler: function(e) {
                 $('.error_login_main').empty();
                var data = $('.profilelogin').serialize();
                
              $.ajax({
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url  : "{{ route('profile.login') }}",
                    data : data,
                    success : function(data){
                        if(data.success == true){
                            // location.reload(true);
                            location.href = data.route;
                        }else{
                            if(data.role == "invalid"){
                                $('.error_login_main').append('<div class="alert alert-danger" role="alert">'+data.message+'</div>');
                            }else{
                                $('.error_login_main').append('<div class="alert alert-success" role="alert">'+data.message+'</div>');
                            }
                        }
                    }
                });
                // return e.submit(), !1
            }
        });
         $("form[name='supplierprofilelogin']").validate({
            rules: {
                email: {
                    required: !0,
                    email: !0
                },
                password: {
                    required: !0,
                    minlength: 6
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
                    email: "Please enter a valid email address."
                }
            },
            submitHandler: function(e) {
                 $('.error_login_supplier').empty();
                var data = $('.supplierprofilelogin').serialize();
                
              $.ajax({
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url  : "{{ route('profile.login') }}",
                    data : data,
                    success : function(data){
                        if(data.success == true){
                            // location.reload(true);
                            location.href = data.route;
                        }else{
                            if(data.role == "invalid"){
                                $('.error_login_supplier').append('<div class="alert alert-danger" role="alert">'+data.message+'</div>');
                            }else{
                                $('.error_login_supplier').append('<div class="alert alert-success" role="alert">'+data.message+'</div>');
                                
                            }
                        }
                    }
                });
                // return e.submit(), !1
            }
        });
    });
</script>
<!-- Account page -->
<script type="text/javascript">
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
    /* Simple Accordion 2 */
    $('.list-title').click(function () {
        var This = $(this);
        $('.list-accordion').removeClass('open-accordion');
        $('.list-accordion-content').slideUp();
        MyAccordions(This);
    });

    $('#help-list .list-title').click(function () {
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
    function changeAccountEmail() {

        var data =  $('#customer_account_change_email_form').serialize();
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{ route('customer.account') }}",
            data : data,
            success : function(data){
                if(data.success == true){
                    $.toast({
                        heading: 'Success',
                        bgColor: '#007bff',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'success',
                        position: 'top-right',
                    });
                    $('#customer_account_change_email_form').children('.account-input').children('#email').attr('disabled','disabled');
                    $('#customer_account_change_email_form').children('.account-input').removeClass('focus-block');
                    $('#account_email_save').addClass('hide');
                    $('.change_email').val(data.email);
                    $('.change_email').text(data.email);
                    $('#account_email_edit').removeClass('hide');
                    return false;
                }else{
                    $.toast({
                        heading: 'Error',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                    });
                }
                return false;
            }
        });

    }
    function changeAccountPassword() {
        var data =  $('#customer_account_change_password_form').serialize();
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{ route('customer.account') }}",
            data : data,
            success : function(data){
                if(data.success == true){
                    $.toast({
                        heading: 'Success',
                        bgColor: '#007bff',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'success',
                        position: 'top-right',
                    });
                    $('#customer_account_change_password_form').children('.account-input').children('#password').attr('disabled','disabled');
                    $('#customer_account_change_password_form').children('.account-input').removeClass('focus-block');
                    $('#customer_account_change_password_form').children('.account-input').children('#password').val('');
                    $('#account_pass_save').addClass('hide');
                    $('#account_pass_edit').removeClass('hide');
                    return false;
                }
                return false;
            }
        });

    }
    function changeAccountPhone() {
        var data =  $('#customer_account_change_phone_form').serialize();
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{ route('customer.account') }}",
            data : data,
            success : function(data){
                if(data.success == true){
                    $.toast({
                        heading: 'Success',
                        bgColor: '#007bff',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'success',
                        position: 'top-right',
                    });
                    $('#customer_account_change_phone_form').children('.account-input').children('#phone').attr('disabled','disabled');
                    $('#customer_account_change_phone_form').children('.account-input').removeClass('focus-block');
                    $('#account_mob_save').addClass('hide');
                    $('#account_mob_edit').removeClass('hide');
                    $('.change_phone').val(data.phone);
                    if(data.phone != '' && data.phone != null){
                        $('.change_phone').text('+'+data.phone);
                    }
                    else{
                        $('.change_phone').text('');
                    }

                    return false;
                }
                return false;
            }
        });

    }
    function UpdateCustomerProfile() {
        var data =  $('#customer_profile_form').serialize();
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{ route('customer.profile') }}",
            data : data,
            success : function(data){
                if(data.success == true){
                    $.toast({
                        heading: 'Success',
                        bgColor: '#007bff',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'success',
                        position: 'top-right',
                    });

                    $('.change_email').val(data.email);
                    $('.change_email').text(data.email);
                    $('.change_name').val(data.name);
                    $('.change_name').text(data.name);
                    $('.change_phone').val(data.phone);
                    if(data.phone != '' && data.phone != null){
                        $('.change_phone').text('+'+data.phone);
                    }
                    else{
                        $('.change_phone').text('');
                    }
                    return false;
                }
                else{
                     $.toast({
                        heading: 'Error',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                    });
                }
                return false;
            }
        });

    }
    function changeSupplierEmail() {
        $('.loader').removeClass('hide');
        var data =  $('#supplier_account_change_email_form').serialize();
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{ route('supplier.account') }}",
            data : data,
            success : function(data){
                $('.loader').addClass('hide');
                if(data.success == true){
                    $.toast({
                        heading: 'Success',
                        bgColor: '#007bff',
                        hideAfter: 5000,
                        bgColor: '#007bff',
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'success',
                        position: 'top-right',
                    });
                    $('#supplier_account_change_email_form').children('.account-input').children('#email').attr('disabled','disabled');
                    $('#supplier_account_change_email_form').children('.account-input').removeClass('focus-block');
                    $('#account_email_save').addClass('hide');
                    $('.change_email').val(data.email);
                    $('.change_email').text(data.email);
                    $('#account_email_edit').removeClass('hide');
                    return false;
                }
                else{
                     $.toast({
                        heading: 'Error',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                    });
                }
                return false;

            }
        });

    }
    function changeSupplierPassword() {
        var data =  $('#supplier_account_change_password_form').serialize();
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{ route('supplier.account') }}",
            data : data,
            success : function(data){
                if(data.success == true){
                    $.toast({
                        heading: 'Success',
                        bgColor: '#007bff',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'success',
                        position: 'top-right',
                    });
                    $('#supplier_account_change_password_form').children('.account-input').children('#password').attr('disabled','disabled');
                    $('#supplier_account_change_password_form').children('.account-input').removeClass('focus-block');
                    $('#supplier_account_change_password_form').children('.account-input').children('#password').val('');
                    $('#account_pass_save').addClass('hide');
                    $('#account_pass_edit').removeClass('hide');
                    return false;
                }
                return false;

            }
        });

    }
    function changeSupplierPhone() {
        var data =  $('#supplier_account_change_phone_form').serialize();
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{ route('supplier.account') }}",
            data : data,
            success : function(data){
                if(data.success == true){
                    $.toast({
                        heading: 'Success',
                        bgColor: '#007bff',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'success',
                        position: 'top-right',
                    });
                    $('#supplier_account_change_phone_form').children('.account-input').children('#phone').attr('disabled','disabled');
                    $('#supplier_account_change_phone_form').children('.account-input').removeClass('focus-block');
                    $('#account_mob_save').addClass('hide');
                    $('#account_mob_edit').removeClass('hide');
                    $('.change_phone').val(data.phone);
                    if(data.phone != '' && data.phone != null){
                        $('.change_phone').text('+'+data.phone);
                    }
                    else{
                        $('.change_phone').text('');
                    }
                    return false;
                }
                return false;
            }
        });

    }
    function UpdateSupplierProfile() {
        var data =  $('#supplier_profile_form').serialize();
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{ route('supplier.profile') }}",
            data : data,
            success : function(data){
                if(data.success == true){
                    $.toast({
                        heading: 'Success',
                        bgColor: '#007bff',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'success',
                        position: 'top-right',
                    });

                    $('.change_email').val(data.email);
                    $('.change_email').text(data.email);
                    $('.change_name').val(data.name);
                    $('.change_name').text(data.name);
                    $('.change_phone').val(data.phone);
                    if(data.phone != '' && data.phone != null){
                        $('.change_phone').text('+'+data.phone);
                    }
                    else{
                        $('.change_phone').text('');
                    }


                    return false;
                }
                 else{
                     $.toast({
                        heading: 'Error',
                        hideAfter: 5000,
                        text: data.message,
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                    });
                }
                return false;
            }
        });

    }
</script>
<script type="text/javascript">

    var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '634819302439-go9j6c9slgudoffjq7e455p35lmldfg7.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('customBtn'));
    });
  };
 function attachSignin(element) {
   
  
    auth2.attachClickHandler(element, {},
        function(googleUser) {
        var profile = googleUser.getBasicProfile();
        var name  = profile.getName();
        var email  = profile.getEmail();
        var url = "{{ route('sociallogins')}}";
        var social_url = url.replace("http://", "https://");
        $('.error_login_facebook').empty();
        if(name != "" && email != ""){
             $.ajax({
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url  : social_url,
                    data : {'name': name, 'email' : email},
                    success : function(data){
                       
                        if(data.success == true){
                            if(data.approved == true){
                                 window.onbeforeunload = function(e){
                                      gapi.auth2.getAuthInstance().signOut();
                                    };
                                window.location = "{{ route('customer.dashboard')}}";
                                return false;
                            }
                            else if(data.approved == false){
                                $('.error_login_facebook').append('<div class="alert alert-success" role="alert">'+data.message+'</div>');
                                //     $.toast({
                                //     heading: 'Information',
                                //     hideAfter: 5000,
                                //     text: data.message,
                                //     showHideTransition: 'fade',
                                //     icon: 'info',
                                //     position: 'top-right',
                                // });
                             }
                             else{
                                 $('.success_login_alert').append('<div class="alert alert-success success_fade" role="alert">'+data.message+'</div>');
                                  setTimeout(function(){  $('.success_fade').fadeOut(); }, 3000);
                                //   $.toast({
                                //     heading: 'Success',
                                //     bgColor: '#007bff',
                                //     hideAfter: 5000,
                                //     text: data.message,
                                //     showHideTransition: 'fade',
                                //     icon: 'success',
                                //     position: 'top-right',
                                // });
                             }
                        }
                        return false;
                    
                    }
                });
         }else{
             $.toast({
                    heading: 'Error',
                    hideAfter: 5000,
                    text: "Something went to wrong!",
                    showHideTransition: 'fade',
                    icon: 'Error',
                    position: 'top-right',
             });
         }
       
              
        }, function(error) {
        //  alert(JSON.stringify(error, undefined, 2));
        });
  }
</script>
<script type="text/javascript">startApp();</script>
<!-- Facebook Login -->
<script>
    function fbInit(){
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '242060647187630', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });

    // Check whether the user already logged in
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            //display user data
           // getFbUserData();
        }
    });
}

// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fbLogin() {
    fbInit();

    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

// Fetch the user profile data from facebook
function getFbUserData(){
   
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
    function (response) {
        var name  = response.first_name+" "+response.last_name;
        var email  = response.email;
        var url = "{{ route('sociallogins')}}";
        var social_url = url.replace("http://", "https://");
        $('.error_login_facebook').empty();
        $('.success_login_alert').empty();
        if(name != "" && email != ""){
             $.ajax({
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url  : social_url,
                    data : {'name': name, 'email' : email},
                    success : function(data){
                        if(data.success == true){
                             if(data.approved == true){
                                 FB.logout(function(response) {
                                  // user is now logged out
                                });
                                window.location = "{{ route('customer.dashboard')}}";
                                return false;
                             }
                             else if(data.approved == false){
                                    $('.error_login_facebook').append('<div class="alert alert-success" role="alert">'+data.message+'</div>');
                             }
                             else{
                                 $('.success_login_alert').append('<div class="alert alert-success success_fade" role="alert">'+data.message+'</div>');
                                  setTimeout(function(){  $('.success_fade').fadeOut(); }, 3000);

                             }
                             
                        }
                        return false;

                    }
                });
         }else{
             $.toast({
                    heading: 'Error',
                    hideAfter: 5000,
                    text: "Something went to wrong!",
                    showHideTransition: 'fade',
                    icon: 'Error',
                    position: 'top-right',
             });
         }

   
    });
}
function onfailure(error) {
    // body...
}
function changeMsgNotify(supplier_services_id,customer_id,type) {
        $.ajax({
            type : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url  : "{{route('ReadMessages')}}",
            data : {'supplier_services_id': supplier_services_id,'customer_id':customer_id,'type':type},
            success : function(data){
                if(data.success == true){
                    if(type == 'supplier'){
                        $('.message_alert_'+customer_id).remove();
                    } else {
                        $('.message_alert_'+supplier_services_id).remove();
                    }
                    
                } else {
                     $.toast({
                    heading: 'Error',
                    hideAfter: 5000,
                    text: "Something went to wrong!",
                    showHideTransition: 'fade',
                    icon: 'Error',
                    position: 'top-right',
             });
                }
            }
        });
   
}
</script>