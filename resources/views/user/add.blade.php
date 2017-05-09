@extends('layouts.app')
@section('title', 'Main page')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Users</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/user') }}">user</a>
            </li>
            <li class="active">
                Add User
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Add User</h5>
                </div>
                <div class="ibox-content " >
                {{ Form::open(['route' => 'user.store','class'=>"form-horizontal"]) }}
                    
                    @include('user/_form')

                   <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div> 
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


