
@extends('emails.layouts.EmailTemplate')
@section('content')
<table>
   <tbody>
      <tr>
         <td>
            <br>
            Dear {{$supplier_name}},
            <br>
         </td>
      </tr>
      <tr>
         <td>
            You have received inquiry of service <b> {{$event_name}} </b> from <b>{{$customer_name}} </b> <br>
            Email : {{$customer_email}} <br>
            Message : {{$suppliermessage}}
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