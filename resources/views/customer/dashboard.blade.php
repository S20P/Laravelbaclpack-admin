@extends('customer.layouts.master',['title' => 'My Account'])
    @section('content')

        @php
            $site_details = getFooterDetails();
        @endphp

    <input type="hidden" class="customer_id" value="{{$user_details['id']}}">

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
                                <form method="POST" name="customer_account_change_email_form" id="customer_account_change_email_form">
                                      @csrf
                                    <div class="account-input">
                                        <input id="email" type="email" class="@error('email') is-invalid @enderror change_email" disabled name="email" value="{{ old('email',$user_details['email']) }}"  required autocomplete="email" placeholder="contact@company.ie">
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
                        <div class="list-accordion">
                            <div class="list-title">
                                <h5>CHANGE ACCOUNT PASSWORD</h5>
                                <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="account list-accordion-content" style="display: none;">
                                <div class="list-accordion-content-box">
                                <form method="POST" name="customer_account_change_password_form" id="customer_account_change_password_form">
                                      @csrf
                                    <div class="account-input">
                                        <input id="password" type="password" disabled class="@error('password') is-invalid @enderror" name="password">
                                        <button class="btn common-btn hide" id="account_pass_save" type="submit">
                                           <i class="fal fa-check"></i> SAVE
                                        </button>
                                        <button class="btn common-btn" id="account_pass_edit" type="button">
                                            <i class="fal fa-edit"></i> EDIT
                                        </button>
                                    </div>
                                    </form>
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
                                <form method="POST" name="customer_account_change_phone_form" id="customer_account_change_phone_form">
                                       @csrf
                                    <div class="account-input">
                                        <input  id="phone" type="number" min="0" disabled class="@error('phone') is-invalid @enderror change_phone" name="phone" value="{{ old('phone',$user_details->phone) }}" >
                                        <button class="btn common-btn hide" id="account_mob_save" type="submit">
                                           <i class="fal fa-check"></i> SAVE
                                        </button>
                                        <button class="btn common-btn" id="account_mob_edit"  type="button">
                                            <i class="fal fa-edit"></i> EDIT
                                        </button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="profile">
                        <h2 class="gradient-pink-text">Profile</h2>
                          @include('customer.profile')
                   </div>
                    <div class="tab-pane fade" id="downloads">
                        <h2 class="gradient-pink-text"><span>Booking</span></h2>
                        <div class="event-service">
                         <div class="table-responsive">
                            <table class="table">
                               <thead>
                                  <tr>
                                        <th class="DATE" scope="col">DATE</th>
                                        <th class="" scope="col">TYPE OF SERVICE</th>
                                        <th class="" scope="col">EVENT NAME</th>
                                        <th class="" scope="col">PRICE</th>
                                        <th class="" scope="col">BUSINESS NAME</th>
                                        <th class="" scope="col">EVENT ADDRESS</th>      
                                        <th class="" scope="col">STATUS</th>      
                                        <th class="EDIT" scope="col"></th>
                                        <th class="REMOVE" scope="col"></th>
                                  </tr>
                               </thead>
                               <tbody id="customer-booking-crud">
                                 </tbody>
                                </table>
               <!-- Booking Delete Model -->
               <div class="modal fade curdmodel" id="confirm-delete-booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                 <div class="modal-body">
                                    <div class="sidebar-block">
                                       <div class="title-block">
                                          <h2>Confirm Delete</h2><a class="modal-close" data-dismiss="modal"><img src="http://54.67.115.172/laravelbackpack/images/modal-close.svg "></a>
                                       </div>
                                       <p>Are you sure want to delete booking?</p>
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
                         </div>
                      </div>
                    </div>
                <!--     <div class="tab-pane" id="address">
                        <h2 class="gradient-pink-text">Payments</h2>
                    </div> -->
                 <!--    <div class="tab-pane fade" id="account-details">
                        <h2 class="gradient-pink-text">Analytics</h2>
                    </div> -->
                    <div class="tab-pane fade" id="messenger">
                        <h2 class="gradient-pink-text">Messenger</h2>
                        @php
                          $unread = 0;
                        @endphp
                        @if(isset($services) && count($services) > 0)
                          @foreach($services as $key => $value)
                          @php
                              $conversation =  displayMessages($value->id,$user_details['id']);
                          @endphp
                          <div class="list-accordion" >
                             <div class="list-title">
                                <div class="row messenger_main" onclick="changeMsgNotify('{{$value->id}}','{{$user_details['id']}}','customer')">
                                   <div class="col-2 messenger_left">
                                    @if(isset($value->image))
                                      <img alt="Image placeholder" src="{{ asset($value->image) }}">
                                    @else
                                      <img alt="Image placeholder" src="{{ asset('images/avtar.png')}}">
                                    @endif
                                   </div>
                                   <div class="col-10 messenger_right">
                                      <div class="list-title">
                                         <h5>{{$value->business_name}}</h5>
                                         <p>Service : {{$value->name}}
                                            @php
                                          foreach($conversation as $key_count => $value_count){
                                            if($value_count->read_unread == 0 && $value_count->status == 1){
                                              $unread +=1;
                                            }
                                          }
                                         
                                          if($unread > 0){
                                            if($unread == 1){
                                               echo "<span class='message_alert_".$value->id." span_message_alert'><span>".$unread."</span> New Message</span>";
                                            }else{
                                               echo "<span class='message_alert_".$value->id." span_message_alert'><span>".$unread."</span> New Messages</span>";
                                            }
                                          }
                                          $unread = 0;
                                         @endphp
                                         </p>
                                          
                                         

                                         <!-- <span>2 New Messages</span> -->
                                         <span class="list-drop-btn"><i class="fas fa-chevron-down"></i></span>
                                      </div>
                                   </div>
                                </div>
                             </div>
                             <div class="account list-accordion-content">
                                <div class="list-accordion-content-box">
                                   <div class="card-body">

                                      @if(isset($conversation))
                                       <div class="conversion">
                                       @foreach($conversation as $key_mes => $value_mes)
                                     
                                        @if($value_mes->status == 0)
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
                                         <span class="gradient-pink-text"> {{$value->business_name}} : </span> {!! $value_mes->message !!}
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
                                              <input type="hidden" name="customer_reply" class="customer_reply">
                                              <input type="hidden" name="supplier_service_id" class="supplier_service_id" value="{{$value->id}}">
                                                  <textarea class="form-control message_account_reply"  name="inquiry_message" id="message_account_reply" rows="3" placeholder="Type Your Message Here..." required></textarea>
                                          </div>
                                          <button type="submit" class="btn common-btn account_inquiry_submit">
                                              Submit
                                          </button>
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
                <div class="tab-pane fade" id="wishlist">
                    <h2 class="gradient-pink-text">Wishlist</h2>
                    <div class="event-service">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="DATE" scope="col">BUSINESS  NAME</th>
                                    <th class="" scope="col">TYPE OF SERVICE</th>
                                    <th class="" scope="col">DATE</th>
                                    <th class="REMOVE" scope="col"></th>
                                </tr>
                                </thead>
                                <tbody id="customer-wishlist-crud">
                                </tbody>
                            </table>
                            <!-- Wishlist Delete Model -->
                            <div class="modal fade curdmodel" id="confirm-delete-wish" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="sidebar-block">
                                                <div class="title-block">
                                                    <h2>Confirm Delete</h2><a class="modal-close" data-dismiss="modal"><img src="http://54.67.115.172/laravelbackpack/images/modal-close.svg "></a>
                                                </div>
                                                <p>Are you sure want to remove from wishlist?</p>
                                                <p>Do you want to proceed?</p>
                                                <div class="modal-footer">
                                                    <form method="POST" id="delete_wish_form" class="wish_deleted_id delete_confirm_from">
                                                        @csrf
                                                        <input type="hidden" class="wish_deleted_id">
                                                        <button type="button" class="btn white-btn btn-ok" data-dismiss="modal"><span class="gradient-pink-text">Cancel</span></button>
                                                        <button type="submit" class="btn  btn-danger  btn-ok"><span class="gradient-pink-text">Delete</span></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Wishlist Delete Model end-->
                        </div>
                    </div>
                </div>
                </div>

<div class="dashboard-accordion panel-group customer_dashboard" id="accordion_dashboard" role="tablist" aria-multiselectable="true"></div>
<!-- /Bootstrap <a href="https://www.jqueryscript.net/accordion/">Accordion</a> -->
</div>

    @endsection


