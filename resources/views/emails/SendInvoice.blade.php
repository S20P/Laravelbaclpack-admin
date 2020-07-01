@extends('emails.layouts.EmailTemplate')
@section('content')
<table cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;" width="100%">
<tbody>       
    <tr>
        <td>
            <br><br>
            Welcome to Party Perfect!</td>
    </tr>
    <tr>
        <td>
            <br>
            <br>
            You have received an invoice from {{$sname}}.
            <a href="{{route('invoice',['booking_id'=>base64_encode($booking_id)])}}" class=""
                target="_blank">Click to open invoice</a>
            <br>
            <br>
        </td>
    </tr>     
    </tbody>
 </table>
@endsection