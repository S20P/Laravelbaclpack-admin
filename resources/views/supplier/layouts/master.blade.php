<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include("inc.head")
</head>
<body>
   <div id="app" class="app">
        @include('supplier.inc.nav')
        @include('supplier.inc.header')
        <div class="account_dashboard">
    <div class="container">
        <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-3">
             @include('supplier.inc.sidenav')
         </div>
        <div class="col-sm-12 col-md-8 col-lg-9">
            @include('supplier.inc.errors')
            @yield('content')
         </div>
        </div>
    </div>
</div>
        
        @include('inc.footer')
    </div>
    @include('inc.footer-scripts')
</body>
</html>