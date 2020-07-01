@extends('layouts.master',['title' => 'Account'])
    @section('content')


<section class="account-information">
    <div class="container">
        <div class="row">
         <div class="col-sm-12 col-md-3 col-lg-3 profile-picture">
            <div class="profile">
                <img src="images/profile-img.jpg">
            </div>
         </div>
        <div class="col-sm-12 col-md-9 col-lg-9 contact-informations">

            <div class="contact-area">                
                <div class="single-contact-box">
                    <h1>Catering Dublin</h1>
                    <a href="tel:353 123 456 789">+353 123 456 789</a>
                    <a href="mailto:contact@company.ie">contact@company.ie</a>
                </div>

                <div class="account-nav">
                         <a class="common-btn" href="">LOG OUT</a>
                </div>

            </div>

           
         </div>
        </div>
    </div>
</section>


<section class="breadcrumb-block">
    <div class="container">
        <ul class="breadcrumb-nav">
            <li>Home</li>
            <li><a href="">SUPPLIERS T&C’S</a></li>
        </ul>
    </div>
</section>


<div class="account_dashboard">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <div class="dashboard_tab_button">
                    <ul role="tablist" class="nav flex-column dashboard-list">
                        <li><a href="#dashboard" data-toggle="tab" class="nav-link active">ACCOUNT<i
                                class="fal fa-angle-right"></i></a></li>
                        <li><a href="#orders" data-toggle="tab" class="nav-link">PROFILE<i
                                class="fal fa-angle-right"></i></a></li>
                        <li><a href="#downloads" data-toggle="tab" class="nav-link">BOOKING<i
                                class="fal fa-angle-right"></i></a></li>
                        <li><a href="#address" data-toggle="tab" class="nav-link">PAYMENTS<i
                                class="fal fa-angle-right"></i></a></li>
                        <li><a href="#account-details" data-toggle="tab" class="nav-link">ANALYTICS<i
                                class="fal fa-angle-right"></i></a></li>
                        <li><a href="#messenger" data-toggle="tab" class="nav-link">MESSENGER<i
                                class="fal fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <!-- Tab panes -->
                <div class="tab-content dashboard_content">
                    <div class="tab-pane fade show active" id="dashboard">
                        <h2 class="gradient-pink-text">Account</h2>

                        <div class="list-accordion">
                            <div class="list-title">
                                <h5>CHANGE ACCOUNT EMAIL</h5>
                                <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="account list-accordion-content" style="display: none;">
                                <div class="list-accordion-content-box">
                                    <div class="account-input">
                                        <input type="text" name="" placeholder="contact@company.ie">
                                        <button class="btn common-btn" type="submit">
                                            <span><img src="images/search-icon.svg"></span> EDIT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-accordion">
                            <div class="list-title">
                                <h5>CHANGE ACCOUNT EMAIL</h5>
                                <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="account list-accordion-content" style="display: none;">
                                <div class="list-accordion-content-box">
                                    <div class="account-input">
                                        <input type="text" name="" placeholder="contact@company.ie">
                                        <button class="btn common-btn" type="submit">
                                            <span><img src="images/search-icon.svg"></span> EDIT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-accordion">
                            <div class="list-title">
                                <h5>CHANGE ACCOUNT PASSWORD</h5>
                                <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="account list-accordion-content" style="display: none;">
                                <div class="list-accordion-content-box">
                                    <div class="account-input">
                                        <input type="text" name="" placeholder="contact@company.ie">
                                        <button class="btn common-btn" type="submit">
                                            <span><img src="images/search-icon.svg"></span> EDIT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-accordion">
                            <div class="list-title">
                                <h5>CHANGE PHONE NUMBER</h5>
                                <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="account list-accordion-content" style="display: none;">
                                <div class="list-accordion-content-box">
                                    <div class="account-input">
                                        <input type="text" name="" placeholder="contact@company.ie">
                                        <button class="btn common-btn" type="submit">
                                            <span><img src="images/search-icon.svg"></span> EDIT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-accordion">
                            <div class="list-title">
                                <h5>UPDATE PAYMENT INFORMATION</h5>
                                <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="account list-accordion-content" style="display: none;">
                                <div class="list-accordion-content-box">
                                    <div class="account-input">
                                        <input type="text" name="" placeholder="contact@company.ie">
                                        <button class="btn common-btn" type="submit">
                                            <span><img src="images/search-icon.svg"></span> EDIT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-accordion">
                            <div class="list-title">
                                <h5>BILLING DETAILS</h5>
                                <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="account list-accordion-content" style="display: none;">
                                <div class="list-accordion-content-box">
                                    <div class="account-input">
                                        <input type="text" name="" placeholder="contact@company.ie">
                                        <button class="btn common-btn" type="submit">
                                            <span><img src="images/search-icon.svg"></span> EDIT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="orders">
                        <h2 class="gradient-pink-text">Profile</h2>

                    </div>
                    <div class="tab-pane fade" id="downloads">
                        <h2 class="gradient-pink-text">Booking</h2>

                    </div>
                    <div class="tab-pane" id="address">
                        <h2 class="gradient-pink-text">Payments</h2>
                    </div>
                    <div class="tab-pane fade" id="account-details">
                        <h2 class="gradient-pink-text">Analytics</h2>
                    </div>
                    <div class="tab-pane fade" id="messenger">
                        <h2 class="gradient-pink-text">Messenger</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    @endsection
