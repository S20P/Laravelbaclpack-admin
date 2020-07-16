@extends('supplier.layouts.master',['title' => 'My Account'])
@section('content')


   
<style>
/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
  width:100%;
}


.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>



<input type="hidden" class="supplier_id" value="{{$user_details['id']}}">

<div class="tab-content dashboard_content">
   <div class="tab-pane fade show active" id="dashboard">
      <h2 class="gradient-pink-text">Account</h2>
      <div class="list-accordion">
         <div class="list-title">
            <h5>CHANGE ACCOUNT EMAIL</h5>
            <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
         </div>
         <div class="account list-accordion-content">
            <div class="list-accordion-content-box">
              
               <form method="POST" name="supplier_account_change_email_form"  id="supplier_account_change_email_form" >
                                      @csrf
                                    <div class="account-input">
                                     <input type="hidden" name="old_email" value="{{ old('email',$user_details['email']) }}">
                                        <input id="email" type="email" class="@error('email') is-invalid @enderror change_email" disabled name="email" value="{{isset($user_details['email'])?$user_details['email']:''}}"  required autocomplete="email" placeholder="contact@company.ie">
                                        <button class="btn common-btn" id="account_email_edit" type="button">
                                           <i class="fal fa-edit"></i> EDIT
                                        </button>
                                        <button class="btn common-btn hide" id="account_email_save" type="submit">
                                            <i class="fal fa-check"></i> SAVE
                                        </button>
                                    </div>
                                    </form>
            </div>
         </div>
      </div>
      <div class="account list-accordion">
         <div class="list-title">
            <h5>CHANGE ACCOUNT PASSWORD</h5>
            <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
         </div>
         <div class="list-accordion-content">
            <div class="list-accordion-content-box">
               <form method="POST"  name="supplier_account_change_password_form" id="supplier_account_change_password_form">
                  @csrf
                  <div class="account-input row password_section">

                     <input id="password" type="password" disabled class="@error('password') is-invalid @enderror col-md-12" placeholder="Your Password" name="password">
                    
                     <input id="password-confirm" type="password" disabled class="cus_con_pass col-md-12" name="password_confirmation" placeholder="Your Confirm Password" required autocomplete="new-password">
                    
                     <button class="btn common-btn" type="button" id="account_pass_edit">
                     <i class="fal fa-edit"></i> EDIT
                     </button>
                     <button class="btn common-btn hide" id="account_pass_save" type="submit">
                        <i class="fal fa-check"></i> SAVE
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="account list-accordion">
         <div class="list-title">
            <h5>CHANGE PHONE NUMBER</h5>
            <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
         </div>
         <div class="list-accordion-content">
            <div class="list-accordion-content-box">
               <form method="POST" name="supplier_account_change_phone_form" id="supplier_account_change_phone_form" >
                  @csrf
                  <div class="account-input">
                     <input  id="phone" type="number" disabled class="@error('phone') is-invalid @enderror change_phone" name="phone" value="{{ old('phone',$user_details->phone) }}">
                     <button class="btn common-btn" type="button" id="account_mob_edit">
                     <i class="fal fa-edit"></i> EDIT
                     </button>
                     <button class="btn common-btn hide" id="account_mob_save" type="submit">
                        <i class="fal fa-check"></i> SAVE
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
 
      
   </div>
   <div class="tab-pane fade" id="profile">
      <h2 class="gradient-pink-text">Profile</h2>
      <div class="row justify-content-center">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">

               <!-----------------------------------------------------------------------------------------------------------------
                                                      Profile Signup Form 
               ------------------------------------------------------------------------------------------------------------------>

               <form method="POST" name="supplier_profile_form" id="supplier_profile_form" enctype="multipart/form-data">
                        @csrf
                     <div class="row">
                        <div class="form-group col-sm-6">
                           <label>Name</label>
                           <input type="text" name="name" class="change_name" value="{{ old('name',$user_details->name ) }}">
                        </div>
                        <div class="form-group col-sm-6">
                           <label>Email address</label>
                           <input id="email" type="email" class="@error('email') is-invalid @enderror change_email" name="email" value="{{ old('email',$user_details->email ) }}" autocomplete="email" required>
                        </div>
                        <div class="form-group col-sm-6">
                           <label>Phone number</label>
                           <input type="number" name="phone" class="change_phone" value="{{ old('phone',$user_details->phone ) }}">
                        </div>
                        <div class="form-group col-md-12 text-center">
                           <button type="submit" class="common-btn">
                           Save
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- Supplier Services crud-->
      <div class="supplier-services-edit">
      <div class="row justify-content-center">
         <div class="col-md-12">
         
         <div class="booking_top">
      <h2 class="gradient-pink-text"><span>Supplier Services</span></h2>
         <button type="button" class="btn common-btn add-btn" id="add_supplier_service">
         <i class="fal fa-plus"></i>Add
         </button>
         </div>
            <div class="event-service">
               <div class="table-responsive">
                  <table class="table" >
                     <thead>
                        <tr>
                           <th class="" scope="col">Service</th>
                           <th class="" scope="col">Event</th>
                           <th class="" scope="col">Name of Business</th>
                           <th class="" scope="col">Price Range</th>
                           <th class="" scope="col">Location</th>
                           <th class="" scope="col">Facebook</th>
                           <th class="" scope="col">Instagram</th> 
                           <th class="" scope="col">Slider Manage</th>                     
                           <th class="EDIT" scope="col">Edit</th>
                           <th class="REMOVE" scope="col">Delete</th>
                        </tr>
                     </thead>
                     <tbody id="supplier_services_crud">
                     </tbody>
                  </table>
               </div>
            </div>
          </div>
      </div>
      </div>
      <!-- Supplier Services crud-->

   </div>
   <div class="tab-pane fade" id="downloads">
      <div class="booking_top">
      <h2 class="gradient-pink-text"><span>Booking</span></h2>
         <button type="button" class="btn common-btn add-btn" id="add_booking">
         <i class="fal fa-plus"></i>Add
         </button>
         </div>
         <div class="modal fade curdmodel"  id="booking_add_model"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="sidebar-block">
                        <div class="title-block">
                           <h2>Add</h2><a class="modal-close" data-dismiss="modal"><img width="15px" src="{{ asset('images/modal-close.svg')}}"></a>
                        </div>
               <!-----------------------------------------------------------------------------------------------------------------
                                                      Booking add Form 
               ------------------------------------------------------------------------------------------------------------------>
                        <form method="POST"  class="booking_add_form" name="booking_add">
                        @csrf
                           <div class="get-touch-btn-block">
                              <div class="form-group">
                                  <label for="booking_date">Booking Date</label>
                                 <input type="date" name="booking_date" id="booking_date" placeholder="DATE"/>
                              </div>
                              <div class="form-group">
                               <label for="supplier_services_id">Supplier Services</label>
                               <!-- <div class="custom-select"> -->
                                   <select  class="select_custom" name="supplier_services_id" id="booking_supplier_service_id">
                                     <option disabled="disabled" selected>Select supplier services</option>
                                       @if(isset($supplier_service_details) && $supplier_service_details != "")
                                             @foreach($supplier_service_details as $key=>$service_details)
                                               <option value="{{$service_details->supplier_services_id}}">{{$service_details->service_name}}</option>
                                             @endforeach
                                       @endif
                                 </select>
                           
                               <!-- </div> -->
                                <!-- <div class="add_erros"></div> -->
                              
                              </div> 
                              <div class="form-group">
                               <label for="event_id">Supplier Events</label>
                               <!-- <div class="custom-select"> -->
                                 <select class="select_custom_event" onchange="" name="event_id" id="event_id" >
                                 <option disabled="disabled" selected>Select supplier Events</option>
                                 </select>
                              <!-- </div> -->
                              <!-- <div class="add_erros_event"></div> -->
                              </div> 

                              <div class="form-group">
                              <label for="event_address">Event Venue</label>
                              <textarea name="event_address" id="event_address" cols="3" rows="3"></textarea>
                              </div>

                              
                              <div class="autocomplete">
                              <div class="form-group">
                                   <label for="customer_email">Customer Email</label>
                                    <input id="myInput" type="text" class="customer_email" name="customer_email" placeholder="CUSTOMER EMAIL">
                              </div>
                              </div>
                                   <!-- <input type="email" name="customer_email" id="customer_email" placeholder="CUSTOMER EMAIL"> -->

                                   <!-- <select  class="select_custom" name="customer_email" id="customer_email" placeholder="CUSTOMER EMAIL">
                                     <option disabled="disabled" selected>Select Customer Email</option>
                                       @if(isset($customer_email_list) && $customer_email_list != "")
                                             @foreach($customer_email_list as $key=>$customer_item)
                                               <option value="{{$customer_item->email}}">{{$customer_item->email}}</option>
                                             @endforeach
                                       @endif
                                 </select> -->

                                                        
                              <div class="form-group">
                                 <label for="amount">Amount</label>
                                 <input type="text" name="amount" placeholder="AMOUNT">
                              </div>
                              <div class="form-group">
                                  <p class="status_label">
                                 <label for="status">Status</label>
                                 </p>
                                          <div class="form-check form-check-inline">
                                             <input type="radio" class="form-check-input" id="status_1" name="status" value="pending" checked="">
                                             <label class="radio-inline form-check-label font-weight-normal" for="status_1">Pending</label>
                                          </div>   
                                          <div class="form-check form-check-inline">
                                             <input type="radio" class="form-check-input" id="status_2" name="status" value="hold">
                                             <label class="radio-inline form-check-label font-weight-normal" for="status_2">Hold</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                             <input type="radio" class="form-check-input" id="status_3" name="status" value="complete">
                                             <label class="radio-inline form-check-label font-weight-normal" for="status_3">Complete</label>
                                          </div>
                               </div>
                             
                              <input type="hidden" name="supplier_id" class="supplier_id" value="{{$user_details->id}}">
                              <button type="submit" class="btn white-btn"><span class="gradient-pink-text">Add</span></button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <div class="event-service">
         <div class="table-responsive">
            <table class="table">
               <thead>
                  <tr>
                     <th class="DATE" scope="col">DATE</th>
                     <th class="" scope="col">TYPE OF SERVICE</th>
                     <th class="" scope="col">EVENT NAME</th>
                     <th class="" scope="col">PRICE</th>
                     <th class="" scope="col">CUSTOMER NAME</th>
                     <th class="" scope="col">EVENT ADDRESS</th> 
                     <th class="" scope="col">STATUS</th>      
                     <th class="EDIT" scope="col"></th>
                     <th class="REMOVE" scope="col"></th>
                    </tr>
               </thead>
               <tbody id="booking-crud">
              
                </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="tab-pane" id="address">
      <h2 class="gradient-pink-text">Payments</h2>
      <div class="payment-main">
         <h5><i class="fas fa-eye"></i>Payment information</h5>
         <div class="row justify-content-center">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                  <form method="POST"  name="payment_transfer_info_supplier_form" class="payment_transfer_info_supplier_form">
                                @csrf
                      <input type="hidden" name="supplier_id" class="supplier_id" value="{{$user_details->id}}">
                        <div class="row">
                        <div class="form-group col-sm-6">
                              <label>Account Holder Name</label>
                              <input type="text" name="account_holder_name" value="{{isset($payment_transfer_info->account_holder_name)?$payment_transfer_info->account_holder_name:''}}">
                           </div>
                           <div class="form-group col-sm-6">
                              <label>Account Number</label>
                              <input type="number" name="account_number" value="{{isset($payment_transfer_info->account_number)?$payment_transfer_info->account_number:''}}"> 
                           </div>
                           <div class="form-group col-sm-6">
                              <label>Bank Name</label>
                              <input type="text" name="bank_name" value="{{isset($payment_transfer_info->bank_name)?$payment_transfer_info->bank_name:''}}">
                           </div>
                           <div class="form-group col-sm-6">
                              <label>Bank Address</label>
                              <textarea id="bank_address"  name="bank_address"  value="{{isset($payment_transfer_info->bank_address)?$payment_transfer_info->bank_address:''}}">{{isset($payment_transfer_info->bank_address)?$payment_transfer_info->bank_address:''}}</textarea>
                           </div>
                           <div class="form-group col-sm-6">
                              <label>IFSC</label>
                              <input id="ifsc" type="text" name="ifsc" value="{{isset($payment_transfer_info->ifsc)?$payment_transfer_info->ifsc:''}}">
                           </div>
                           <div class="form-group col-sm-6">
                              <label>IBAN</label>
                              <input id="iban" type="text" name="iban" value="{{isset($payment_transfer_info->iban)?$payment_transfer_info->iban:''}}">
                           </div>
                           <div class="form-group col-sm-6">
                              <label>Sort code</label>
                              <input id="sortcode" type="number" name="sortcode" value="{{isset($payment_transfer_info->sortcode)?$payment_transfer_info->sortcode:''}}">
                           </div>
                           <div class="form-group col-md-12 text-center">
                              <button type="submit" class="common-btn">
                             Save Payment Details
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="payment-main">
         <h5><i class="fas fa-eye"></i>Payments due</h5>
         <div class="event-service">
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                     <th class="DATE" scope="col">BOOKING DATE</th>
                     <th class="" scope="col">TYPE OF SERVICE</th>
                     <th class="" scope="col">EVENT NAME</th>
                     <th class="" scope="col">CUSTOMER NAME</th>
                     <th class="PAYMENT" scope="col">PAYMENT AMOUNT</th>
                     <th class="DATE" scope="col">PAYMENT DATE</th>
                     </tr>
                  </thead>
                  <tbody>
                  @if(isset($payment_details) && $payment_details != "" && count($payment_details)>0)
                    @foreach($payment_details as $payment_details_info)
                    @if($payment_details_info->paid_unpaid==0)
                     <tr>
                     <td data-th="DATE" class="Date_dd">
                        <p>
                           @php
                           $date = strtotime($payment_details_info->booking_date);
                           echo date('d-m-Y',$date);
                           @endphp
                           </p>
                     </td>
                     <td data-th="TYPE OF SERVICE" class="service_dd">
                        <p>{{$payment_details_info->service_name}}</p>
                     </td>
                     <td data-th="PRICE RANGE" class="range_dd">
                        <p> {{$payment_details_info->event_name}}
                        </p>
                     </td>
                     <td data-th="" class="customer_name">
                        <p>{{$payment_details_info->customer_name}}</p>
                     </td>
                     <td data-th="PAYMENT" class="payment_dd">
                           <p> € {{$payment_details_info->payment_amount}}
                           </p>
                        </td>
                        <td data-th="DATE" class="Date_dd">
                           <p>
                              @php 
                              $pay_date = strtotime($payment_details_info->payment_date);
                              echo date('d-m-Y',$pay_date);
                              @endphp
                              </p>
                        </td>
                       </tr>
                @endif
                     @endforeach
                @else
                <tr><td colspan="6" class="text-center"><p class="text-danger">Not Payments Record Found</p></td></tr>
                @endif
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="payment-main">
         <h5><i class="fas fa-eye"></i>Payment history</h5>
         <div class="event-service">
            <div class="table-responsive">
            <table class="table">
                  <thead>
                     <tr>
                     <th class="DATE" scope="col">BOOKING DATE</th>
                     <th class="" scope="col">TYPE OF SERVICE</th>
                     <th class="" scope="col">EVENT NAME</th>
                     <th class="" scope="col">CUSTOMER NAME</th>
                     <th class="PAYMENT" scope="col">PAYMENT AMOUNT</th>
                     <th class="DATE" scope="col">PAYMENT DATE</th>
                     </tr>
                  </thead>
                  <tbody>
                  @if(isset($payment_details) && $payment_details != "" && count($payment_details)>0)
                    @foreach($payment_details as $payment_details_info)
                    @if($payment_details_info->paid_unpaid==1)
                     <tr>
                     <td data-th="DATE" class="Date_dd">
                        <p>
                            @php
                           $date = strtotime($payment_details_info->booking_date);
                           echo date('d-m-Y',$date);
                           @endphp
                        </p>
                     </td>
                     <td data-th="TYPE OF SERVICE" class="service_dd">
                        <p>{{$payment_details_info->service_name}}</p>
                     </td>
                     <td data-th="PRICE RANGE" class="range_dd">
                        <p> {{$payment_details_info->event_name}}
                        </p>
                     </td>
                     <td data-th="" class="customer_name">
                        <p>{{$payment_details_info->customer_name}}</p>
                     </td>
                     <td data-th="PAYMENT" class="payment_dd">
                           <p> € {{$payment_details_info->payment_amount}}
                           </p>
                        </td>
                        <td data-th="DATE" class="Date_dd">
                           <p>
                            @php
                             $pay_date = strtotime($payment_details_info->payment_date);
                             echo date('d-m-Y',$pay_date);
                             @endphp
                           </p>
                        </td>
                       </tr>
                @endif
                     @endforeach
                @else
                <tr><td colspan="6" class="text-center"><p class="text-danger">Not Payments Record Found</p></td></tr>
                @endif
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <div class="tab-pane fade" id="account-details">
      <h2 class="gradient-pink-text">Analytics</h2>

      @if(isset($Analytic_record) && count($Analytic_record))
      <div class="row">
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-eye"></i></div>
                  <h3>{{$Analytic_record['total_impressions']}}</h3>
                  <h6 class="font-14">Number of impressions</h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-hand-pointer"></i></div>
                  <h3>{{$Analytic_record['total_clicks']}}</h3>
                  <h6 class="font-14">Number of clicks</h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-image"></i></div>
                  <h3>{{$Analytic_record['total_viewed_photo']}}</h3>
                  <h6 class="font-14">Most viewed photo</h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-question-circle"></i></div>
                  <h3>{{$Analytic_record['total_enquiries']}}</h3>
                  <h6 class="font-14">No. of enquiries through PP </h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="fas fa-mobile-alt"></i></div>
                  <h3>{{$Analytic_record['total_viewed_mobile']}}</h3>
                  <h6 class="font-14">No of people who clicked to call (mobile)</h6>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="card dash-data-card text-center">
               <div class="card-body">
                  <div class="icon-info mb-3"><i class="far fa-envelope-open"></i></div>
                  <h3>{{$Analytic_record['total_viewed_email']}}</h3>
                  <h6 class="font-14">No. of people who clicked to email/message </h6>
               </div>
            </div>
         </div>
      </div>
      <div class="row justify-content-center">
         <div class="col-md-12">
         <h2 class="gradient-pink-text">Supplier Services viewed Image</h2>
            <div class="event-service">
               <div class="table-responsive">
                  <table class="table" >
                     <thead>
                        <tr>
                           <th class="" scope="col">Total</th>
                           <th class="" scope="col">Most viewed Image</th>
                           <!-- <th class="" scope="col">Customer</th> -->
                           <th class="" scope="col">Supplier Service</th>
                           <th class="" scope="col">Event</th>
                        </tr>
                     </thead>
                     <tbody id="">
                     @foreach($Analytic_record['supplier_services_viewed_photos'] as $key => $value)
                        <tr>
                           <td>{{$value['count']}}</td>
                           <td><img src="{{$value['image_url']}}" id="most_viewed_image" width="200px"></td>
                           <!-- <td>{{$value['customer_name']}}</td>  -->
                           <td>{{$value['services_name']}}</td> 
                           <td>{{$value['event_name']}}</td> 
                        </tr>
                      @endforeach
                     </tbody>
                  </table>    
               </div>
            </div>
          </div>
      </div>
      @endif
   </div>
   <div class="tab-pane fade" id="messenger">
      <h2 class="gradient-pink-text">Messenger</h2>    
      @php
        $unread = 0;
      @endphp
      @if(isset($customers) && count($customers))
                          @foreach($customers as $key => $value)
                          @php
                              $conversation =  displayMessages($value->supplier_services_id,$value->customer_id);
                          @endphp
                          <div class="list-accordion">
                             <div class="list-title">
                                <div class="row messenger_main" onclick="changeMsgNotify('{{$value->supplier_services_id}}','{{$value->customer_id}}','supplier')">
                                   <div class="col-2 messenger_left">
                                    @if(isset($value->image))
                                      <img alt="Image placeholder" src="{{ asset($value->image) }}">
                                    @else
                                      <img alt="Image placeholder" src="{{ asset('images/avtar.png')}}">
                                    @endif
                                   </div>
                                   <div class="col-10 messenger_right">
                                      <div class="list-title">
                                         <h5>{{$value->customer_name}} : <span id="customer_message_mail">{{$value->customer_email}}</span></h5> 
                                         <p>Service : {{$value->services_name}}
                                           @php
                                          foreach($conversation as $key_count => $value_count){
                                            if($value_count->read_unread == 0 && $value_count->status == 0){
                                              $unread +=1;
                                            }
                                          }
                                       
                                          if($unread > 0){
                                             if($unread == 1){
                                              echo "<span class='message_alert_".$value->customer_id." span_message_alert'><span>".$unread."</span> New Message</span>";
                                             } else {
                                              echo "<span class='message_alert_".$value->customer_id." span_message_alert'><span>".$unread."</span> New Messages</span>";
                                             }
                                          }
                                          $unread = 0;
                                         @endphp
                                      
                                         </p>
                                        
                                         
                                         <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                                      </div>
                                   </div>
                                </div>
                             </div>
                             <div class="account list-accordion-content">
                                <div class="list-accordion-content-box">
                                   <div class="card-body">
                                   <div class="input-group">
                                         <input type="hidden"  class="service_id" value="{{$value->service_id}}">
                                         <input type="hidden"  class="service_name" value="{{$value->services_name}}">
                                         <input type="hidden" class="customer_id" value="{{$value->customer_id}}">
                                         <input type="hidden"  class="supplier_service_id" value="{{$value->supplier_services_id}}">
                                      </div>
                                      <a class="btn common-btn invoice_form_btn">
                                       invoice
                                      </a>
                                   <!-- <button type="button" class="btn common-btn invoice_form_btn" data-toggle="modal" data-target="#invoice">
                                         invoice
                                   </button>  -->
                                      @if(isset($conversation))
                                       <div class="conversion">
                                       @foreach($conversation as $key_mes => $value_mes)
                                        @if($value_mes->status == 1)
                                        <p class="right_ms">
                                         <span class="gradient-pink-text">Me : </span> {!! $value_mes->message !!}
                                         <span class="date_time_created">
                                          @php 
                                          $msg_date = strtotime($value_mes->created_at);
                                          echo date('d-m-Y',$msg_date);
                                          @endphp
                                          
                                       </span>
                                        </p>
                                        @else
                                        <p class="left_ms">
                                         <span class="gradient-pink-text"> {{$value->customer_name}} : </span> {!! $value_mes->message !!}
                                          <span class="date_time_created">
                                             @php 
                                          $msg_date = strtotime($value_mes->created_at);
                                          echo date('d-m-Y',$msg_date);
                                          @endphp
                                          </span>
                                        </p>
                                        @endif  
                                      <hr>
                                      @endforeach
                                      </div>
                                      @endif
                                      <h5 class="replytitle">Message Reply:</h5>
                                      <div class="input-group mb-3">
                                         <input type="hidden" name="customer_id" class="customer_id" value="{{$value->customer_id}}">
                                         <input type="hidden" name="supplier_services_id" class="supplier_service_id" value="{{$value->supplier_services_id}}">
                                         <textarea class="form-control message_account_reply" id="exampleFormControlTextarea1" rows="3" placeholder="Type Your Message Here..." required></textarea>
                                      </div>
                                      <a class="common-btn account_inquiry_submit">
                                      Submit
                                      </a>
                                   </div>
                                </div>
                             </div>
                          </div>
                         @endforeach
                         @else
                         <div class="error_message_block">
                           <div class="container">
                           <div class="row">
                           <div class="col-md-6 col-md-offset-3 text-center">
                              <br>
                              <p><img style="opacity: .30;" src="{{asset('images/no-message.png')}}" alt="" width="150px"></p>
                              <h4><i class="fa fa-exclamation-triangle" style="color:red"></i>
                              enquiry not found.</h4>
                           </div>
                           </div>
                           </div>
                           </div>
                        @endif   
   </div>
