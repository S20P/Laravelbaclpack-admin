@extends('emails.layouts.EmailTemplate')
@section('content')
      @php
        $site = getFooterDetails();
      @endphp
            <table bgcolor="#f8f8f8" width="100%" align="center" style="margin:0  auto;  border-collapse: collapse;">
                <tr>
                    <td style="color: #242424; padding:10px; background :#f8f8f8; letter-spacing: 0.2px;font-size: 16px;font-family: sans-serif;"></td>
                </tr>
                @if($mail_type == 'admin')
                <tr>
                    <td style="color: #242424; padding:10px 20px; background :#f8f8f8; letter-spacing: 0.2px;font-size: 16px;font-family: sans-serif;">
                        Dear {{$admin_name}},
                    </td>
                </tr>
                <tr>

                        <td style="color: #242424; padding:10px 20px; background :#f8f8f8; letter-spacing: 0.2px;font-size: 16px;font-family: sans-serif;">
                            On party perfect, new supplier <b>{{$sname}}</b> have been created and successfully pay for service {{$service}}.
                        </td>


                </tr>
                @else
                    <tr>
                        <td style="color: #242424; padding:10px 20px; background :#f8f8f8; letter-spacing: 0.2px;font-size: 16px;font-family: sans-serif;">
                            Dear {{$sname}},
                        </td>
                    </tr>
                    <tr>

                        <td style="color: #242424; padding:10px 20px; background :#f8f8f8; letter-spacing: 0.2px;font-size: 16px;font-family: sans-serif;">
                           Thank you, <br><br>
                           Your payment is successfully done.<br><br>
                           Now you need approval of admin. After approved by admin, you will get mail with login link. <br><br>
                           Then you can sign in and use services of party perfect as a supplier.<br>
                        </td>

                    </tr>
                @endif
                <tr>
                    <td style="color: #242424; padding:10px 20px; background :#f8f8f8; letter-spacing: 0.2px;font-size: 16px;font-family: sans-serif;">Select Service : {{$service}} </td>
                </tr>
                <tr>
                    <td style="color: #242424; padding:10px 20px; background :#f8f8f8; letter-spacing: 0.2px;font-size: 16px;font-family: sans-serif;"> Total Amount : {{ $site->currency_symbol  }}{{ number_format($amount,2) }}</td>
                </tr>
            </table>
            @endsection 








