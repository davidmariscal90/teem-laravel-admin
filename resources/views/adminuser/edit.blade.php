@extends('layouts.app')
@section('title', 'Main page')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Admin User</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/admin') }}">Admin</a>
            </li>
            <li class="active">
                Edit Admin User
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Admin User</h5>
                </div>
                <div class="ibox-content">
                
                {{  Form::model($adminuser, ['method' => 'PATCH','route' => ['admin.update', $adminuser->_id],'class'=>"form-horizontal","name"=>"editadmin"]) }}
                    
                    @include('adminuser/_form')

                   <div class="form-group">
                            <div class="col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ url('/admin') }}" class="btn btn-danger">
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

@if(Session::has('addadminerr'))
    <script> toastrDisplay("error","{{ Session::get('addadminerr') }}"); </script>
@endif

<script type="text/javascript">
$("form[name='editadmin']").validate({
             rules: {
                name:"required",
                 email:{
                    required:true,
                    email:true,
                },
             },
              messages:{
                name: {required:"Name is required"},
                email: {
                            required:"Email is required",
                            'email': 'Email is not valid'
                        }
             }
});
</script>
@endpush

