@extends('layouts.app')
@section('title', 'User')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit User</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/user') }}">User</a>
            </li>
            <li class="active">
                Edit User
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit User</h5>
                </div>
                <div class="ibox-content">
                
               {{  Form::model($user, ['method' => 'PATCH','route' => ['user.update', $user->_id],'class'=>"form-horizontal","name"=>"edituser"]) }}
                    
                    @include('user/_form')

                   <div class="form-group">
                            <div class="col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ url('/user') }}" class="btn btn-danger">
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

@if(Session::has('addusererr'))
    <script> toastrDisplay("error","{{ Session::get('addusererr') }}"); </script>
@endif

<script type="text/javascript">
$("form[name='edituser']").validate({
             rules: {
                firstname:"required",
                lastname:"required",
                email:"required",
                city:"required",
                description:"required",
             },
              messages:{
                firstname: {required:"Firstname is required"},
                lastname:{required:"Lastname  is reqired"},        
                email:{required:"Email  is reqired"},        
                city:{required:"City  is reqired"},        
                description:{required:"Description  is reqired"}        
             }
});
</script>
@endpush

