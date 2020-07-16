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
                                 <strong>Logo1:</strong>
                             </td>
                             <td>
                                 <span><img src="{{ asset($records->logo1) }}" alt="" width="150px" height="auto"></span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Logo2:</strong>
                             </td>
                             <td>
                                 <span><img src="{{ asset($records->logo2) }}" alt="" width="150px" height="auto"></span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Contact number:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->contact_number }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Contact email:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->contact_email }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Address:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->address }} </span> </td>
                         </tr>
                       
                         <tr>
                             <td>
                                 <strong>Currency code:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->currency_code }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Currency symbol:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->currency_symbol }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Pagination per page:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->pagination_per_page }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Stripe key:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->stripe_key }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Stripe secret:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->stripe_secret }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Instagram user:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->instagram_user_id }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Instagram secret:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->instagram_secret }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Number of feeds:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->number_of_feeds }}</span> </td>
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