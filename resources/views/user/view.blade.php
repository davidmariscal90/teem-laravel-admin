@extends('layouts.app')
@section('title', 'User')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Users</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Users Detail
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Users</h5>
                    <div class="ibox-tools">
                        <a id="addUser1" href="{{ url('/activity') }}">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
						 
						 <div class="row">
						 <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-sm-2 col-sm-2 control-label">Firstname</label>
                            <div class="col-md-9">
								<div class="form-control">{{ $userDetails[0]->firstname }}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-sm-2 col-sm-2 control-label">Lastname</label>        
                            <div class="col-md-9">
                                <div class="form-control">{{ $userDetails[0]->lastname }}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-sm-2 col-sm-2 control-label">Username</label>
                            <div class="col-md-9">
                            	<div class="form-control"> {{ $userDetails[0]->username }}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-sm-2 control-label">Email</label>
                            <div class="col-md-9">
                                <div class="form-control">email</div>
                            </div>
                        </div>

                       
                        <div class="form-group row">
                             <label class="col-sm-2 col-sm-2 control-label">City</label>     
                            <div class="col-md-9">
                               <div class="form-control"> {{ $userDetails[0]->city }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                             <label class="col-sm-2 col-sm-2 control-label">Description</label>     
                            <div class="col-md-9">
                              <div class="form-control"> {{ $userDetails[0]->description }}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                        	<label class="col-sm-2 col-sm-3 control-label">Account</label>     
                            <div class="col-md-9">
                               	<div class=""> 
								   @if($userDetails[0]->isactive)
									   <label class="label label-primary">Active</label>
								   @else
									   <label class="label label-danger">Inactive</label>
								   @endif
								</div>
                            </div>
                     	</div>  
						 </div>
						 <div class="col-md-3">
						 	<img class="img-thumbnail" src= {{ env('SERVER_URL').'upload/profiles/'.$userDetails[0]->profileimage }} />
						 </div>
						 </div>    
					</div>
			</div>
		</div>
	</div>
</div>
@endsection
