@extends('layouts.app')
@section('title', 'Sportcentre')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Sportcentre</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Sportcentre List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Sportcentre</h5>
                    <div class="ibox-tools">
                        <a id="" href="{{ url('sportcenter/create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content " >
                <div class=""> 
                   <table class="table table-striped table-bordered table-hover" id="sportcentertable" style="width:100% !important">
                                            <thead>
                                                <tr>
                                                    {{-- <td>User Image</td> --}}
                                                    <th>Username</th>
                                                    <th>Sportcentre name</th>
                                                    <th>Sportcentre address</th>
                                                    <th>Phone</th>
                                                    <th>Description</th>
                                                    <th class="actionTag">#</th>
													<th class="actionTag">#</th>
													<th class="actionTag">#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    {{-- <td>User Image</td> --}}
                                                    <th>Username</th>
                                                    <th>Sportcentre name</th>
                                                    <th>Sportcentre address</th>
                                                    <th>Phone</th>
                                                    <th>Description</th>
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

@if(Session::has('sportcenter'))
    <script> toastrDisplay("success","{{ Session::get('sportcenter') }}"); </script>
@endif

<script type="text/javascript">

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                    }
                });

    var sportcenterDataTable = $('#sportcentertable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        "bRetrieve": true,
        responsive: true,
        
        "sAjaxSource": '{!! url('/sportcenter/data') !!}',
         "aoColumns": [
            /*{
				"mData": 'userdetail.profileimage',
            	"className":"client-avatar",
            	"mRender": function (o) {
					if(o=="")
						return "<img alt='image' src='./image/sidebar_photo.png' >";
					else
						return "<img alt='image' src='{{ env('SERVER_URL') }}upload/profiles/"+o+"'> ";

               }
            }, */
            {"mData": 'userdetail.username',
				"mRender": function (o) {
					if(!o)
						return "";
					else
						return o; 	
				}
			},
            {"mData": 'name'},
            {"mData": 'address',
				"mRender": function (o) {
					if(!o)
						return "";
					else
						return o; 	
				}
			},
            {"mData": 'phone'},
            {"mData": 'description'},
            {
				 "mData": null,
           		"mRender": function (o) {
                console.log(o);
				if(o.ispublic==true)
				//return '<div class="switch"><div class="onoffswitch"><input class="onoffswitch-checkbox" data-status="Deactive"" checked onchange="sportcenterActive(a,Deactive)"  id="sportcenteractive" name="isactive" type="checkbox" value="'+o.ispublic+'"><label class="onoffswitch-label" for="sportcenteractive"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div></div>'
                	return "<a href='javascript:void(0)' data-status='Deactive' data-id="+o._id+" id='sportcenteractive'><span class='label label-primary'>Active</span></a>";
				else
					//return '<div class="switch"><div class="onoffswitch"><input class="onoffswitch-checkbox" data-status="Active""  data-id='+o._id+' id="sportcenteractive" name="isactive" type="checkbox" value="'+o.ispublic+'"><label class="onoffswitch-label" for="sportcenteractive"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label></div></div>'
					return "<a href='javascript:void(0)' data-status='Active' data-id="+o._id+" id='sportcenteractive'><span class='label label-danger'>Deactive</span></a>";	
					
            }
			},
			{
                "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
                 return "<a href='sportcenter/"+o._id+"/edit'   title='edit' ><i class='fa fa-edit'></i></a>";
                }
            }, 
			{
				"mData": null,
           		"mRender": function (o) {
                //console.log(o);
                	 return "<a href='javascript:void(0)'  title='Delete'  id='sportcenterdelete' data-id="+o._id+" ><i class='fa fa-trash'></i></a>";
            }
			},

			
         ],
         "aoColumnDefs": [
           {"bSortable": false, "aTargets": [5]},
           {"bSortable": false, "aTargets": [6]},
           {"bSortable": false, "aTargets": [7]}
         ]
    });

	 $(document).on('click','#sportcenterdelete',function(e){
            if(confirm("Are you sure you want to delete this sportcenter?")==true){
				var id=$(this).data("id");
				var deleteUrl = '{!!  url('sportcenter')  !!}/'+id
				$.ajax({
					url:deleteUrl,
					type: 'delete',
					dataType: 'json',
					success:function(data){
						toastrDisplay("success",data['message']);
						sportcenterDataTable.draw(false);
					},
					error:function(err){
						console.log("err",err);
						toastrDisplay("error",'Sportcenter not delete');
					}
				});
        	}
        });
		//************** SPORTCENTER ACTIVE **********************

		$(document).on('click','#sportcenteractive',function(e){
			var status=$(this).data("status");
			var id=$(this).data("id");
			
            if(confirm("Are you sure you want to "+status+" this sportcenter?")==true){
				
				var url = '{!!  url('/sportcenter/actives')  !!}/'+id
				$.ajax({
					url:url,
					type: 'get',
					dataType: 'json',
					success:function(data){
						toastrDisplay("success",data['message']);
						sportcenterDataTable.draw(false);
					},
					error:function(err){
						console.log("err",err);
						toastrDisplay("error","Someting went wrong try again");
					}
				});
        	}
        }); 

</script>
@endpush