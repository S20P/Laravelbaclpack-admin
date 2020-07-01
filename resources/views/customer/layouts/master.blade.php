
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include("inc.head")
</head>
<body>
   <div id="app" class="app">
        @include('customer.inc.nav')
        @include('customer.inc.header')
        <div class="account_dashboard">
    <div class="container">
        <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-3">
             @include('customer.inc.sidenav')

         </div>
        <!-- <div class="col-sm-12 col-md-8 col-lg-9 d-none d-md-block"> -->
        <div class="col-sm-12 col-md-8 col-lg-9">

            @include('inc.flash-message')
            @yield('content')
         </div>
        </div>
    </div>

<div>

</div>

</div>
        @include('inc.footer')
    </div>
    @include('inc.footer-scripts')
</body>
</html>