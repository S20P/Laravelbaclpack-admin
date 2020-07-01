
  @extends('emails.layouts.EmailTemplate')
  @section('content')
  @php
        $site = getFooterDetails();
  @endphp
  <table>
    <tbody>
      <tr>
        <td>
          <br><br>
          Hello {{$sname}},<br><br>
        </td>
      </tr>
      <tr>
        <td>
          
         Your subscription on party perfect is now cancelled because of payment of this month has not been received.<br><br>
         Your profile is now disapproved. 
          <br><br>
        </td>
      </tr>
      <tr>
        <td>
          If you are having any questions about that please contact. <br>
            <p>
              @if(isset($site->contact_number))
                Call us: +{{$site->contact_number}}<br>
              @endif
              @if(isset($site->contact_email))
                Mail us: <a href="emailto:{{$site->contact_email}}">{{$site->contact_email}}</a>
              @endif
            </p>
        </td>
      </tr>
    </tbody>
  </table>
  @endsection