</div>

  <!-- Modal -->
  <div class="modal curdmodel fade" id="invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                               <div class="modal-content">
                                                  <div class="modal-body">
                                                     <div class="sidebar-block">
                                                        <div class="title-block">
                                                           <h2>Invoice</h2><a class="modal-close" data-dismiss="modal"><img  width="15px" src="{{ asset('images/modal-close.svg')}}"></a>
                                                        </div>
               <!-----------------------------------------------------------------------------------------------------------------
                                                      Send Invoice Form 
               ------------------------------------------------------------------------------------------------------------------>
                                                        <form method="POST" name="sendinvoicefrom" class="sendinvoicefrom">
                                                          @csrf
                                                           <div class="get-touch-btn-block">
                                                              <div class="form-group">
                                                                 <label for="booking_date">Booking Date</label>
                                                                 <input type="date" name="booking_date" placeholder="DATE"/>
                                                              </div>
                                                              <div class="form-group">
                                                                        <label for="service_id">Type of Service</label>
                                                                        <input type="hidden" class="service_id" name="service_id">
                                                                        <input type="text" disabled class="service_name" class="service_name">
                                                                  </div>
                                                            <div class="form-group">
                                                            <label for="event_id">Type of Event</label>
                                                             <div class="custom-select">
                                                               <select class="event_id add_invoice_select" name="event_id">
                                                                  <option disabled="disabled" selected>TYPE OF EVENT</option>
                                                                  @if(isset($Events) && $Events != "")
                                                                     @foreach($Events as $key=>$Eventsvalue)
                                                                     <option value="{{$Eventsvalue->id}}">{{$Eventsvalue->name}}</option>
                                                                     @endforeach
                                                                  @endif
                                                               </select>
                                                                
                                                            </div>
                                                            <div class="add_invoice_event"></div>
                                                         </div>
                                                         <div class="form-group">
                                                         <label for="">Event Venue</label>
                                                         <textarea name="event_address" id="event_address" cols="3" rows="3"></textarea>
                                                         </div>
                                                         <div class="form-group">
                                                         <label for="">Amount</label>
                                                         <input type="text" name="amount" class="amount" placeholder="AMOUNT">
                                                         </div>
                                                         <input type="hidden" name="customer_id" class="customer_id">
                                                         <input type="hidden" name="supplier_services_id" class="supplier_service_id">
                                                         <button type="submit" class="btn white-btn"><span class="gradient-pink-text">Send invoice</span></button>
                                                        </div>
                                                        </form>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>


  <!-- Booking Edit Model -->
  <div class="modal fade curdmodel" id="booking_edit_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="sidebar-block">
                        <div class="title-block">
                           <h2>Edit</h2><a class="modal-close" data-dismiss="modal"><img width="15px" src="{{ asset('images/modal-close.svg')}}"></a>
                        </div>

               <!-----------------------------------------------------------------------------------------------------------------
                                                      Booking Edit Form 
               ------------------------------------------------------------------------------------------------------------------>
                        <form  method="POST"  name="booking_update" class="booking_update">
                                @csrf
                           <div class="get-touch-btn-block">
                              <div class="form-group">
                                 <label for="booking_date">Booking Date</label>
                                 <input type="date" name="booking_date" class="edit_booking_date" placeholder="DATE"/>
                              </div>
                              <div class="form-group">
                               <label for="supplier_services_id">Supplier Services</label>
                                 <input type="text" disabled="disabled" readonly class="edit_supplier_services_id">
                              </div> 
                              <div class="form-group">
                               <label for="event_id">Supplier Events</label>
                               <input type="text" disabled="disabled" readonly class="edit_event_id">
                              </div> 

                              <div class="form-group">
                              <label for="event_address">Event Venue</label>
                              <textarea name="event_address" id="event_address" class="edit_event_address" cols="3" rows="3"></textarea>
                              </div>
                              <div class="form-group">
                                 <label for="amount">Amount</label>
                                 <input type="text" name="amount" placeholder="AMOUNT" class="edit_amount">
                              </div>
                              <div class="form-group">
                                  <p class="status_label">
                                 <label for="status">Status</label>
                                 </p>
                                          <div class="form-check form-check-inline">
                                             <input type="radio" class="form-check-input" id="status_1_edit" name="status_edit" value="pending">
                                             <label class="radio-inline form-check-label font-weight-normal" for="status_1">Pending</label>
                                          </div>   
                                          <div class="form-check form-check-inline">
                                             <input type="radio" class="form-check-input" id="status_2_edit" name="status_edit" value="hold">
                                             <label class="radio-inline form-check-label font-weight-normal" for="status_2">Hold</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                             <input type="radio" class="form-check-input" id="status_3_edit" name="status_edit" value="complete">
                                             <label class="radio-inline form-check-label font-weight-normal" for="status_3">Complete</label>
                                          </div>
                               </div>
                              <input type="hidden" name="booking_id" class="edit_booking_id">
                              <button type="submit" class="btn white-btn"><span class="gradient-pink-text">Update</span></button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<!-- Booking Edit Model end-->


            
