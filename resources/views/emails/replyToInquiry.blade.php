@extends('emails.layouts.EmailTemplate')
@section('content')
<table>
   <tbody>
      <tr>
         <td><br>
            Dear {{$name}},
            <br>
         </td>

      </tr>
      <tr>
         <td><br>
            You have received inquiry msesage of service <b>{{$service}}</b> from <b>{{$name_from}}</b> <br>
            Email : {{$email_from}} <br>
            Message : {{$messages}} <br>
         </td>
      </tr>
      <tr>
         <td>
            <br>
         </td>
      </tr>
   </tbody>
</table>
@endsection