@extends('layouts.app')
@section('title', 'Sport')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Sport</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Sport List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Sport</h5>
                    <div class="ibox-tools">
                        <a id="addUser1" href="{{ url('/sport/create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " >
                <div class=""> 
                    <table class="table table-bordered dataTable no-footer dtr-inline" id="sporttable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th class="actionTag">#</th>
                                <th class="actionTag">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                <th>Name</th>
                                 <th>Image</th>
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

@if(Session::has('addsport'))
    <script> toastrDisplay("success","{{ Session::get('addsport') }}"); </script>
@endif

<script type="text/javascript">

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                    }
                });
    var sportDataTable = $('#sporttable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        "bRetrieve": true,
        responsive: true,
        "sAjaxSource": '{!! url('/sport/data') !!}',
         "aoColumns": [
             {"mData": 'title'},
            {"mData": 'imageurl'},
            {
                "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
                 return "<a href='sport/"+o._id+"/edit'  id='edituser' title='edit' ><i class='fa fa-edit'></i></a>";
                }
              }, 
               {
              "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
                     return "<a href='javascript:void(0)'  title='Delete'  id='sportdelete' data-id="+o._id+"  ><i class='fa fa-trash'></i></a>";
                }
              }, 
         ],
          "aoColumnDefs": [
           {"bSortable": false, "aTargets": [3]},
           {"bSortable": false, "aTargets": [2]}
         ],
           "aaSorting": [[0, "asc"]],
    });

     $(document).on('click','#sportdelete',function(e){
            if(confirm("Are you sure you want to delete this sport?")==true){
            var id=$(this).data("id");
            var deleteUrl = '{!!  url('sport')  !!}/'+id
                 $.ajax({
            url:deleteUrl,
            type: 'delete',
            dataType: 'json',
            success:function(data){
                toastrDisplay("success",data['message']);

                sportDataTable.draw(false);
            },
            error:function(err){
                toastrDisplay("error",err['message']);
            }
        });
             }
        });
</script>
@endpush