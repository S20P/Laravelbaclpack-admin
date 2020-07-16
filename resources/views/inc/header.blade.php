<div class="loader hide">
    <div class="loading">
        <img src="{{asset('images/loader.png')}}">
    </div>
</div>
  @php
    $footers_data = getFooterDetails();
  @endphp
<header>

    <div class="container">
         <div class="row align-items-center">
                <div class="col-xl-4 col-sm-4 col-lg-3 logo-box">
                    <div class="logo">
                        @if(isset($footers_data->logo1))
                            <a href="{{ route('home') }}"><img src="{{ asset($footers_data->logo1) }}" alt="Logo"></a>
                        @else
                            <a href="{{ route('home') }}"><img src="{{ asset('images/logo.svg') }}" alt="Logo"></a>
                        @endif
                    </div>
                </div>
                <div class="col-xl-8 col-sm-8 col-lg-9 header-navigation header-right">
                <div class="main_menu">
                    <nav>
                        <ul>
                        @if(!Auth::guard('supplier')->user())
                                <li>
                                    <a class="browse_suppliers" href="{{ route('BrowseSuppliers') }}">BROWSE SUPPLIER</a>
                                </li>
                                <li>
                                    <a class="becomesupplier" href="{{ route('BecomeSupplier') }}">BECOME A SUPPLIER</a>
                                </li>
                                @endif
                                <li>
                                    <a class="help_page" href="{{ route('Help') }}">HELP</a>
                                </li>
                        </ul>
                    </nav>
                </div>
                    <div class="header-cta-btn">
                        @if(Auth::guard('supplier')->user() || Auth::guard('customer')->user())
                      
                        @if(Auth::guard('supplier')->user())
                        <a href="{{ route('supplier.dashboard') }}"   class="btn sidenav-item__link btn-link header-btn">  <span class="title">My Account</span>
                         </a>
                         @endif
                         @if(Auth::guard('customer')->user())
                         <a href="{{ route('customer.dashboard') }}"   class="btn sidenav-item__link btn-link header-btn">  <span class="title">My Account</span>
                         </a>
                         @endif

                                <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       <span> {{ __('Logout') }}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                <a class="sign-up header-btn" href=""><span>Sign up</span></a>
                        <a class="login header-btn" href=""><span>Login</span></a>
                                @endif

                    </div>
                    <div class="burger-menu menu-collapsed">
                        <div class="nav-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <nav class="menu-items">
                            <div class="close-icon menu-close">
                                     <i class="fal fa-times"></i>              
                            </div>
                            <ul>
                            @if(!Auth::guard('supplier')->user())
                                <li><a class="browse_suppliers" href="{{ route('BrowseSuppliers') }}">BROWSE SUPPLIERS</a></li>
                                <li><a class="becomesupplier" href="{{ route('BecomeSupplier') }}">BECOME A SUPPLIER</a></li>
                                @endif

                                <li><a class="our_story" href="{{ route('OurStory') }}">OUR STORY</a></li>
                                <li><a class="our_suppliers" href="{{route('OurSuppliers')}}">BOOK AN EVENT</a></li>
                                <li><a class="contact_us" href="{{route('Contacts')}}">CONTACTS</a></li>
                                <li><a class="blog_page" href="{{ route('Blog') }}">BLOG</a></li>
                                <li><a class="help_page" href="{{ route('Help') }}">HELP</a></li>
                                <li><a class="faq_page" href="{{ route('Faq') }}">FAQ’S</a></li>
                            <div class="menu-nav-btn">
                                @if(Auth::guard('supplier')->user() || Auth::guard('customer')->user())
                                @if(Auth::guard('supplier')->user())
                        <a href="{{ route('supplier.dashboard') }}"   class="btn black-btn">  <span class="title">My Account</span>
                         </a>
                         @endif
                         @if(Auth::guard('customer')->user())
                         <a href="{{ route('customer.dashboard') }}"   class="btn black-btn">  <span class="title">My Account</span>
                         </a>
                         @endif
                                <a class="btn black-btn" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       <span> {{ __('Logout') }} </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <button type="submit" class="btn black-btn sign-up"><span>SIGN UP</span></button>
                                <button type="submit" class="btn black-btn login"><span>LOGIN</span></button>
                                @endif
                            </div>
                            </ul>
                            <div class="menu-nav-link">
                                <ul>
                                    <!-- <li>
                                        <a class="help_page" href="{{ route('Help') }}">USER T&C</a>
                                    </li> -->
                                    <li>
                                        <a class="tak_care_page" href="{{ route('SupplierTackandCare') }}">SUPPLIER T&C</a>
                                    </li>
                                    <!-- <li>
                                        <a class="help_page"  href="{{ route('Help') }}">T&C</a>
                                    </li> -->
{{--                                    <li>--}}
{{--                                        <a href="">PRIVACY POLICY </a>--}}
{{--                                    </li>--}}
                                </ul>
                            </div>
                        </nav>
                        <div class="offcanvas-overly"></div>

                    </div>
    </div>
</header>
<?php 
$customer_loged_id  = "null";
 if(Auth::guard('customer')->user())
{
$customer_loged_id = Auth::guard('customer')->user()->id;
}
?>
