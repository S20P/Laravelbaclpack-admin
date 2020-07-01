@extends('emails.layouts.EmailTemplate')
@section('content')
  @php
        $site = getFooterDetails();
  @endphp
<table>
   <tbody>
     <tr>
        <td >
        	<br>
          Welcome to Party Perfect!
          <br>
        </td>
      </tr>
      <tr>
         <td >
            You have been added as a Supplier. To verify your supplier status please access the Supplier portal by following this link: <br> 
            <a href="{{route('SupplierLogin')}}">Login here.</a>
            <br>
          </td>
      </tr> 
      <tr>
         <td>
         <br> 
             Your Account Details are:
          </td>
      </tr> 
     <tr>
        <td >
            Email : {{$email}},
        </td>
      </tr>
     <tr>
        <td >
            Password : {{$password}},
           </td>
     </tr>
     <tr>
       <td>
            Phone : {{$phone}},
           </td>
     </tr>
     <tr>
      <td>
      	<br>
          If you are having trouble accessing your portal please contact us. <br>
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