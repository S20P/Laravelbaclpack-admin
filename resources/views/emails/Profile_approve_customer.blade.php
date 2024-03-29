
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
         Welcome to Party Perfect!<br><br>
        </td>
      </tr>
      <tr>
        <td>
         Your application has been reviewed and approved. To verify your account please login: <a href="{{route('home')}}" >Login on site</a>
          <br><br>
        </td>
      </tr>
      <tr>
        <td>
          If you are having trouble logging in please contact: <br>
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