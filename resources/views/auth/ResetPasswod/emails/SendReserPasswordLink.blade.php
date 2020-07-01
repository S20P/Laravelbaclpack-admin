@extends('emails.layouts.EmailTemplate')
@section('content')
<table>
   <tbody>
     
      <tr>
          <td >
          Dear {{$user_name}} <br><br>
         </td>
      </tr>
     <tr>
        <td >
          You have requested a password reset for this account. If this was not you, please ignore this email.<br>
        </td>
      </tr>
      <tr>
         <td >
            To reset your password, click this link. {{url('/resetPassword')}}/{{$email}}/{{$role}}/{{$actionUrl}}<br>
             <br>
          </td>
      </tr> 
      <tr>
         <td>
              <b>Please note:</b><br>
               For security purposes, this link will expire 72 hours from the time it was sent.<br><br>
               If you cannot access this link, copy and paste the entire URL into your browser.<br><br>
          </td>
      </tr> 
                              
     </tbody>
</table>
@endsection