<!-- Booking Delete Model -->
<div class="modal fade curdmodel"  id="confirm-delete-booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="sidebar-block">
                        <div class="title-block">
                           <h2>Confirm Delete</h2><a class="modal-close" data-dismiss="modal"><img width="15px" src="{{ asset('images/modal-close.svg')}}"></a>
                        </div>
                        <p>You are about to delete one track, this procedure is irreversible.</p>
                           <p>Do you want to proceed?</p>
                           <div class="modal-footer">
                           <form method="POST" id="delete_booking_form" class="delete_booking_form delete_confirm_from">
                               @csrf
                               <input type="hidden" class="booking_deleted_id">
                           <button type="button" class="btn white-btn btn-ok" data-dismiss="modal"><span class="gradient-pink-text">Cancel</span></button>
                           <button type="submit" class="btn  btn-danger  btn-ok"><span class="gradient-pink-text">Delete</span></button>
                           </form>  
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<!-- Booking Delete Model end-->



  <!-- Supplier-service ADD Model -->
  <div class="mobile-modal modal fade curdmodel" id="add_supplier_services_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="sidebar-block">
                        <div class="title-block">
                           <h2>Add</h2><a class="modal-close" data-dismiss="modal"><img width="15px" src="{{ asset('images/modal-close.svg')}}"></a>
                        </div>

               <!-----------------------------------------------------------------------------------------------------------------
                                                      Supplier-service ADD Form 
               ------------------------------------------------------------------------------------------------------------------>
                        <form  method="POST"  name="supplier_services_add_form" class="supplier_services_add_form">
                                @csrf
                                <input type="hidden" class="supplier_id" name="supplier_id" value="{{$user_details['id']}}">
                          <div class="get-touch-btn-block">
                         
                         <div class="row">

                           <div class="col-sm-12 col-md-6">

                           <div class="form-group">
                           <label>TYPE OF SERVICE</label>
                           <select class="services services_desktop" name="service_id" required>
                                 <option disabled="disabled" selected>TYPE OF SERVICE</option>
                                 @if(isset($Services) && $Services != "")
                                    @foreach($Services as $key=>$Servicesvalue)
                                    <option value="{{$Servicesvalue->id}}">{{$Servicesvalue->name}} ({{$currency_symbol}}{{$Servicesvalue->price}})</option>
                                    @endforeach
                                 @endif
                              </select>
                           </div>
                        </div>

                           <div class="col-sm-12 col-md-6">
                           <div class="form-group">
                           <label>TYPE OF EVENT</label>
                           <!-- <div class="custom-select"> -->
                              <select class="" name="event_id[]" multiple="" required>
                                 <option disabled="disabled" selected>TYPE OF EVENT</option>
                                 @if(isset($Events) && $Events != "")
                                    @foreach($Events as $key=>$Eventsvalue)
                                    <option value="{{$Eventsvalue->id}}">{{$Eventsvalue->name}}</option>
                                    @endforeach
                                 @endif
                              </select>
                         <!-- </div> -->
                           </div>
                          </div>


                           <div class="col-sm-12 col-md-6">
                           <div class="form-group">
                               <label for="price_range">Price Range</label>
                                    <select name="price_range" required>
                                    <option disabled="disabled" selected>Price Range</option>
                                 @if(isset($PriceRange) && $PriceRange != "")
                                    @foreach($PriceRange as $key=>$PriceRangevalue)
                                    <option value="{{$PriceRangevalue->status}}">{{$PriceRangevalue->range}} ({{$PriceRangevalue->symbol}})</option>
                                    @endforeach
                                 @endif
                              </select>
                                 
                              </div> 
                           </div>

                         <div class="col-sm-12 col-md-6">
                           <div class="form-group">
                              <label>Name of Business</label>
                              <input type="text" name="business_name">
                           </div> 
                        </div>
                              
                              <div class="col-sm-12 col-md-12">      
                           <div class="form-group">
                              <label>Description of service</label>
                              <textarea type="text" name="service_description"></textarea>
                           </div>
                        </div>

                        <div class="form-group col-sm-12 required">
                        <label>Location</label>

                        <select class="form-control" name="location[]" multiple="" >
                        <option value="">Select location</option>
                                    @if(isset($locations) && $locations != "")
                                       @foreach($locations as $key=>$location)
                                       <option value="{{$location->id}}">{{$location->location_name}}</option>
                                       @endforeach
                                    @endif 
                        </select>
                         </div>
                   

