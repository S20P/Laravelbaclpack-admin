<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include("inc.head")
</head>
@if (\Request::is('/') || \Request::is('/home')) 
<body class="home">
@else
<body class="{{$view_name}}">
@endif
        @include('inc.header')
        <div class="content">
        @include('inc.flash-message')
            @yield('content')
        </div>
        @include('inc.footer')
        @include('inc.forms')
    @include('inc.footer-scripts')
    @yield('footer_scripts')
</body>
</html>