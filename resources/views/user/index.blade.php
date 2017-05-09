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
                Users List
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
                        <a id="addUser1" href="#">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " >
                <div class="table-responsive"> 
                    <table class="table table-striped table-hover"  id="usertable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                 <th>Email</th>
                                <!--<th>Profileimage</th>-->
                                <th>Active</th>
                                <th>Birthdate</th>
                                <th>City</th>
                               <th>Description</th>
                                <th>sports</th>
                                <th>ActivateDate</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                             <th>#</th>
                                <th>Username</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                 <th>Email</th>
                                <!--<th>Profileimage</th>-->
                                <th>Active</th>
                                <th>Birthdate</th>
                                <th>City</th>
                               <th>Description</th>
                                <th>sports</th>
                                <th>ActivateDate</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@push("scripts")
<script type="text/javascript">

    $('#usertable').DataTable({
        processing: true,
        serverSide: true,
       "sAjaxSource": '{!! url('/users/data') !!}',
         "aoColumns": [
             {
                "mData": null,
                "sWidth": "10%",
              "mRender": function (o) {
                 return "<a href='#' class='edituser' id='edituser' data-id="+o._id+" data-toggle='modal' data-target='#myModalHorizontal' pkuid = "+ o.DT_RowId +" data-toggle='tooltip' title='edit' ><i class='fa fa-edit'></i></a><a href='javascript:void(0)' data-toggle='tooltip' title='Deactivated' class='edituser' id='suspend' data-id="+o._id+"  pkuid = "+ o.DT_RowId +" ><i class='fa fa-trash'></i></a>";
              }
              },
               {"mData": "username"}, 
               {"mData": "firstname"}, 
               {"mData": "lastname"}, 
               {"mData": "email"}, 
            //    {"mData": "profileimage"}, 
               {"mData": "isactive"}, 
               {"mData": "dob"}, 
               {"mData": "city"}, 
               {"mData": "description"}, 
               {"mData":"sports"},
               {"mData": "activateddate"}, 
         ],
         "aoColumnDefs": [
             {"bSortable": false, "aTargets": [0]},
         ],
           "aaSorting": [[1, "asc"]],
    });
</script>
@endpush