<div class="col-sm-12 col-md-6">
                           <div class="form-group">
                              <label>Facebook Link</label>
                              <input type="text" name="facebook_link" class="facebook_link">
                           </div>
                        </div>


<div class="col-sm-12 col-md-6">
                           <div class="form-group">
                              <label>Instagram Link</label>
                                    <input type="text" name="instagram_link"  class="instagram_link">
                           </div>
                        </div>
                     </div>


                     <br>
                              <button type="submit" class="btn white-btn"><span class="gradient-pink-text">Save</span></button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<!-- Supplier-service ADD Model end-->
       
  <!-- Supplier-service Edit Model -->
  <div class="mobile-modal modal fade curdmodel" id="edit_supplier_services_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="sidebar-block">
                        <div class="title-block">
                           <h2>Edit</h2><a class="modal-close" data-dismiss="modal"><img width="15px" src="{{ asset('images/modal-close.svg')}}"></a>
                        </div>

               <!-----------------------------------------------------------------------------------------------------------------
                                                      Supplier-service Edit Form 
               ------------------------------------------------------------------------------------------------------------------>
                        <form  method="POST"  name="supplier_services_update_form" class="supplier_services_update_form">
                                @csrf
                                <input type="hidden" name="supplier_services_id" class="edit_supplier_service_id">
                          <div class="get-touch-btn-block">
                         
