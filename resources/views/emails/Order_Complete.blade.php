
  @extends('emails.layouts.EmailTemplate')
  @section('content')
  <table width="100%">
    <tbody>
    @if($type == 'customers')
    <tr>
        <td>
          <br><br>
            Thank you for your payment to {{$sname}}. Attached is proof of payment.
            <br><br>
        </td>
    </tr>
    @elseif($type == 'suppliers')
    <tr>
        <td>
            <br><br>
            You have received Payment from {{$cname}}. Attached is proof of payment.
            <br><br>
        </td>
    </tr>
    @else
    <tr>
        <td>
           <br><br>
            Dear {{$sname}},
            <br><br>
        </td>
    </tr>
    <tr>
        <td>
            You have received payment from {{$cname}}. Attached is proof of payment. This amount will be paid out to you as per the payment schedule.
            <br><br>
        </td>
    </tr>
    @endif
      </tr>
    </tbody>
  </table>
  @endsection