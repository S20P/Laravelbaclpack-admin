@extends('emails.layouts.EmailTemplate')
@section('content')
<table>
   <tbody>
      <tr>
         <td>
            <br><br>
            Dear {{$business_name}}, <br><br>
         </td>
      </tr>
      <tr>
         <td>
            Thank you for applying to be listed as a supplier on Party Perfect.<br>
            We are reviewing your application and will contact you once your details have been verified.<br><br>
         </td>
      </tr>
      <tr>
         <td>
            In the meantime please consult our Suppliers page for more information. <a href="{{route('SupplierTackandCare')}}"> Suppliers Terms and Conditions </a><br><br>
         </td>
      </tr>
   </tbody>
</table>
@endsection
