@extends(backpack_view('blank'))
@section('content')

<style type="text/css">
    

    .chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.pull-right-header{
    /*margin-bottom: 24px;*/
}
.chat li.left .chat-body {
        display: inline-block;
    padding: 0 0 0 10px;
    vertical-align: top;
    width: 92%;
        width: 57%;
}

.chat li.right .chat-body {
       
   
    
        float: right;
    width: 46%;
}

.chat li.left .chat-body p
{
        background: #ebebeb none repeat scroll 0 0;
    border-radius: 3px;
    color: #646464;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
    width: 100%;
   
}

.chat li.right .chat-body p
{
        background: #05728f none repeat scroll 0 0;
    border-radius: 3px;
    font-size: 14px;
    margin: 0;
    color: #fff;
    padding: 5px 10px 5px 12px;
    width: 100%;
}


.chat li .chat-body p
{
    /*margin: 0;*/
    /*color: #777777;*/
    
     background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
    color: #747474;
    display: block;
    font-size: 12px;
    margin: 8px 0 0;
}
.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height:440px;
    background: #fefef0;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}


</style>




<main class="main pt-2">
       <nav aria-label="breadcrumb" class="d-none d-lg-block">
    <ol class="breadcrumb bg-transparent justify-content-end p-0">
                        <li class="breadcrumb-item text-capitalize">
                        <a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a>
                        </li>
                                <li class="breadcrumb-item text-capitalize">
                                  <a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a>
                                </li>
                                <li class="breadcrumb-item text-capitalize active" aria-current="page">List</li>
                  </ol>
  </nav>

         <div class="container-fluid">
          <h2>
            <span class="text-capitalize">Chat</span>
            <small id="datatable_info_stack"><div class="dataTables_info" id="crudTable_info" role="status" aria-live="polite">Supplier/Customer</div></small>
             <small>
 <a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
          </h2>
         </div>
        <div class="container-fluid animated fadeIn">
          <div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
 <div class="row">
        <div class="col-md-8 offset-2">
          @if(isset($conversation))

            <div class="panel panel-primary">
                <div class="panel-heading">
               
        
                </div>
                <div class="panel-body">
                    <ul class="chat">
                       @foreach($conversation as $key_mes => $value_mes)
                       @if($value_mes->status == 1)
                        <li class="left clearfix">
                            <div class="chat-body clearfix">
                                <div class="header">
                             
                                    <strong class="primary-font">{{$value_mes->supplier_name}}</strong>  <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span>Supplier</small>
                                </div>
                                <p>
                                 {!! $value_mes->message !!}
                                </p>
                                <small class="text-muted"> <span class="time_date"><span class="glyphicon glyphicon-time"></span>
{{ \Carbon\Carbon::parse($value_mes->created_at)->format('d-m-yy')}}
                                </span></small>
                            </div>
                        </li>
                         @else
                        <li class="right clearfix">
                            <div class="chat-body clearfix">
                                <div class="header pull-right-header">
                                                   <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>Customer</small>
                                    <strong class="pull-right primary-font">{{$value_mes->customer_name}}</strong>
                                </div>
                                <p>
                                  {!! $value_mes->message !!}
                                </p>
                               <small class="text-muted"> <span class="time_date"><span class="glyphicon glyphicon-time"></span> {{ \Carbon\Carbon::parse($value_mes->created_at)->format('d-m-yy')}}</span></small>
                            </div>
                        </li>
                         @endif  
               @endforeach
                </ul>
                </div>
                <div class="panel-footer">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>           
</div>
</main>

@endsection
