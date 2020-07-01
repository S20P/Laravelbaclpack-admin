@php
    $feeds = get_instagram();
@endphp
@if(isset($feeds) && $feeds != '')
<section class="instagram-feed wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
    <div class="container">
        <div class="row no-gutters">
            @foreach($feeds as $images)
            <div class="instagram-block">
                <div class="instagram-img">
                    <a target="_blank" href="{{$images['link']}}"><img src="{{$images['image']}}"></a>
                </div>
            </div>
                @endforeach
        </div>
    </div>
</section>
@endif

<footer>
    <div class="container">
        <div class="footer-content-block">
            <section class="filter-search wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <div class="filter_search">
                    <form id="filter-form-footer" class="filter-form" action="{{route('OurSuppliers')}}" method="post">
                        @csrf
                        @php
                            $locations = getLocations();
                            $services = getServiceList();
                            $events = getEventList();

                        @endphp
                        <div class="search-field-custom custom-select">
                            <select class="events" name="event_name">
                                <option value="">EVENT TYPE (ex: wedding)</option>
                                @if(isset($events) && $events != "")
                                    @foreach($events as $key=>$event)
                                        <option value="{{$event->id}}">{{$event->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="search-field-custom custom-select">
                            <select class="events" name="service_name">
                                <option value="">SERVICE TYPE (ex: catering)</option>
                                @if(isset($services) && $services != "")
                                    @foreach($services as $key=>$service)
                                        <option value="{{$service->id}}">{{$service->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                       <!--  <div class="search-field-custom"><input type="text" name="service_name"
                                                                placeholder="TYPE OF EVENT (eg: wedding)"></div>
                        <div class="search-field-custom"><input type="text" name="event_name"
                                                                placeholder="TYPE OF SERVICE (eg: catering)"></div> -->
                        <div class="search-field-custom custom-select">
                            <select class="location" name="location">
                                <option value="">SELECT LOCATION</option>
                                @if(isset($locations) && $locations != "")
                                    @foreach($locations as $key=>$location)
                                        <option value="{{$location->id}}">{{$location->location_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="search-field-custom filter-btn">
                            <button class="btn white-btn filter-search-btn" type="submit"><i class="fas fa-search"></i>
                                <span>SEARCH</span></button>
                        </div>
                    </form>
                </div>
            </section>

            <div class="d-flex footer-widgets wow fadeInUp"  data-wow-duration="0.5s" data-wow-delay="0.5s">
                <div class="single-footer-widget">
                    <div class="widget widget_links">
                        <ul>
                            <li class="footer-widget-title menu-item">Suppliers</li>
                            <li class="menu-item">
                                <a href="{{ route('BrowseSuppliers') }}"> Browse suppliers</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('BecomeSupplier') }}">Become a supplier</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('Help') }}">Help</a>
                            </li>
                  
                            <li class="menu-item">
                                <a href="{{ route('SupplierLogin')}}">Log in</a>
                            </li>
                        </ul>
                    </div>
                </div>
                @php
                    $services = getServices();
                    $events = getEvents();
                @endphp
                <div class="single-footer-widget">
                    <div class="widget widget_links">

                        @if(isset($events) && $events != '')
                            <ul>
                                <li class="footer-widget-title menu-item">Events</li>
                                @foreach($events as $event)
                                    <li class="menu-item">
                                        <a>{{$event['name']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="single-footer-widget">
                    <div class="widget widget_links">

                        @if(isset($services) && $services != '')
                        <ul>
                            <li class="footer-widget-title menu-item">Services</li>
                            @foreach($services as $service)
                            <li class="menu-item">
                                <a>{{$service['name']}}</a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="single-footer-widget">
                    <div class="widget widget_links">
                        <ul>
                            <li class="footer-widget-title menu-item">Pages</li>
                            <li class="menu-item">
                                <a href="{{ route('Blog') }}">Blogs</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('OurStory')}}">Our Story</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('Contacts')}}">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="single-footer-widget">
                    <div class="widget widget_links">
                        <ul>
                            <li class="footer-widget-title menu-item">Contents</li>
                            <li class="menu-item">
                                <a href="{{ route('Help') }}">Help</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('Faq') }}">Faq</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('SupplierTackandCare') }}">Supplier T&C</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @php
                $footers_data = getFooterDetails();
            @endphp
            <div class="footer-bottom-content wow fadeInUp"  data-wow-duration="0.5s" data-wow-delay="0.5s">
                <div class="row">
                    <div class="col-md-4">
                        <div class="widget_links">
                            <div class="footer-widget-title menu-item">PHONE</div>
                            <a href="tel:+{{$footers_data->contact_number}}">
                            @if(isset($footers_data->contact_number))
                                {{$footers_data->contact_number}}
                            @endif
                            </a>
                        </div>

                        <div class="widget_links address">
                            <div class="footer-widget-title">ADDRESS</div>
                            <p>
                                @if(isset($footers_data->address))
                                     {{$footers_data->address}}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget_links">
                            <div class="footer-widget-title menu-item">ENQUIRIES</div>
                             @if(isset($footers_data->contact_email))
                            <a href="mailto:{{$footers_data->contact_email}}" target="_top">{{$footers_data->contact_email}}</a>
                            @endif
                        </div>
                        <div class="widget_links follow">
                            <div class="footer-widget-title menu-item">FOLLOW US</div>
                            <div class="social">
                                @php
                                    $socials = getSocialDetails();
                                @endphp
                                <ul>
                                    @if(isset($socials) && $socials != '')
                                        @foreach($socials as $socialdetails)
                                            @if($socialdetails->icon != '')
                                                <li><a href="{{$socialdetails->account_url}}" target="_blank"><i class="{{$socialdetails->icon}}"></i></a></li>
                                            @else($socialdetails->image != '')
                                                <li><a href="{{$socialdetails->account_url}}"><img src="{{asset($socialdetails->image)}}"></a> </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form method="post" name="form_subscription" >
                            @csrf
                            <div class="widget_links newsletter">
                                <div class="footer-widget-title">DON’T MISS ANYTHING</div>
                                <input type="email" name="email" id="newsletter_email" class="newsletter-form-input"
                                       placeholder="Your email address">
                                <button type="submit" id="subscribe_submit" class="btn btn-sign-up"><span>SIGN UP</span></button>
                            <div>
                        </form>
                        </div>

                        </div>

                    </div>
                </div>
            </div>

</footer>
