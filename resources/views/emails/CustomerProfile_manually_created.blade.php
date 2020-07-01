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
            <td>
                <br>
                Welcome to The Party Perfect.
                <br>
            </td>
        </tr>
        <tr>
            <td>
                Your Customer Profile successfully registered by Admin.<br>
            </td>
        </tr>
        <tr>
            <td>
                Your Account Details are:<br>
            </td>
        </tr>
        <tr>
            <td>
                Email : {{$email}},<br>
            </td>
        </tr>
        <tr>
            <td>
                Password : {{$password}},<br>
            </td>
        </tr>
        <tr>
            <td>
                Phone : {{$phone}},<br>
            </td>
        </tr>
    </tbody>
</table>
@endsection
