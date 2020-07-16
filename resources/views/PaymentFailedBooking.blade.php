@extends('layouts.master',['title' => 'Payment Fail'])
    @section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="payerror-sec">
                <i class="warning icon"></i>
                <div class="content">
                    <div class="header">
                        Oops! Something went wrong.
                    </div>
                    <p>Your order is not completely done</p>
                </div>
                
                @if(isset($booking_id))
                         <form method="post" action="{{route('customer.payment')}}">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{$booking_id}}">
                            <button class="btn common-btn" type="submit"> Please Try again </button>
                        </form>
              @else
                <a href="{{route('home')}}"> 
                    <span class="ui large teal submit fluid button"> Please Try again</span>
                </a>
              @endif

            </div>
        </div>
    </div>
</div>
@endsection