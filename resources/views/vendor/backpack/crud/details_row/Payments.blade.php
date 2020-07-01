@extends(backpack_view('blank'))
@section('content')

<main class="main pt-2">
   <nav aria-label="breadcrumb" class="d-none d-lg-block">
      <ol class="breadcrumb bg-transparent justify-content-end p-0">
         <li class="breadcrumb-item text-capitalize">
<a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a>
         </li>
         <li class="breadcrumb-item text-capitalize">
           <a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a>
         </li>
         <li class="breadcrumb-item text-capitalize active" aria-current="page">Preview</li>
      </ol>
   </nav>
   <section class="container-fluid">
      <h2>
         <span class="text-capitalize">{{ $crud->entity_name }}</span>
        
         <small>
 <a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
      </h2>
   </section>
   <div class="container-fluid animated fadeIn">
      <div class="row">
         <div class="col-md-8">

             @if(isset($records))
            
            <!-- Default box -->
            <div class="">
              
               <div class="card no-padding no-border">
                  <table class="table table-striped mb-0">
                     <tbody>
                       <tr>
                           <td>
                              <strong>Booking date:</strong>
                           </td>
                           <td>
                              <span>
                              {{ \Carbon\Carbon::parse($records->booking_date)->format('d-m-yy')}}
                              </span>                                                                                      </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Supplier service:</strong>
                           </td>
                           <td>
                              <span>{{ $records->service_name }}</span>                                                                                                      
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Event:</strong>
                           </td>
                           <td>
                              <span>{{ $records->event_name }}</span>                                                                                                      
                           </td>
                        </tr>
                        

                        <tr>
                           <td>
                              <strong>Customer:</strong>
                           </td>
                           <td>
                              <span>{{ $records->customer_name }}</span>               </td>
                        </tr>
                          <tr>
                           <td>
                              <strong>Supplier:</strong>
                           </td>
                           <td>
                              <span>{{ $records->supplier_name }}</span>                                                                                </td>
                        </tr>  
                        <tr>
                           <td>
                              <strong>Amount:</strong>
                           </td>
                           <td>
                              <span>{{ $records->amount }}</span>                                                                                </td>
                        </tr>     
                            <tr>
                           <td>
                              <strong>Payment Date:</strong>
                           </td>
                           <td>
                              <span>
{{ \Carbon\Carbon::parse($records->payment_date)->format('d-m-yy')}}
                              </span>                                  </td>
                        </tr>   
                            <tr>
                           <td>
                              <strong>Payment Status:</strong>
                           </td>
                           <td>
                              <span>{{ $records->payment_status }}</span>                                  </td>
                        </tr>
                                         
                    </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->  
              @endif

         </div>
      </div>
   </div>
</main>


@endsection