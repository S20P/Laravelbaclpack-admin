@extends(backpack_view('blank'))

@php
	$userCount = App\Models\BackpackUser::count();
	$SupplierCount = App\Models\Supplier::count();	
	$CustomerCount = App\Models\Customer::count();
	$ServicesCount = App\Models\Services::count();

	$currentMonth = date('m');
	$Total_payment = App\Models\Payments::selectRaw("sum(payment.amount) as total_payments")->whereRaw('MONTH(created_at) = ?',[$currentMonth])->first();

    $Total_supplierBookings = App\Models\Bookings::selectRaw("count(id) as total_bookings")->whereRaw('MONTH(booking_date) = ?',[$currentMonth])->first();

    $Total_messages = App\Models\Messanger::selectRaw("count(id) as total_messages")->whereRaw('MONTH(created_at) = ?',[$currentMonth])->first();

	$EventsCount = App\Models\Events::selectRaw("count(id) as total_events")->whereRaw('MONTH(created_at) = ?',[$currentMonth])->first();

	// $SupplierCount = App\Models\Supplier::selectRaw("count(id) as total_suppliers")->where('status','Approved')->whereRaw('MONTH(created_at) = ?',[$currentMonth])->first();
	$supplierServicesList = App\Models\Supplier_services::get();

	$serviceGroup = $supplierServicesList->pluck('location');

	$myLocations = [];
	$supplierByLocation = [];

	foreach($serviceGroup as $locations)
	{
	    foreach($locations as $location)
        {
            if(array_key_exists($location,$supplierByLocation))
	        {
	            $supplierByLocation[$location]++;
	        }
	        else
	        {
	            $supplierByLocation[$location] = 1;
            	array_push($myLocations,$location);
	        }
        }
	}

	$locationData = App\Models\Location::whereIn('id',$myLocations)->get();
    $supplierWidget = '';
	foreach($locationData as $ld)
	{
	    if(array_key_exists($ld->id,$supplierByLocation))
	    {
            $supplierWidget .= '<div>'.$ld->location_name.':'.$supplierByLocation[$ld->id].'</div> <br/>';
	    }
	}

	$widgets['before_content'][] = [
	  'type' => 'div',
	  'class' => 'row',
	  'content' => [ // widgets
			[
			    'type'        => 'progress',
			    'class'       => 'card text-white bg-warning mb-2',
			    'value'       => "$".$Total_payment->total_payments,
			    'description' => 'Payment.',
			    'progress'    => (int)$Total_payment->total_payments, // integer
			    'hint'        => 'Upcoming payment.',
			],
			[
			    'type'        => 'progress',
			    'class'       => 'card text-white bg-success border-0 mb-2',
			    'value'       => $Total_supplierBookings->total_bookings,
			    'description' => 'Supplier Bookings.',
			    'progress'    => (int)$Total_supplierBookings->total_bookings, // integer
			    'hint'        => 'Upcoming bookings.',
			],	
			[
			    'type'        => 'progress',
			    'class'       => 'card text-white bg-primary border-0 mb-2',
			    'value'       => $Total_messages->total_messages,
			    'description' => 'Messages.',
			    'progress'    => $Total_messages->total_messages, // integer
			    'hint'        => 'New messages from customers & suppliers.',
			],
			[
			    'type'        => 'progress',
			    'class'       => 'card text-white bg-dark border-0 mb-2',
			    'value'       => $EventsCount->total_events,
			    'description' => 'Events.',
			    'progress'    => $EventsCount->total_events, // integer
			    'hint'        => 'Upcoming events.',
			],
			[
              'type' => 'card',
              'wrapperClass' => 'col-sm-6 col-lg-3',
              'class' => 'card text-white bg-primary border-0 mb-2',
              'content' => [
                  'body' => $supplierWidget.'<small class="text-muted">Supplier By Location.</small>',
              ]
            ]
	  ]
	];
	@endphp 
@section('content')


@endsection

