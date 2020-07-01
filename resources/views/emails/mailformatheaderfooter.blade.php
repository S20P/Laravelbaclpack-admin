

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
   
<style type="text/css">


html {     font: 14px/1 'Open Sans', sans-serif;
    line-height: normal;}
  body{
    margin: 0;
    padding: 0;
    color: #153643;
  }
 a{ color: #153643; } 
 strong { font-size: 14px; }
</style>
</head>
<body>
      @php
        $site = getFooterDetails();
      @endphp
  <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
    <tr>
      <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        
          <tr>
            <td bgcolor="#ffffff">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                 <tr>
                  <td bgcolor="#eee" style="padding: 10px 20px 10px 20px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td width="260" valign="middle">
                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                              <td>
                                <img src="{{asset('images/logo-BLACK.png')}}" alt="" width="217px" style="display: block;" />
                              </td>
                            </tr>
                           
                          </table>
                        </td>
                        <td style="font-size: 0; line-height: 0;" width="20">
                          &nbsp;
                        </td>
                        <td width="260" valign="middle">
                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                              <td>
                               <h3 class="collapse" style="text-align: right; font-weight: normal;">@php echo date("M, Y"); @endphp</h3>
                              </td>
                            </tr>
                           
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
               
                <tr>
                  <td style="padding: 10px 20px 10px 20px; color: #153643;">
<table>
   <tbody>
      <tr>
         <td>
        <br><br>
                   Thank You, <br><br>
         </td>
      </tr>
       <tr>
         <td>
        
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat.<br><br>
         </td>
      </tr>
       <tr>
         <td>
        
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat.<br><br>
         </td>
      </tr>
   </tbody>
</table> 
                  </td>
                </tr>
                <tr>
                  <td>
                    <table align="left" class="column">
<tbody><tr>
<td>
<h5 class="">Have any question?</h5>
<p><strong>Call us:</strong> @if(isset($site->contact_number))+{{$site->contact_number}} @endif<br>
<strong>Mail us: </strong> @if(isset($site->contact_email))<a href="emailto:{{$site->contact_email}}">{{$site->contact_email}}</a>@endif</p>
</td>
</tr>
</tbody></table>
                  </td>
                </tr>
               
              </table>
            </td>
          </tr>
          <tr>
            <td bgcolor="#715DFC" style="padding: 30px 30px 30px 30px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="color: #ffffff; font-size: 14px;" width="75%">
                    &reg; Party Perfect, 2020<br/>
                    <a href="#" style="color: #ffffff;"><font color="#ffffff">Unsubscribe</font></a> to this newsletter instantly
                  </td>
                  <td align="right" width="25%">
                    <table border="0" cellpadding="0" cellspacing="0">
                        @php
                            $socials = getSocialDetails();
                        @endphp
                        <tr>
                            @if(isset($socials) && $socials != '')
                                @foreach($socials as $socialdetails)
                                    @if($socialdetails->icon != '')
                                        <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;"><a href="{{$socialdetails->account_url}}" target="_blank"><i class="{{$socialdetails->icon}}"></i></a></td>
                                         <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                    @else($socialdetails->image != '')
                                        <td><a href="{{$socialdetails->account_url}}"><img src="{{asset($socialdetails->image)}}"></a> </td>
                                         <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                    @endif
                                @endforeach
                            @endif
                        </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table style="width: 100%;">
<tbody><tr>
<td align="center">
<p style="font-size: 12px;">
<a href="{{route('SupplierTackandCare')}}">SUPPLIER T&C</a>|
<a href="{{route('Help')}}">HELP</a>
<a href="{{route('Faq')}}">FAQ'S</a>
</p>
</td>
</tr>
</tbody></table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>


