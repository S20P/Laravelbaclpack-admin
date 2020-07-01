@extends('emails.layouts.EmailTemplate')
@section('content')
<table>
   <tbody>
      <tr>
         <td>
            <br><br>
            Dear {{$name}}, <br><br>
         </td>
      </tr>
      <tr>
         <td>
           Thank you for signing up for a customer account on Party Perfect.<br>
         </td>
      </tr>
      <tr>
         <td>
            We are reviewing your application and will contact you once your details have been verified. <br><br>
         </td>
      </tr>
   </tbody>
</table>
@endsection
