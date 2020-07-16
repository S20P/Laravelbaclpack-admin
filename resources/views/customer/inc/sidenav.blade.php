  <!-- Nav tabs -->
  <div class="dashboard_tab_button">
                    <ul id="dashboard-tabs" role="tablist" class="nav flex-column dashboard-list">
                        <li class="dashboard"><a href="#dashboard" data-toggle="tab" class="nav-link active">account
                          <span><i
                                class="fal fa-angle-right"></i></span></a></li>
                        <li class="profile"><a href="#profile" data-toggle="tab" class="nav-link">profile<span><i
                                class="fal fa-angle-right"></i></span></a></li>
                        <li class="downloads"><a href="#downloads" data-toggle="tab" class="nav-link bookingrefresh">booking<span><i
                                class="fal fa-angle-right"></i></span></a></li>
                        <li class="messenger"><a href="#messenger" data-toggle="tab" id="messenger-tab-menu" class="nav-link">messenger<span><i
                                class="fal fa-angle-right"></i></span>
                        
                                       @php
                                       if(isset($conversation)){
                                          foreach($conversation as $key_count => $value_count){
                                            if($value_count->read_unread == 0 && $value_count->status == 1){
                                              $unread +=1;
                                            }
                                          }
                                          if($unread > 0){
                                            if($unread == 1){
                                               echo "<sub class='message_alert_".$value->id." span_message_alert_nav'><sub>".$unread."</sub></sub>";
                                            }else{
                                               echo "<sub class='message_alert_".$value->id." span_message_alert_nav'><sub>".$unread."</sub></sub>";
                                            }
                                          }
                                          $unread = 0;
                                          }
                                         @endphp
                        
                        </a></li>
                        <li class="wishlist"><a href="#wishlist" data-toggle="tab" class="nav-link">wishlist<span><i
                                class="fal fa-angle-right"></i></span></a></li>
                     
                    </ul>
  </div>