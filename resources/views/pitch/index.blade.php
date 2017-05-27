@extends('layouts.app')
@section('title', 'Team')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Pitch</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Pitch List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Pitchs</h5>
                    <div class="ibox-tools">
                        <a id="addUser1" href="{{ url('pitch/create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " >
                <div class=""> 
                    <table class="table table-bordered dataTable no-footer dtr-inline" id="pitchtable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Covering</th>
                                <th>Lights</th>
                                <th>Surface</th>
                                <th>Price</th>
                                <th>Sports Centre</th>
                                <th>Sports</th>
                                <th class="actionTag">#</th>
                                <th class="actionTag">#</th>
                                <th class="actionTag">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                <th>Name</th>
                                <th>Covering</th>
                                <th>Lights</th>
                                <th>Surface</th>
                                <th>Price</th>
                                <th>Sports Centre</th>
                                <th>Sports</th>
                                <th class="actionTag">#</th>
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

<script type="text/javascript">

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                    }
                });
    var pitchDataTable = $('#pitchtable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        "bRetrieve": true,
        responsive: true,
        "sAjaxSource": '{!! url('/pitch/data') !!}',
         "aoColumns": [
             {"mData": 'name'},
            {"mData": 'covering'},
            {"mData": 'lights'},
            {"mData": 'surface'},
            {"mData": 'price'},
            {"mData": 'sportcenterdetail.name',
			"mRender": function (o) {
				if(!o)
					return "";
				else
					return o;	
			}
			},
            {"mData": 'sport'},
			{
				"mData": null,
				"mRender": function (o) {
					if(o.ispublic==true)
						return "<a href='javascript:void(0)' data-status='Deactive' data-id="+o._id+" id='pitchactive'><span class='label label-primary'>Active</span></a>";
					else
						return "<a href='javascript:void(0)' data-status='Active' data-id="+o._id+" id='pitchactive'><span class='label label-danger'>Deactive</span></a>";	
						//return '<div class="switch"><div class="onoffswitch"><input class="onoffswitch-checkbox" data-status="Active""  data-id='+o._id+' id="sportcenteractive" name="isactive" type="checkbox" value="'+o.ispublic+'"><label class="onoffswitch-label" for="sportcenteractive"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div></div>'
				}
			},
			{
                "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
                 return "<a href='pitch/"+o._id+"/edit'  id='editpitch' title='edit' ><i class='fa fa-edit'></i></a>";
                }
              },
              {
              "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
                     return "<a href='javascript:void(0)'  title='Delete'  id='pitchdelete' data-id="+o._id+"  ><i class='fa fa-trash'></i></a>";
                }
              }
               
         ],
		 "aoColumnDefs": [
             {"bSortable": false, "aTargets": [6]},
             {"bSortable": false, "aTargets": [7]},
             {"bSortable": false, "aTargets": [8]},
             {"bSortable": false, "aTargets": [9]},
         ],
        "aaSorting": [[0, "asc"]],
    });

	//************** PITCH ACTIVE **********************

		$(document).on('click','#pitchactive',function(e){
			var status=$(this).data("status");
            if(confirm("Are you sure you want to "+status+" this pitch?")==true){
				var id=$(this).data("id");
				var url = '{!!  url('/pitch/active')  !!}/'+id
				$.ajax({
					url:url,
					type: 'get',
					dataType: 'json',
					success:function(data){
						toastrDisplay("success",data['message']);
						pitchDataTable.draw(false);
					},
					error:function(err){
						console.log("err",err);
						toastrDisplay("error",err['message']);
					}
				});
        	}else{
				if($(this).is(':checked'))
					$(this).prop('checked', false);
				else
					$(this).prop('checked', true);	
			}
        });

		//************** PITCH DELETE **********************

		$(document).on('click','#pitchdelete',function(e){
            if(confirm("Are you sure you want to delete this field?")==true){
            var id=$(this).data("id");
            var deleteUrl = '{!!  url('field')  !!}/'+id
                 $.ajax({
            url:deleteUrl,
            type: 'delete',
            dataType: 'json',
            success:function(data){
                toastrDisplay("success",data['message']);

                pitchDataTable.draw(false);
            },
            error:function(err){
				console.log("err",err);
                toastrDisplay("error",err['message']);
            }
        });
             }
        });

</script>
@endpush