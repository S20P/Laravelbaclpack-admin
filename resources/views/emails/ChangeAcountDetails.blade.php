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
        The email address associated with {{$name}} has been changed. If you did not make this change then please contact us immediately: 
      </td>
    </tr>
    <tr>
        <td>
          <br><br>
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