@extends('layouts.app')
@section('title', 'Main page')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
         <h2>Add Subsport</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/admin') }}">Subsport</a>
            </li>
            <li class="active">
                Add Subsport
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                   <h5>Add Subsport</h5>
                </div>
                <div class="ibox-content " >
                {{ Form::open(['route' => 'subsport.store','class'=>"form-horizontal","name"=>"addsubsport"]) }}
                    
                    @include('subsport/_form')

                   <div class="form-group">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ url('/subsport') }}" class="btn btn-primary">
                                    Back
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

@if(Session::has('addsubsporterr'))
    <script> toastrDisplay("error","{{ Session::get('addsubsporterr') }}"); </script>
@endif

<script type="text/javascript">
$("form[name='addsubsport']").validate({
             rules: {
                title:"required",
                value:"required",
                sportid:"required",
             },
              messages:{
                title: {required:"Title is required"},
                value:{required:"Value is reqired"},        
                sportid:{required:"Sport is reqired"}        
             }
});
</script>
@endpush

