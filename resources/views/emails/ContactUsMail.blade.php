@extends('emails.layouts.EmailTemplate')
@section('content')

<table cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;" width="100%">
  
    <tr style="width: 100%">
        
        <td>
            <table >
                @if($type == 'Admin')
                <tr>
                    <td>
                        Hello, Admin <br></td>
                </tr>
                <tr>
                    <td>
                        You have received contact details from <b> {{$name}} </b> <br><br>
                    </td>
                </tr>
            
                <tr>
                    <td>
                        Email :  {{$email}} <br>
                        Subject :  {{$subject}} <br>
                        Message : {{$message_data}}
                        <br>
                    </td>
                </tr>
                 @else
                <tr>
                    <td><br>Thank you for your enquiry. Our team has received your correspondence and will be in contact soon.<br><br>
                    </td>
                </tr>
                @endif
                <tr>
                </tr>
            </table>
            @endsection