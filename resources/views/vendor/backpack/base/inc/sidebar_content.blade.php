<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li class="nav-title">First-Party Packages</li>



<li class="nav-item nav-dropdown">  
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-truck"></i>Suppliers Manage</a>
    <ul class="nav-dropdown-items">
    <li class='nav-item'><a class='nav-link' href="{{ backpack_url('supplier') }}"><i class='nav-icon fa fa-industry'></i> Suppliers</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('supplier_services') }}'><i class='nav-icon fa fa-sign-language'></i> Supplier services</a></li>
    <!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('supplierdetailsslider') }}'><i class='nav-icon fa fa-question'></i> Supplier Details Sliders</a></li> -->
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('supplierreviews') }}'><i class='nav-icon fa fa-heart-o'></i> Supplier Reviews</a></li>
     </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('services') }}'><i class='nav-icon fa fa-sitemap'></i> Services</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('events') }}'><i class='nav-icon fa fa-th'></i> Events</a></li>
   
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('customer') }}'><i class='nav-icon fa fa-user'></i> Customers</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('messanger') }}'><i class='nav-icon fa fa-envelope'></i> Messangers</a></li>

<li class="nav-item nav-dropdown">  
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-object-group"></i>Modules Manage</a>
    <ul class="nav-dropdown-items">
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('slidermodule') }}'><i class='nav-icon fa fa-sliders'></i> Slider</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('socialmediamodule') }}'><i class='nav-icon fa fa-share-alt-square'></i> Social Media</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('howitwork') }}'><i class='nav-icon fa fa-question'></i> How It Works</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('testimonial') }}'><i class='nav-icon fa fa-commenting-o'></i> Testimonials</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('location') }}'><i class='nav-icon fa fa-map-marker'></i> Locations</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('faqs') }}'><i class='nav-icon fa fa-info-circle'></i> Faqs</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('help') }}'><i class='nav-icon fa fa-question'></i> Helps</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('gallerymodule') }}'><i class='nav-icon fa fa-picture-o'></i> Gallery</a></li>
     </ul>
</li>
<li class="nav-item nav-dropdown">  
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-plus-square-o"></i>Content</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('pages') }}"><i class="nav-icon fa fa-file-o"></i> <span>Pages</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('articles') }}"><i class="nav-icon fa fa-newspaper-o"></i> <span>Articles</span></a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('articlecategory') }}'><i class='nav-icon fa fa-bars'></i> Article Categories</a></li>
      <li class='nav-item'><a class='nav-link' href='{{ backpack_url('our_story') }}'><i class='nav-icon fa fa-book'></i> Our stories</a></li>
    </ul>
</li>

<!-- <li class="nav-item nav-dropdown">  
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cogs"></i> Settings</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('/') }}"><i class="nav-icon fa fa-credit-card"></i> <span>Payment gateway</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('/') }}"><i class="nav-icon fa fa-flag-o"></i> <span>Notifications</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('/') }}"><i class="nav-icon fa fa-envelope-o"></i> <span>Email SMTP</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('/') }}"><i class="nav-icon fa fa-cog"></i> <span>Other</span></a></li>
    </ul>
</li> -->
  
<!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('/') }}'><i class='nav-icon fa fa-bookmark'></i> Booking or quote</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('/') }}'><i class='nav-icon fa fa-exchange'></i> Transaction detail</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('/') }}'><i class='nav-icon fa fa-sticky-note-o'></i> Reports</a></li>-->

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-sticky-note-o"></i> Reports</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('reports/supplier') }}"><i class="nav-icon fa fa-files-o"></i> <span>Suppliers Payment</span></a></li>

         <li class="nav-item"><a class="nav-link" href="{{ backpack_url('reports/analytics') }}"><i class="nav-icon fa fa-files-o"></i> <span>Analytics Report</span></a></li>

  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('reports/industry_stats_report') }}"><i class="nav-icon fa fa-files-o"></i> <span>Industry stats Reports</span></a></li>
     </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('analytics') }}'><i class='nav-icon fa fa-eye'></i> Analytics logs</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('email_template') }}'><i class='nav-icon fa fa-send'></i>Email Template</a></li>
<!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('supplier_assign_events') }}'><i class='nav-icon fa fa-question'></i> Supplier_assign_events</a></li> -->
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('bookings') }}'><i class='nav-icon fa fa-bookmark'></i> Bookings</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('payments') }}'><i class='nav-icon fa fa-credit-card'></i> Payments</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('sitedetails') }}'><i class='nav-icon fa fa-wrench'></i> SiteDetails</a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cogs"></i> Advanced</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon fa fa-files-o"></i> <span>File manager</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('backup') }}"><i class="nav-icon fa fa-hdd-o"></i> <span>Backups</span></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('log') }}"><i class="nav-icon fa fa-terminal"></i> <span>Logs</span></a></li>
    </ul>
</li>
<li class='nav-item'><a  target="_blank" class='nav-link' href='https://app.smartsupp.com/app/sign/in'><i class='nav-icon fa fa-comments'></i> Smartsupp Communications</a></li>
<!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('supplierbankingdetails') }}'><i class='nav-icon fa fa-question'></i> SupplierBankingDetails</a></li> -->

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('emailtemplatesdynamic') }}'> <i class="nav-icon fa fa-envelope-open-o" aria-hidden="true"></i> Email Templates Manage</a></li>
<!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('supplier_assign_services') }}'><i class='nav-icon fa fa-question'></i> Supplier_assign_services</a></li> -->