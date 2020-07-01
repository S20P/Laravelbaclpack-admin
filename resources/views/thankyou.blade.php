@extends('layouts.master',['title' => 'Thank You'])
    @section('content')
    <div class="thankyou_block">
        <div class="container">
            <div class="jumbotron text-center">
                <h1 class="display-3">Thank You!</h1>
                <p class="lead first"><strong>Please check your email</strong>, Payment is successfully done.</p>
                <p>
                Having trouble? <a href="{{ route('Contacts')}}">Contact us</a>
                </p>
                <p class="lead button">
                    <a class="btn btn-primary btn-sm" href="{{ route('home')}}" role="button">Continue to homepage</a>
                </p>
            </div>
        </div>
    </div>
@endsection