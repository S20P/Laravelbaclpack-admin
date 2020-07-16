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
<!-- Supplier services -->
        
             @if(isset($supplier_services))
      @if(count($supplier_services))
            <!-- Default box -->
            <div class="">
               
               <div class="card no-padding no-border">
                  <table class="table table-striped mb-0">
                   <tbody>

         @foreach($supplier_services as $service)
                   <tr>
                     <td>
                        <strong>Supplier:</strong>
                     </td>
                     <td>
                        <span>{{ $service->supplier_name }}</span>                                                                                   </td>
                  </tr>
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


                   @if(isset($locations))
                   @if(count($locations))
                     <tr>
                           <td>
                              <strong>Locations:</strong>
                           </td>
                           <td>
                            <span>

                              @foreach($locations as $location)
                               @if($location['supplier_services_id']==$service->id)
                                 {{ implode(",",$location['locations_record']) }}
                               @endif 
                              @endforeach
                            </span> 
          </td>
                        </tr>


                   @endif
                   @endif



                        
   <tr>
      <td>
         <strong>Facebook:</strong>
      </td>
      <td>
         <span>
            <a href="{{ $service->facebook_link }}">{{ $service->facebook_title }}</a>
         </span>                                                                                                          
      </td>
   </tr>
   
   <tr>
      <td>
         <strong>Instagram:</strong>
      </td>
      <td>
         <span>
             <a href="{{ $service->instagram_link }}">{{ $service->instagram_title }}</a>
         </span>                                                                                                          
      </td>
   </tr>
  
   <tr>
      <td>
         <strong>Price range:</strong>
      </td>
      <td>
         <span>
              @if($service->price_range==1)
              Low
              @endif

              @if($service->price_range==2)
              Medium
              @endif

              @if($service->price_range==3)
              High
              @endif
            
         </span>                                                                                                         
      </td>
   </tr>
   

           @endforeach 
 
            </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
            @endif
            @endif
       <!-- /Supplier services -->


         </div>
      </div>
   </div>
</main>


@endsection