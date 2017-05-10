@extends('layouts.app')
@section('title', 'User')
@section('content')
<style>

</style>
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
                <div class=""> 
                    <table class="table table-bordered dataTable no-footer dtr-inline"  id="usertable">
                        <thead>
                            <tr>
                                 <th>Name</th>
                                <th>Username</th>
                                 <th>Email</th>
                                <th>Active</th>
                                <th>ActivateDate</th>
                                <th>#</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                <th>Name</th>
                                <th>Username</th>
                                 <th>Email</th>
                                <th>Active</th>
                                <th>ActivateDate</th>
                                <th>#</th>
                                <th>#</th>
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
        "bStateSave": true,
        "bRetrieve": true,
        responsive: true,
       "sAjaxSource": '{!! url('/users/data') !!}',
         "aoColumns": [
             {
                "mData": null,
                
                "mRender": function (o) {
                 return o.firstname + " "+o.lastname;
                }
              }, 
               {"mData": "username"}, 
               {"mData": "email"}, 
               {
                "mData": "isactive",
                "sWidth": "5%",
                "mRender":function(o){
                    if(o==true)
                        return "<i class='fa fa-circle active' aria-hidden='true'></i>";
                    else
                        return "<i class='fa fa-circle deactive' aria-hidden='true'></i>";    
                }
               }, 
               {"mData": "activateddate","sWidth": "10%"}, 
               {
                "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
                 return "<a href='user/"+o._id+"/edit' class='edituser' id='edituser' title='edit' ><i class='fa fa-edit'></i></a>";
                }
              }, 
               {
                "mData": null,
                "sWidth": "5%",
                "bSearchable":false,
                "mRender": function (o) {
                     return "<a href='javascript:void(0)' data-toggle='tooltip' title='Deactivated' class='edituser' id='admindelete' data-id="+o._id+"  pkuid = "+ o.DT_RowId +" ><i class='fa fa-trash'></i></a>";
                }
              }, 
         ],
         "aoColumnDefs": [
           {"bSortable": false, "aTargets": [0]},
           {"bSortable": false, "aTargets": [6]},
           {"bSortable": false, "aTargets": [5]},
         ],
           "aaSorting": [[2, "asc"]],
    });
</script>
@endpush