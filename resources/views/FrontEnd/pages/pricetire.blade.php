
@extends('layouts.master',['title' => 'Payment'])
@section('content')

  <div class="container">
    @if(isset($selectprice) && isset($request) && $selectprice != "" && $request != "")
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
            <p class="subscription_pay_title"> You have selected subscription of <b>{{ $selectprice['name'] }}</b> for one month period of time. Please pay this amount for use this service</p>
            <form role="form" action="{{ url('payform/stripe') }}" method="post" class="require-validation form-horizontal"
                  data-cc-on-file="false"
                  data-stripe-publishable-key="{{ $site->stripe_key }}"
                  id="payment-form">
              @csrf

             
              <input type="hidden" name="service_id"  value="{{ $selectprice['id'] }}">
              <input type="hidden" name="service_amount"  value="{{ $selectprice['price'] }}">
              <input type="hidden" name="name" value="{{$request['name']}}">
              <input type="hidden" name="business_name" value="{{$request['business_name']}}">
              <input type="hidden" name="email" value="{{$request['email']}}">
              <input type="hidden" name="phone" value="{{$request['phone']}}">
              <input type="hidden" name="password" value="{{$request['password']}}">
              @foreach($request['events'] as $events)
                <input type="hidden" name="events[]" value="{{$events}}">
              @endforeach
              @foreach($request['location'] as $location)
                <input type="hidden" name="location[]" value="{{$location}}">
              @endforeach
              <input type="hidden" name="service_description" value="{{$request['service_description']}}">
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
                <div class='col-xs-4 form-group cvc required'>
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
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-control total white-btn">
                    Total:
                    <span class="amount">{{ $site->currency_symbol  }}{{ number_format($selectprice['price'],2) }}</span>
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
      @else
        @php
          redirect('home');
        @endphp
      @endif
  </div>
@endsection

@section('page_plugin_script')
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

  <script type="text/javascript">
    $(function() {
      var $form    = $(".require-validation");
      $('form.require-validation').bind('submit', function(e) {
        $('.submit-button').attr('disabled','disabled');
        var $form  = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                  'input[type=text]', 'input[type=file]', 'input[type=number]',
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
            e.preventDefault();
            $('.submit-button').removeAttr('disabled');
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
       
        if (response.error) {
          $('.error')
                  .removeClass('hide')
                  .find('.alert-danger')
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

    });
  </script>
@endsection
