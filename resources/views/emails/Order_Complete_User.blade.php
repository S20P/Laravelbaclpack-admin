@php
    $site = getFooterDetails();
@endphp
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="https://www.opensource.org/licenses/mit-license/">
    <style type="text/css">
        /* reset */

        *
        {
            border: 0;
            box-sizing: content-box;
            color: inherit;
            font-family: inherit;
            font-size: inherit;
            font-style: inherit;
            font-weight: inherit;
            line-height: inherit;
            list-style: none;
            margin: 0;
            padding: 0;
            text-decoration: none;
            vertical-align: top;
        }


        /* heading */

        h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

        /* table */

        table { font-size: 75%; table-layout: fixed; width: 100%; }
        table { border-collapse: separate; border-spacing: 2px; }
        th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
        th, td { border-radius: 0.25em; border-style: solid; }
        th { background: #EEE; border-color: #BBB; }
        td { border-color: #DDD; }

        /* page */

        html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
        html {     background: #f2f2f2; cursor: default; }

        body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 600px; }
        body { background: #FFF; border-radius: 1px; }

        /* header */

        header { margin: 0 0 3em; }
        header:after { clear: both; content: ""; display: table; }

        header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
        header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
        header address p { margin: 0 0 0.25em; }
        header span, header img { display: block; float: right; }
        header address span { margin: 0; }
        header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
        header img { max-height: 100%; max-width: 100%; }
        header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

        /* article */

        article, article address, table.meta, table.inventory { margin: 0 0 3em; }
        article:after { clear: both; content: ""; display: table; }
        article h1 { clip: rect(0 0 0 0); position: absolute; }

        article address { float: left; font-size: 125%; font-weight: bold; }

        /* table meta & balance */

        table.meta, table.balance { float: right; width: 36%; }
        table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

        /* table meta */

        table.meta th { width: 40%; }
        table.meta td { width: 60%; }

        /* table items */

        table.inventory { clear: both; width: 100%; }
        table.inventory th { font-weight: bold; }


        /* table balance */

        table.balance th, table.balance td { width: 50%; }
        table.balance td { text-align: right; }

        /* aside */

        aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
        aside h1 { border-color: #999; border-bottom-style: solid; }



        @media print {
            * { -webkit-print-color-adjust: exact; }
            html { background: none; padding: 0; }
            body { box-shadow: none; margin: 0; }
            span:empty { display: none; }
        }

        @page { margin: 0; }
    </style>
</head>
<body>
<header>
    <h1>Invoice</h1>
    <br><br>
    <address>
        <strong style="font-weight: bold;">Client Information,</strong><br><br>
        {{$getBooking['cname']}}
    </address>
    <span>
				<br><br>
               <!--  @if(isset($site->logo2) && $site->logo2 != "")
                    <a href="{{ route('home') }}"><img src="{{ asset($site->logo2) }}" alt="Logo"  /></a>
                @else
                    <a href="{{ route('home') }}"><img src="{{asset('images/logo-BLACK.png')}}" alt="Logo_D"  /></a>
                @endif -->
                                
				</span>
</header>
<article>
    <address style="font-size: 75%; font-weight: normal;">
        <p><span style="font-weight: bold;">Supplier Details</p><br><br>
        <p><span style="font-weight: bold;">Supplier: </span> {{$getBooking['sname']}}</p>
         @if(isset($getBooking['service_name']))
            <p><span style="font-weight: bold;">Service: </span> {{$getBooking['service_name']}}</p>
        @endif
        @if(isset($getBooking['business_name']))
            <p><span style="font-weight: bold;">Business: </span> {{$getBooking['business_name']}}</p>
        @endif
        @if($getBooking['email'] != "")
            <p><span style="font-weight: bold;">Email: </span> {{$getBooking['email']}}</p>
        @endif
        @if($getBooking['phone'] != "")
            <p><span style="font-weight: bold;">Phone: </span> {{$getBooking['phone']}}</p>
        @endif
        @if($getBooking['facebook_title'] != "")
            <p><span style="font-weight: bold;">Facebook: </span> <a href="{{$getBooking['facebook_link']}}"></a>{{$getBooking['facebook_title']}}</p>
        @endif
        @if($getBooking['instagram_title'] != "")
            <p><span style="font-weight: bold;">Instagram: </span> <a href="{{$getBooking['instagram_link']}}"></a><span>@</span>{{$getBooking['instagram_title']}}</p>
        @endif
    </address>
    <table class="meta">
         <tr>
            <th><span >Invoice #</span></th>
            <td><span >{{$getBooking['id']}}</span></td>
        </tr>
        <tr>
            <th><span >Date</span></th>
            <td><span >{{$getBooking['booking_date']}}</span></td>
        </tr>
        <tr>
            <th><span >Amount Due</span></th>
            <td><span id="prefix" >
                @if(isset($site->currency_symbol) && $site->currency_symbol != "")
                    {{$site->currency_symbol}}
                @endif
            </span><span>{{ number_format($getBooking['amount'],2)}}</span></td>
        </tr>
    </table>
    <table class="inventory">
        <thead>
        <tr>
            <th><span >ID</span></th>
            <th><span >SERVICE NAME</span></th>
            <th><span >EVENT NAME</span></th>
            <th><span >EVENT ADDRESS</span></th>
            <th><span >UNIT COST</span></th>
            <th><span >TOTAL</span></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><span >{{$getBooking['id']}}</span></td>
            <td><span > {{$getBooking['service_name']}}</span></td>
            <td><span >{{$getBooking['event_name']}}</span></td>
            <td><span >{{$getBooking['event_address']}}</span></td>
            <td>
                <span >
                     @if(isset($site->currency_symbol) && $site->currency_symbol != "")
                        {{$site->currency_symbol}}
                    @endif
                </span>
                <span>{{ number_format($getBooking['amount'],2)}}</span>
            </td>
            <td>
                <span >
                     @if(isset($site->currency_symbol) && $site->currency_symbol != "")
                        {{$site->currency_symbol}}
                    @endif
                </span>
                <span>{{ number_format($getBooking['amount'],2)}}</span>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="balance">
        <tr>
            <th><span >Total</span></th>
            <td><span >
               @if(isset($site->currency_symbol) && $site->currency_symbol != "")
                    {{$site->currency_symbol}}
                @endif
            </span><span>{{ number_format($getBooking['amount'],2)}}</span></td>
        </tr>
        <tr>
            <th><span >Amount Paid</span></th>
            <td><span >
                 @if(isset($site->currency_symbol) && $site->currency_symbol != "")
                    {{$site->currency_symbol}}
                @endif
            </span><span>{{ number_format($getBooking['amount'],2)}}</span></td>
        </tr>
        <tr>
            <th><span >Balance Due</span></th>
            <td><span >
                @if(isset($site->currency_symbol) && $site->currency_symbol != "")
                    {{$site->currency_symbol}}
                @endif
            </span><span>0.00</span></td>
        </tr>
    </table>
</article>
<article>
    <table class="table table-condensed">
        <thead>
        <tr>
            <td>

                <strong style="display:block;margin:0 0 10px 0; font-weight: bold;">Regards</strong> Address<br>
                 @if(isset($site->address) && $site->address != "")
                    {{$site->address}}
                @endif
                 <br><br><br>
                <b style="font-weight: bold;">Phone:</b> +
                @if(isset($site->contact_number) && $site->contact_number != "")
                    {{$site->contact_number}}
                @endif
                <br><br>
                <b style="font-weight: bold;">Email:</b> 
                 @if(isset($site->contact_email) && $site->contact_email != "")
                    {{$site->contact_email}}
                @endif
            </td></tr></thead></table>

</article>
</body>
</html>