<div class="row">

                           <div class="col-sm-12 col-md-6">

                           <div class="form-group">
                           <label>TYPE OF SERVICE</label>
                           <input type="text" disabled="disabled" readonly class="edit_service_name">
                           </div>

                        </div>

<div class="col-sm-12 col-md-6">
                           <div class="form-group">
                           <label>TYPE OF EVENT</label>
                           <input type="text" disabled="disabled" readonly class="edit_event_name"> 
                           </div>
</div>


<div class="col-sm-12 col-md-6">
                           <div class="form-group">

                               <label for="price_range">Price Range</label>
                                  
                                    <select name="price_range" id="price_range" >
                                    
                                    </select>
                                 
                              </div> 
                           </div>

<div class="col-sm-12 col-md-6">
                           <div class="form-group">
                              <label>Name of Business</label>
                              <input type="text" name="business_name" class="edit_business_name">
                           </div> 
                        </div>
                              
                              <div class="col-sm-12 col-md-12">      
                           <div class="form-group">
                              <label>Description of service</label>
                              <textarea type="text" name="service_description" class="edit_service_description"></textarea>
                           </div>
                        </div>

                        <div class="form-group col-sm-12 required">
                        <label>Location</label>

                        <select class="form-control" name="location[]" multiple="" id="locations">
                        <!-- <option value="">-</option>
                                    @if(isset($locations) && $locations != "")
                                       @foreach($locations as $key=>$location)
                                       <option value="{{$location->id}}">{{$location->location_name}}</option>
                                       @endforeach
                                    @endif -->
                        </select>
                         </div>
                          <!-- <div class="col-sm-12 col-md-6">
                           <div class="form-group">
                              <label>Facebook Title</label>
                                    <input type="text" name="facebook_title"  class="edit_facebook_title">
                           </div>
                        </div> -->

