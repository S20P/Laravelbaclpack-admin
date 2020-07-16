 <!-- Meta Tags -->
 
 <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no user-scalable=no,  maximum-scale=1.0, minimum-scale=1.0" >
<meta http-equiv="X-UA-Compatible" content="ie=edge">
{!! MetaTag::tag('title') !!}
{!! MetaTag::tag('description') !!}
<meta name="author" content="">
 <!-- CSRF Token -->
 
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <script src="https://apis.google.com/js/api:client.js"></script>
 <!-- <title>Home | Party Perfect</title> -->
 <title>
        @isset($title)
            {{ $title }} | 
        @endisset
        Party Perfect
    </title>
 <!-- favicon -->
 <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">

<!-- Bootstrap core CSS -->
<!-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,700i&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"/>

 	<link rel="stylesheet" href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->

<link rel="stylesheet" href="{{ asset('css/jquery.toast.css') }}" rel="stylesheet">
<!-- Smartsupp Live Chat script -->
<!-- <script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '9e578857797049d5ca9df51fa43ee686b9039775';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script> -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154734882-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-154734882-1');
</script>


  
  
