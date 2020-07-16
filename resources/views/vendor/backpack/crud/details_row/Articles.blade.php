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
                                <strong>Slug:</strong>
                            </td>
                            <td>
                                <span>{!! $records->slug !!}</span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Category:</strong>
                            </td>
                            <td>
                                <span>{!! $records->category_name !!}</span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Title:</strong>
                            </td>
                            <td>
                                <span>{!! $records->title !!}</span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Content:</strong>
                            </td>
                            <td>
                                <span>
                                    {!! $records->content !!}
                                </span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Quote:</strong>
                            </td>
                            <td>
                                <span>
                    {!! $records->quote !!}
                                 </span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Banner image:</strong>
                            </td>
                            <td>
                                <span><img src="{{ asset($records->banner_image) }}" alt="" width="150px" height="auto"></span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Column1 image:</strong>
                            </td>
                            <td>
                                <span><img src="{{ asset($records->column1_image) }}" alt="" width="150px" height="auto"></span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Column1 title:</strong>
                            </td>
                            <td>
                                <span>{!! $records->column1_title !!} </span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Column1 description:</strong>
                            </td>
                            <td>
                                <span> 
                    {!! $records->column1_description !!}
                                </span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Column2 image:</strong>
                            </td>
                            <td>
                                <span><img src="{{ asset($records->column2_image) }}" alt="" width="150px" height="auto"></span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Column2 title:</strong>
                            </td>
                            <td>
                                <span>{!! $records->column2_title !!} </span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Column2 description:</strong>
                            </td>
                            <td>
                                <span>
                                    {!! $records->column2_description !!}
                                                </span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Media type:</strong>
                            </td>
                            <td>
                                <span>{!! $records->media_type !!}</span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Image:</strong>
                            </td>
                            <td>
                                <span><img src="{{ asset($records->image) }}" alt="" width="150px" height="auto"></span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Video link:</strong>
                            </td>
                            <td>
                                <span>{!! $records->video !!}</span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Status:</strong>
                            </td>
                            <td>
                                <span>{!! $records->status !!}</span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Date:</strong>
                            </td>
                            <td>
                                <span>
                           {{ \Carbon\Carbon::parse($records->date)->format('d-m-yy')}}
                        </span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Author:</strong>
                            </td>
                            <td>
                                <span>{!! $records->author !!}</span> </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Featured:</strong>
                            </td>
                            <td>
                                <span>
                                    @if($records->featured==1)
                                          Yes
                                          @else
                                          No
                                          @endif
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