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
           
            
            <!-- Default box -->
            <div class="">
              
               <div class="card no-padding no-border">
                 

    <ul class="nav-dropdown-items">
        <li class="nav-item"><i class="nav-icon fa fa-files-o"></i> <span>1. How many of a supplier type on PP
       
</span>
<ul>
            <li><a class="nav-link" href="{{ backpack_url('reports/industry_stats_report_QabyPrice') }}">a. By price</a>
</li>
<li>
   <a class="nav-link" href="{{ backpack_url('reports/industry_stats_report_QabyLocation') }}">b. By location</a>
</li>
         </ul>
</li>
         <li class="nav-item"><i class="nav-icon fa fa-files-o"></i> <span>2. How many people viewed a supplier type
</span>

 <ul>
            <li><a class="nav-link" href="{{ backpack_url('reports/industry_stats_report_QbbyPrice') }}">a. By price</a>
</li>
<li>
   <a class="nav-link" href="{{ backpack_url('reports/industry_stats_report_QbbyLocation') }}">b. By location</a>
</li>
         </ul>
</li>

 <li class="nav-item"><i class="nav-icon fa fa-files-o"></i> <span>3. How many people contacted a supplier type

</span>
 <ul>
            <li><a class="nav-link" href="{{ backpack_url('reports/industry_stats_report_QcbyPrice') }}">a. By price</a>
</li>
<li>
   <a class="nav-link" href="{{ backpack_url('reports/industry_stats_report_QcbyLocation') }}">b. By location</a>
</li>
         </ul>

</li>

 <li class="nav-item"><i class="nav-icon fa fa-files-o"></i> <span>4. How many people booked a supplier type
</span>

 <ul>
            <li><a class="nav-link" href="{{ backpack_url('reports/industry_stats_report_QdbyPrice') }}">a. By price</a>
</li>
<li>
   <a class="nav-link" href="{{ backpack_url('reports/industry_stats_report_QdbyLocation') }}">b. By location</a>
</li>
         </ul>



               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->  
             

         </div>
      </div>
   </div>
</main>


@endsection
@include('backpack::inc.scripts')
<script type="text/javascript">
    $(document).ready(function(){

   });
</script>