<div class="col-sm-12 col-md-6">
                           <div class="form-group">
                              <label>Facebook Link</label>
                              <input type="text" name="facebook_link" class="edit_facebook_link">
                           </div>
                        </div>

<!-- <div class="col-sm-12 col-md-6">
                           <div class="form-group">
                              <label>Instagram Title</label>
                                    <input type="text" name="instagram_title"  class="edit_instagram_title">
                           </div>
                        </div> -->

<div class="col-sm-12 col-md-6">
                           <div class="form-group">
                              <label>Instagram Link</label>
                                    <input type="text" name="instagram_link"  class="edit_instagram_link">
                           </div>
                        </div>
                     </div>


                     <br>
                              <button type="submit" class="btn white-btn"><span class="gradient-pink-text">Update</span></button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<!-- Supplier-service Edit Model end-->


<!-- Supplier-service Delete Model -->
<div class="modal fade curdmodel"  id="confirm-delete-supplierService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="sidebar-block">
                        <div class="title-block">
                           <h2>Confirm Delete</h2><a class="modal-close" data-dismiss="modal"><img width="15px" src="{{ asset('images/modal-close.svg')}}"></a>
                        </div>
                        <p>You are about to delete one track, this procedure is irreversible.</p>
                           <p>Do you want to proceed?</p>
                           <div class="modal-footer">
                           <form method="POST" id="delete_supplier_services_form" class="delete_supplier_services_form delete_confirm_from">
                               @csrf
                               <input type="hidden" class="supplier_service_deleted_id">
                           <button type="button" class="btn white-btn btn-ok" data-dismiss="modal"><span class="gradient-pink-text">Cancel</span></button>
                           <button type="submit" class="btn  btn-danger  btn-ok"><span class="gradient-pink-text">Delete</span></button>
                           </form>  
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<!-- Supplier-service Delete Model end-->



  <!-- Service Slider Edit Model -->
  <div class="modal fade curdmodel" id="edit_services_slider_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="sidebar-block">
                        <div class="title-block">
                           <h2>Slider Manage</h2><a class="modal-close" data-dismiss="modal"><img width="15px" src="{{ asset('images/modal-close.svg')}}"></a>
                        </div>
               <!-----------------------------------------------------------------------------------------------------------------
                                                      Service Slider Edit Form 
               ------------------------------------------------------------------------------------------------------------------>
               <button type="button" class="btn common-btn add-btn" id="add_slide_btn">
               <i class="fal fa-plus"></i>Add slide
               </button>
               <div class="event-service" id="service-slider-list">
                <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <!-- <th class="DATE" scope="col">#</th> -->
                              <th class="" scope="col">Heading</th>
                              <th class="" scope="col">Content</th>
                              <th class="" scope="col">slide image</th>
                              <th class="REMOVE" scope="col"></th>
                           </tr>
                        </thead>
                        <tbody id="slider-crud">
                     
                        </tbody>
                     </table>
                  </div>
               </div>
                       <div id="add_slide_section" style="display:none">
                        <form  method="POST"  name="services_slider_form" class="services_slider_form" id="services_slider_form" enctype="multipart/form-data">
                                @csrf
                            <div class="get-touch-btn-block">
                            <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                 <label for="booking_date">Heading</label>
                                 <input type="text" name="heading" class="edit_heading" placeholder=""/>
                              </div>
                              </div>
                            <div class="col-md-12">
                              <div class="form-group">
                              <label>Content Description</label>
                              <textarea type="text" name="content" class="edit_content"></textarea>
                              </div>
                              </div>
                              <div class="col-md-12">
                              <div class="form-group">
                              <label for="event_address" id="upload_image_label">Upload Image</label>
                              <input type="file" id="image-upload" name="image-upload" accept="image/*" multiple/>
                              </div>
                              </div>
                              <div class="col-md-12">
                              <input type="hidden" name="supplier_services_id" class="edit_service_slide_id">
                              <button type="submit" class="btn white-btn"><span class="gradient-pink-text">Save</span></button>
                              </div>
                              </div>
                           </div>
                        </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="dashboard-accordion panel-group" id="accordion_dashboard" role="tablist" aria-multiselectable="true"></div>
<!-- /Bootstrap <a href="https://www.jqueryscript.net/accordion/">Accordion</a> -->
</div>
<!-- Service Slider Edit Model end-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {

              console.log("arr[i]",arr[i]);

        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
// var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];


		$.ajax(
		{
			type: "GET",
			url: "{{route('customer_email_list')}}",
			success: function (data)
			{
            var list = [];
            
            console.log(data.customer_emails['length']);

              if(data.customer_emails['length'] > 0){
                 var emails_list = data.customer_emails;
                 for(var c=0;c<emails_list['length'];c++){
                  list.push(emails_list[c].email);
                 }
              }

console.log("LIST",list);
            autocomplete(document.getElementById("myInput"),list);
			}
		});
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/

</script>

@endsection
