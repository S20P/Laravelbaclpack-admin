  @extends('emails.layouts.EmailTemplate')
  @section('content')
  <div style="width: 100%;">
    @php echo $template; @endphp
  </div>
  @endsection