@extends('layouts.app')
@section('title', 'Pitch')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Pitch & Sportcenter</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Pitch & Sportcenter List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                            <h2>Pitch & Sportcenter</h2>
                            <div class="input-group">
                                <input type="text" placeholder="Search Pitch & Sportcenter " class="input form-control" id="searchData">
                                <span class="input-group-btn">
                                        <button type="button" class="btn btn btn-primary" id="search"> <i class="fa fa-search"></i> Search</button>
                                </span>
                            </div>
                            <div class="clients-list">
                            <ul class="nav nav-tabs">
                                <span class="pull-right small text-muted"></span>
                                <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"><i class="fa fa-user"></i> Pitch</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false"><i class="fa fa-briefcase"></i> Sportcenter</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                 <div class="full-height-scroll">
                                     <div class="table-responsive">
                                       <table class="table table-striped table-hover" id="fieldtable" style="width:100% !important">
                                            <thead style="display:none">
                                                <tr>
                                                    <td>User Image</td>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Sportcenter name</th>
                                                    <th>Sportcenter address</th>
                                                    <th>Sports</th>
                                                    <th class="actionTag">#</th>
													<th class="actionTag">#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot style="display:none">
                                                <tr>
                                                   <td>User Image</td>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Sportcenter name</th>
                                                    <th>Sportcenter address</th>
                                                    <th>Sports</th>
                                                    <th class="actionTag">#</th>
													<th class="actionTag">#</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                  </div>
                                   </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                 <div class="full-height-scroll">
                                        <div class="table-responsive">
										<table class="table table-striped table-hover" id="sportcentertable" style="width:100% !important">
                                            <thead style="display:none">
                                                <tr>
                                                    <td>User Image</td>
                                                    <th>Username</th>
                                                    <th>Sportcenter name</th>
                                                    <th>Sportcenter address</th>
                                                    <th>Phone</th>
                                                    <th>Description</th>
                                                    <th class="actionTag">#</th>
													<th class="actionTag">#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot style="display:none">
                                                <tr>
                                                    <td>User Image</td>
                                                    <th>Username</th>
                                                    <th>Sportcenter name</th>
                                                    <th>Sportcenter address</th>
                                                    <th>Phone</th>
                                                    <th>Description</th>
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
        </div>
    </div>
    </div>
    
@endsection

@push("scripts")
<script type="text/javascript">
var tab="Pitch";
$(document).ready(function(){
         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                    }
                });
    var fieldDataTable = $('#fieldtable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        responsive: true,
        searching: false, 
        paging: false,
        info:false,
        "sAjaxSource": '{!! url('/field/data') !!}',
        "oLanguage": {
        "sProcessing": ""
         },
         "fnServerParams": function (aoData) {
            var searchData=$("#searchData").val();
             aoData.push(
                        {"name": "searchdata", "value": searchData}
                        );
        },
         "aoColumns": [
            {"mData": 'sportcenterdetail.userdetail[0].profileimage',
            "className":"client-avatar",
            "mRender": function (o) {
				if(o=="")
					return "<img alt='image' src='./image/sidebar_photo.png' >";
				else
					return "<img alt='image' src='{{ env('SERVER_URL') }}upload/profiles/"+o+"'> ";
            }
            },
            {"mData": 'name'},
            {"mData": 'price'},
            {
				"mData": 'sportcenterdetail.name',
				"mRender": function (o) {
					if(!o)
						return "";
					else
						return o; 	
				}
			},
            {
				"mData": 'sportcenterdetail.address',"className":"cellwidth",
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
                //console.log(o);
               	 return "<a href='javascript:void(0)'  title='Delete'  id='fielddelete' data-id="+o._id+" ><i class='fa fa-trash'></i></a>";
            }
			},
			 {
				 "mData": null,
           "mRender": function (o) {
                //console.log(o);
                return "<a href=''><span class='label label-primary'>Active</span></a>";
            }
			}
               
         ],
         "aoColumnDefs": [
           {"bSortable": false, "aTargets": [0]},
           {"bSortable": false, "aTargets": [1]},
           {"bSortable": false, "aTargets": [2]},
           {"bSortable": false, "aTargets": [3]},
           {"bSortable": false, "aTargets": [4]},
           {"bSortable": false, "aTargets": [5]},
		    {"bSortable": false, "aTargets": [6]}
         ]
    });

    $("#search").click(function(){
		if(tab.trim()=="Pitch")
        	fieldDataTable.draw(false);
			
		
		if(tab.trim()=="Sportcenter"){
			sportcenterDataTable.draw(false);
		}

    });

	var sportcenterDataTable = $('#sportcentertable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        responsive: true,
        searching: false, 
        paging: false,
        info:false,
        "sAjaxSource": '{!! url('/field/sportcenter/data') !!}',
        "oLanguage": {
        "sProcessing": ""
         },
         "fnServerParams": function (aoData) {
            var searchData=$("#searchData").val();
             aoData.push(
                        {"name": "searchdata", "value": searchData}
                        );
        },
         "aoColumns": [
            {
				"mData": 'userdetail.profileimage',
            	"className":"client-avatar",
            	"mRender": function (o) {
					if(o=="")
					return "<img alt='image' src='./image/sidebar_photo.png' >";
					else
					return "<img alt='image' src='{{ env('SERVER_URL') }}upload/profiles/"+o+"'> ";

               }
            },
            {"mData": 'userdetail.username',
				"mRender": function (o) {
					if(!o)
						return "";
					else
						return o; 	
				}
			},
            {"mData": 'name'},
            {"mData": 'address',"className":"cellwidth",
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
                //console.log(o);
                	 return "<a href='javascript:void(0)'  title='Delete'  id='sportcenterdelete' data-id="+o._id+" ><i class='fa fa-trash'></i></a>";
            }
			},
			{
				"mData": null,
           		"mRender": function (o) {
					   console.log(o)
                	return "<a href=''><span class='label label-primary'>Active</span></a>";
            	}
			}

			
         ],
         "aoColumnDefs": [
           {"bSortable": false, "aTargets": [0]},
           {"bSortable": false, "aTargets": [1]},
           {"bSortable": false, "aTargets": [2]},
           {"bSortable": false, "aTargets": [3]},
           {"bSortable": false, "aTargets": [4]},
           {"bSortable": false, "aTargets": [5]},
           {"bSortable": false, "aTargets": [6]},
           {"bSortable": false, "aTargets": [7]}
         ]
    });
	
	$('.nav-tabs a').on('shown.bs.tab', function(event){
    	tab = $(event.target).text();         
   });
   
   	$('#searchData').on("keypress", function(e) {
        if (e.keyCode == 13) {
		   $("#search").trigger("click");
        }
	});

	 $(document).on('click','#fielddelete',function(e){
            if(confirm("Are you sure you want to delete this field?")==true){
            var id=$(this).data("id");
            var deleteUrl = '{!!  url('field')  !!}/'+id
                 $.ajax({
            url:deleteUrl,
            type: 'delete',
            dataType: 'json',
            success:function(data){
                toastrDisplay("success",data['message']);

                fieldDataTable.draw(false);
            },
            error:function(err){
				console.log("err",err);
                toastrDisplay("error",err['message']);
            }
        });
             }
        });

		 $(document).on('click','#sportcenterdelete',function(e){
            if(confirm("Are you sure you want to delete this sportcenter?")==true){
				var id=$(this).data("id");
				var deleteUrl = '{!!  url('/field/sportcenter/destroy')  !!}/'+id
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
						toastrDisplay("error",err['message']);
					}
				});
        	}
        });

});
   
</script>

@endpush