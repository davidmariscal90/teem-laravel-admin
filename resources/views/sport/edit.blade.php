@extends('layouts.app')
@section('title', 'Sport')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit Sport</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/admin') }}">Sport</a>
            </li>
            <li class="active">
                Edit Sport
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Sport</h5>
                </div>
                <div class="ibox-content">
                
                {{  Form::model($sport, ['method' => 'PATCH','route' => ['sport.update', $sport->_id],'class'=>"form-horizontal","name"=>"editsport"]) }}
                    
                    @include('sport/_form')

                   <div class="form-group">
                            <div class="col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ url('/sport') }}" class="btn btn-danger">
                                    Cancel
                                </a>
                            </div>
                        </div> 
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push("scripts")

@if(Session::has('addsporterr'))
    <script> toastrDisplay("error","{{ Session::get('addsporterr') }}"); </script>
@endif

<script type="text/javascript">
$("form[name='editsport']").validate({
             rules: {
                title:"required",
                imageurl:"required",
             },
              messages:{
                title: {required:"Title is required"},
                imageurl:{required:"Image url is reqired"}        
             }
});
</script>
@endpush

