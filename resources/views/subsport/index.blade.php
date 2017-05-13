@extends('layouts.app')
@section('title', 'Sport')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Subsport</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Subsport List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Subsport</h5>
                    <div class="ibox-tools">
                        <a id="addUser1" href="{{ url('/subsport/create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " >
                <div class=""> 
                    <table class="table table-bordered dataTable no-footer dtr-inline" id="subsporttable">
                        <thead>
                            <tr>
                                <th>Sportname</th>
                                <th>Title</th>
                                <th>Value</th>
                                <th class="actionTag">#</th>
                                <th class="actionTag">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                <th>Sportname</th>
                                <th>Title</th>
                                <th>Value</th>
                                 <th class="actionTag">#</th>
                                <th class="actionTag">#</th>
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

@if(Session::has('addsubsport'))
    <script> toastrDisplay("success","{{ Session::get('addsubsport') }}"); </script>
@endif

<script type="text/javascript">

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                    }
                });
    var subsportDataTable = $('#subsporttable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        "bRetrieve": true,
        responsive: true,
      "sAjaxSource": '{!! url('/subsport/data') !!}',
          "aoColumns": [
              {"mData": 'sportdetail.title'},
            {"mData": 'title'},
            {"mData": 'value', },
            {
                 "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
                 return "<a href='subsport/"+o._id+"/edit' class='edituser' id='edituser' title='edit' ><i class='fa fa-edit'></i></a>";
                }
              }, 
               {
                 "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
                     return "<a href='javascript:void(0)' data-toggle='tooltip' title='Deactivated' class='edituser' id='subsportdelete' data-id="+o._id+"  pkuid = "+ o.DT_RowId +" ><i class='fa fa-trash'></i></a>";
                }
              }, 
         ],
          "aoColumnDefs": [
           {"bSortable": false, "aTargets": [3]},
           {"bSortable": false, "aTargets": [4]}
         ],
           "aaSorting": [[0, "asc"]],
    });

     $(document).on('click','#subsportdelete',function(e){
            if(confirm("Are you sure you want to delete this subsport?")==true){
            var id=$(this).data("id");
            var deleteUrl = '{!!  url('subsport')  !!}/'+id
                 $.ajax({
            url:deleteUrl,
            type: 'delete',
            dataType: 'json',
            success:function(data){
                toastrDisplay("success",data['message']);

                subsportDataTable.draw(false);
            },
            error:function(err){
                toastrDisplay("error",err['message']);
            }
        });
             }
        });
</script>
@endpush