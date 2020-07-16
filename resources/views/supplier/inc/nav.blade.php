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
                                <!-- <li>
                                    <a href="{{ route('BrowseSuppliers') }}">BROWSE SUPPLIER</a>
                                </li>
                                <li>
                                    <a href="{{ route('BecomeSupplier') }}">BECOME A SUPPLIER</a>
                                </li> -->
                                <li>
                                    <a href="{{ route('Help') }}">HELP</a>
                                </li>
                       </ul>
                    </nav>
                </div>
                    <div class="header-cta-btn">
                    <a href="" target="_self"  class="btn sidenav-item__link btn-link header-btn">  <span class="title">My Account</span>
                     </a>
                        <a class="login header-btn" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      <span>  {{ __('Logout') }}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
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
                                <!-- <li><a href="{{ route('BrowseSuppliers') }}">BROWSE SUPPLIERS</a></li> -->
                                <li><a href="{{ route('OurStory') }}">OUR STORY</a></li>
                                <!-- <li><a href="{{route('OurSuppliers')}}">BOOK AN EVENT</a></li> -->
                                <li><a href="{{route('Contacts')}}">CONTACTS</a></li>
                                <li><a href="{{ route('Blog') }}">BLOG</a></li>
                                <li><a href="{{ route('Help') }}">HELP</a></li>
                                <li><a href="{{ route('Faq') }}">FAQ’S</a></li>
                            <div class="menu-nav-btn">
                                @if(Auth::guard('supplier')->user())
                        <a href="{{ route('supplier.dashboard') }}"   class="btn black-btn">  <span class="title">My Account</span>
                         </a>                        
                       
                                <a class="btn black-btn" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       <span> {{ __('Logout') }} </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                            </ul>
                            <div class="menu-nav-link">
                                <ul>
                                    <li>
                                        <a href="{{ route('Help') }}">USER T&C</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('SupplierTackandCare') }}">SUPPLIER T&C</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('Help') }}">T&C</a>
                                    </li>
{{--                                    <li>--}}
{{--                                        <a href="">PRIVACY POLICY </a>--}}
{{--                                    </li>--}}
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="offcanvas-overly"></div>
    </div>
</header>

        