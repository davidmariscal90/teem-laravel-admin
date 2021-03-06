@extends('layouts.app')
@section('title', 'Sportcenter')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit Sportcenter</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/field') }}">Sportcenter</a>
            </li>
            <li class="active">
                Edit Sportcenter
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Sportcenter</h5>
                </div>
                <div class="ibox-content">
                
                {{  Form::model($sportcenter, ['method' => 'PUT','route' => ['field.scupdate', $sportcenter->_id],'class'=>"form-horizontal","name"=>"editsportcenter"]) }}
                    
                    @include('field/_form')

                   <div class="form-group">
                            <div class="form-group">
                            <div class="col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ url('/field') }}" class="btn btn-danger">
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

@if(Session::has('sportcentererr'))
    <script> toastrDisplay("error","{{ Session::get('sportcentererr') }}"); </script>
@endif

<script type="text/javascript">
$("form[name='editsportcenter']").validate({
             rules: {
                name:"required",
                phone:"required",
                description:"required",
                address:"required",
             },
              messages:{
                name: {required:"Name is required"},
                phone:{required:"Phone  is reqired"},        
                description:{required:"Description  is reqired"},        
                address:{required:"Address  is reqired"}        
             }
});
</script>
@endpush

