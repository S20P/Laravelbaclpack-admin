
@extends('layouts.master',['title' => 'Payment'])
@section('content')

<div class="container">
    @if(isset($booking_data))
        @php
            $site = getFooterDetails();
        @endphp
   
	<div class="card-container">
      <div class="container">
    <div class="row">
        <div class="col-md-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    <form role="form" action="{{ url('payform/stripe') }}" method="post" class="require-validation form-horizontal"
                          data-cc-on-file="false"
                          data-stripe-publishable-key="{{ $site->stripe_key }}"
                          id="payment-form">
                        @csrf
                         <input type="hidden" name="booking_id"  value="{{ $booking_data->id }}">
                         <input type="hidden" name="booking_amount"  value="{{ $booking_data->amount }}">
                         <input type="hidden" name="customer_name"  value="{{ $customer_details->name }}">
                         <input type="hidden" name="customer_email"  value="{{ $customer_details->email }}">
                         <input type="hidden" name="customer_id"  value="{{ $customer_details->id }}">


                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card-new required'>
                                <label class='control-label'>Name on Card</label> <input
                                        class='form-control card-new' name="payer_name" size='50' type='text'>
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card-new required'>
                                <label class='control-label'>Card Number</label> <input
                                        autocomplete='off' class='form-control card-number' size='50'
                                        type='number'>
                            </div>
                        </div>

                        <div class='form-row row payment-block'>
                            <div class='col-xs-4 form-group cvv required'>
                                  <label class='control-label'>CVV</label> <input autocomplete='off'
                                                                                class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                                                type='number' oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "3">
                            </div>
                            <div class='col-xs-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                        class='form-control card-expiry-month' placeholder='MM' size='2'
                                        type='number' oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "2"> 
                            </div>
                            <div class='col-xs-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                        class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                        type='number' oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "4">
                            </div>
                        </div>
                        <!-- <div class='form-row row'>
                            <div class='col-xs-12 form-group card-new'>
                                <label class='control-label'>Coupon Code</label> 
                                        <input  class='form-control card-new' type=text size="6" id="coupon" name="coupon_code"  size='50'/>
                                      <span id="msg"></span>
                            </div>
                        </div> -->


                        <div class="form-row">
                             <div class="col-md-12">
                                <div class="form-control total white-btn">
                                   Total:
                                   <span class="amount">{{ $site->currency_symbol  }}{{ number_format($booking_data->amount,2) }}</span>
                                </div>
                         </div>
                 	    </div>
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <button class="form-control btn btn-success submit-button" type="submit">Pay Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('page_plugin_script')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    $(function() {
        var $form         = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {
             $('.submit-button').attr('disabled','disabled');
            var $form         = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]','input[type=number]',
                    'textarea'].join(', '),
                $inputs       = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid         = true;
                 $('.submit-button').removeAttr('disabled');
            $errorMessage.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    $('.submit-button').removeAttr('disabled');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }

        });

        function stripeResponseHandler(status, response) {
           // $('.submit-button').removeAttr('disabled');
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .children('.alert-danger')
                    .text(response.error.message);
                    $('.submit-button').removeAttr('disabled');
            } else {
                
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $('.loader').removeClass('hide');

                $form.get(0).submit();
            }
        }

       
  $('#coupon').change(function(){
    requestData = "coupon_code="+$('#coupon').val();
    var coupon_code = $('#coupon').val();
    $.ajax({
      type: "GET",
      url: "{{route('validate-coupon')}}/"+coupon_code,
      data: requestData,
      success: function(response){
          console.log("coupen-response",response);
        if (response.success==true) {
          $('#msg').html('<div class="alert-success">Valid Code!</div>');
        } else {
          $('#msg').html('<div class="alert-danger">Invalid Code!</div>');
        }
      }
    });
  });
    });
</script>
@endsection
