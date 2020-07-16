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
                                 <strong>Social network:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->social_network }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Slug:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->slug }}</span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Account url:</strong>
                             </td>
                             <td>
                                 <span>{{ $records->account_url }} </span> </td>
                         </tr>
                        <tr>
                             <td>
                                 <strong>Account Preview:</strong>
                             </td>
                             <td>
                                 <span><a href="{{ $records->account_url }}">Preview Account</a></span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Icon:</strong>
                             </td>
                             <td>
                                 <span><i class="{{ $records->icon }}"></i></span> </td>
                         </tr>
                         <tr>
                             <td>
                                 <strong>Image:</strong>
                             </td>
                             <td>
                                 <span><img src="{{ asset($records->image) }}" alt="" width="150px" height="auto">
                                 </span> </td>
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