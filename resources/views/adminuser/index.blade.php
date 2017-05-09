@extends('layouts.app')
@section('title', 'Admin')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Admin User</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Admin User List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Admin User</h5>
                    <div class="ibox-tools">
                        <a id="addUser1" href="{{ url('/admin/create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " >
                <div class=""> 
                    <table class="table table-striped table-hover"  id="admintable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                 <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                  <th>#</th>
                                <th>Name</th>
                                 <th>Email</th>
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

@if(Session::has('addadmin'))
    <script> toastrDisplay("success","{{ Session::get('addadmin') }}"); </script>
@endif

<script type="text/javascript">

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                    }
                });
    var adminDataTable = $('#admintable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        "bRetrieve": true,
       "sAjaxSource": '{!! url('/admin/data') !!}',
         "aoColumns": [
             {
                "mData": null,
                "sWidth": "10%",
              "mRender": function (o) {
                  console.log('a',o._id);
                  
                 return "<a href='admin/"+o._id+"/edit' class='edituser' id='edituser' title='edit' ><i class='fa fa-edit'></i></a>&nbsp;<a href='javascript:void(0)' data-toggle='tooltip' title='Deactivated' class='edituser' id='admindelete' data-id="+o._id+"  pkuid = "+ o.DT_RowId +" ><i class='fa fa-trash'></i></a>";
              }
              },
               {"mData": "name"}, 
               {"mData": "email"} 
         ],
         "aoColumnDefs": [
             {"bSortable": false, "aTargets": [0]},
         ],
           "aaSorting": [[1, "asc"]],
    });

     $(document).on('click','#admindelete',function(e){
            if(confirm("Are you sure you want to delete this admin?")==true){
            var id=$(this).data("id");
            var deleteUrl = '{!!  url('admin')  !!}/'+id
                 $.ajax({
            url:deleteUrl,
            type: 'delete',
            dataType: 'json',
            success:function(data){
                toastrDisplay("success",data['message']);

                adminDataTable.draw(false);
            },
            error:function(err){
                toastrDisplay("error",err['message']);
            }
        });
             }
        });
</script>
@endpush