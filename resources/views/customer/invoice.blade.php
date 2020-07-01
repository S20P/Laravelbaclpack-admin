@extends('layouts.master',['title' => 'Invoice'])
    @section('content')

<div class="invoice-form">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if(isset($booking) && $booking != '')
                    @php
                        $site = getFooterDetails();
                    @endphp
                <div class="card-body p-0">
                    <div class="row p-md-5 p-4">
                        <div class="col-md-6 logo-invoice">
                            @if(isset($site->logo2) && $site->logo2 != "")
                            <a href="{{ route('home') }}"><img src="{{ asset($site->logo2) }}" alt="Logo"></a>
                            @else
                                <a href="{{ route('home') }}"><img src="{{asset('images/logo-BLACK.png')}}" alt="Logo"></a>
                            @endif
                        
                        </div>

                        <div class="col-md-6 text-right">
                            <p class="font-weight-bold mb-1">Invoice #{{$booking->booking_id}}</p>
                            <p class="">Due to: {{$booking->booking_date}}</p>
                        </div>
                    </div>

             <!--        <hr class="my-5"> -->

                    <div class="row p-md-5 p-4">
                        <div class="col-md-6">
                            <p class="font-weight-bold mb-4">Client Information</p>
                            <p class="mb-1">{{$booking->cname}}, </p>
                        </div>

                        <div class="col-md-6 text-right">
                            <p class="font-weight-bold mb-4">Supplier Details</p>
                            <p class="mb-1"><span class="">Supplier: </span> {{$booking->sname}}</p>
                            @if(isset($booking->service_name))
                                <p class="mb-1"><span class="">Service: </span> {{$booking->service_name}}</p>
                            @endif
                            @if(isset($booking->business_name))
                                <p class="mb-1"><span class="">Business: </span> {{$booking->business_name}}</p>
                            @endif
                             @if($booking->email != "")
                                <p class="mb-1"><span class="">Email: </span> {{$booking->email}}</p>
                            @endif
                            @if($booking->phone != "")
                                <p class="mb-1"><span class="">Phone: </span> {{$booking->phone}}</p>
                            @endif
                            @if($booking->facebook_title != "")
                            <p class="mb-1"><span class="">Facebook: </span> <a href="{{$booking->facebook_link}}"></a>{{$booking->facebook_title}}</p>
                            @endif
                            @if($booking->instagram_title != "")
                            <p class="mb-1"><span class="">Instagram: </span> <a href="{{$booking->instagram_link}}"></a><span>@</span>{{$booking->instagram_title}}</p>
                            @endif
                           
                        </div>
                    </div>

                    <div class="row p-md-5 p-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Service Name</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Event Name</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Event Address</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Unit Cost</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$booking->booking_id}}</td>
                                        <td>{{$booking->event_name}}</td>
                                        <td>{{$booking->service_name}}</td>
                                        <td>{{$booking->event_address}}</td>
                                        <td>{{$site->currency_symbol}}{{number_format($booking->amount,2)}}</td>
                                        <td>{{$site->currency_symbol}}{{number_format($booking->amount,2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>

                    <div class="d-flex flex-row-reverse  p-md-5 p-4 custom-h2">
                        <div class="py-3 text-right">
                            <div class="mb-2">Grand Total</div>
                            <div class="h2 font-weight-light">{{$site->currency_symbol}}{{number_format($booking->amount,2)}}</div>
                        </div>
                         <div class="py-3 px-3 px-md-5 text-right">
                            <div class="mb-2">Sub - Total amount</div>
                            <div class="h2 font-weight-light">{{$site->currency_symbol}}{{ number_format($booking->amount,2)}}</div>
                        </div>
                    </div>
                    <div class="pay-button p-2 p-md-5">
                        <form method="post" action="{{route('customer.payment')}}">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
                            @if(isset($user_id) && $user_id != "")
                            		@if($booking->booking_status == 0)
                            		<button class="btn common-btn" type="submit">Pay</button>
                            		@else
			                          <div class="alert-warning" role="alert">
			                          This invoice is already paid.
			                         </div>
                            		@endif
                                    
                            @endif
                        </form>
                    </div>
                </div>
                @else
                    <div>
                         <div class="alert-warning" role="alert">
                          No Invoice Found...
                        </div>
                        
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
