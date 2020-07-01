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
                                 <strong>Location name:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->location_name }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>City:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->city }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>State province:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->state_province }} </span> </td>
                         </tr>
                        <tr>
                             <td>
                                 <strong>Postal code:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->postal_code }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Country:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->country }}</span> </td>
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