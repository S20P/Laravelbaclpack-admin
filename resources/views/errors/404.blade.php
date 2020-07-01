@extends('layouts.master',['title' => '404 Not Found'])
@section('content')
<div class="error_section">
  <div class="container">
    <div class="row text-center">
      <div class="col-12">
        <div class="error_form">
          <h1 class="gradient-pink-text">404</h1>
          <h2>Opps! PAGE NOT BE FOUND</h2>
          <p>Sorry but the page you are looking for does not exist, have been<br> removed, name changed or is temporarily unavailable.</p>
          <a href="{{route('home')}}">Back to home page</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
