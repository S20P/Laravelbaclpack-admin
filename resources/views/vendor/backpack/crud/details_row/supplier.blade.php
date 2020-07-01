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

             @if(isset($supplier))
            
            <!-- Default box -->
            <div class="">
               <h4>Supplier Information</h4>
               <div class="card no-padding no-border">
                  <table class="table table-striped mb-0">
                     <tbody>
                        <tr>
                           <td>
                              <strong>Profile image:</strong>
                           </td>
                           <td>
                              <span><img src="{{ asset($supplier->image) }}" alt="" width="150px" height="auto"><br></span>                                                                                                     
                           </td>
                        </tr>                         
                        <tr>
                           <td>
                              <strong>Name:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier->name }}</span>                                                                                                     
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Email:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier->email }}</span>                                                                                                      
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Phone:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier->phone }}</span>                                                                                                     
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Status:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier->status }}</span>                                                                                                     
                           </td>
                        </tr>                      
                    </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->

<!-- Supplier services -->
  @if(isset($supplier_services))
      @if(count($supplier_services))
  <!-- Default box -->
            <div class="">
               <h4>Supplier Services</h4>
               <div class="card no-padding no-border">
                  <table class="table table-striped mb-0">
                     <tbody>
                        @foreach($supplier_services as $service)
                        <tr>
                           <td>
                              <strong>Service name:</strong>
                           </td>
                           <td>
                              <span>{{ $service->service_name }}</span>                                                                                                     
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Business name:</strong>
                           </td>
                           <td>
                              <span>{{ $service->business_name }}</span>                                                                                                      
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Service description:</strong>
                           </td>
                           <td>
                              <span>{{ $service->service_description }}</span>                                                                                                     
                           </td>
                        </tr>
                                            
                    </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
            @endforeach
            @endif
            @endif
       <!-- /Supplier services -->

      <!-- payment information -->
         @if(isset($supplier_payment_info))            
            <!-- Default box -->
            <div class="">
               <h4>Payment Information</h4>
               <div class="card no-padding no-border">
                  <table class="table table-striped mb-0">
                     <tbody>
                        <tr>
                           <td>
                              <strong>Account Holder Name:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier_payment_info->account_holder_name }}</span>                                                                                                     
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Account Number:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier_payment_info->account_number }}</span>                                                                                                      
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Bank Name:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier_payment_info->bank_name }}</span>                                                                                                     
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <strong>Bank Address:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier_payment_info->bank_address }}</span>                                                                                                     
                           </td>
                        </tr> 
                         <tr>
                           <td>
                              <strong>IFSC:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier_payment_info->ifsc }}</span>
                           </td>
                        </tr> 
                         <tr>
                           <td>
                              <strong>IBAN:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier_payment_info->iban }}</span>
                           </td>
                        </tr> 
                         <tr>
                           <td>
                              <strong>Sort code:</strong>
                           </td>
                           <td>
                              <span>{{ $supplier_payment_info->sortcode }}</span>
                           </td>
                        </tr>                      
                    </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
          @endif
         <!-- /payment information -->


            @endif

         </div>
      </div>
   </div>
</main>


@endsection