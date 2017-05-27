@extends('layouts.app')
@section('title', 'Activity')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Activity</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Activity List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Activity</h5>
                    {{-- <div class="ibox-tools">
                        <a id="" href="{{ url('sportcenter/create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div> --}}
                </div>
				
                <div class="ibox-content" >
				<div id="pitchtable_length">
					<label>Show entries
						<select id="activityLength" class="form-control input-sm">
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select> 
					</label>
				</div>
                <div class="activity-container"> 
                   {{-- <table class="table table-bordered dataTable no-footer dtr-inline" id="activitytable">
                                            <thead>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>Date</th>
                                                    <th>Activity Type</th>
                                                    <th>On</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>Date</th>
                                                    <th>Activity Type</th>
                                                    <th>On</th>
                                                </tr>
                                            </tfoot>
                                        </table> --}}
                </div>
					{{-- <div class="stream-small"> --}}
					{{-- @if ($activity->activitytype == "added")
						<span class="label label-primary"> {{$activity->activitytype}}</span>
					@endif
					@if ($activity->activitytype == "updated")
						<span class="label label-warning"> {{$activity->activitytype}}</span>
					@endif
						<span class="text-muted"> {{$activity->activitydate}} </span> / <a href="#">{{$activity->userdetail[0]->username}}</a>  @if ($activity->activitytype == "added")Added new @else Updated @endif {{$activity->onitem}} --}}
					{{-- </div> --}}
					<div id="show_paginator">
						{{-- <nav aria-label="Page navigation example">
							<ul class="pagination">
								<li class="page-item"><a class="page-link" href="#">Previous</a></li>
								<li class="page-item"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item"><a class="page-link" href="#">Next</a></li>
							</ul>
						</nav> --}}
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

	var resultData;
	var count=1;
	var actLen = 10;
	function getActivities(nextPageno){
		
		$.ajax({
			url: '{!!  url('/activity/data/page')  !!}'+"/"+nextPageno+"/"+actLen,
			success: function(result){
				resultData = result;
				$(".activity-container").html('');
				for(var activity of result.activities){
					var data = "<div class='stream-small'>";
					if (activity.activitytype == "added"){
						data += "<span class='label label-primary'>" + activity.activitytype + "</span>";
						data += "<span class='text-muted'>" + activity.activitydate + "</span> / <a href=users/view/"+activity.userdetail[0]._id.$oid + ">" + activity.userdetail[0].username + "</a> Added new ";
						if(activity.onitem == "sportcenter")
							data += "<a href=sportcenter/view/"+activity.onactivityid + " > " + activity.onitem + " </a>";
						else
							data+= activity.onitem + " ";
					}
					else if (activity.activitytype == "updated"){
						data += "<span class='label label-warning'>" + activity.activitytype + "</span>";
						data += "<span class='text-muted'>" + activity.activitydate + "</span> / <a href=users/view/"+activity.userdetail[0]._id.$oid + ">" + activity.userdetail[0].username + "</a> Updated ";
						if(activity.onitem == "sportcenter")
							data += "<a href=sportcenter/view/"+activity.onactivityid + " > " + activity.onitem + " </a>";
						else
							data+= activity.onitem + " ";
					}
					else if (activity.activitytype == "received"){
						data += "<span class='label label-warning'>" + activity.activitytype + "</span>";
						data += "<span class='text-muted'>" + activity.activitydate + "</span> / <a href=users/view/"+activity.userdetail[0]._id.$oid + ">" + activity.userdetail[0].username + "</a> received "+ activity.onitem;
					}
					else {
						data += "<span class='label label-info'>" + activity.activitytype + "</span>";
						data += "<span class='text-muted'>" + activity.activitydate + "</span> / <a href=users/view/"+activity.userdetail[0]._id.$oid + ">" + activity.userdetail[0].username + "</a> "+ activity.activitytype + " " + activity.onitem;
					}

					data += "</div>";
					$(".activity-container").append(data);
					
				}
				//$('#show_paginator').twbsPagination('destroy');
				pagination2();
			}
		});
	}
	function pagination2() {
		console.log("resultData = ",resultData);
		console.log("Math.ceil(resultData.totalCount/actLen) = ",Math.ceil(resultData.totalCount/actLen));
		$('#show_paginator').twbsPagination({
			totalPages: Math.ceil(resultData.totalCount/actLen),
			visiblePages: 5,
			startPage: 1,
			onPageClick: function (event, page) {
				getActivities(page);
			}
		});

	}
	getActivities(1);
	$("#activityLength").on('change', function() {
		console.log("select val = ", this.value);
		actLen = this.value;
		$('#show_paginator').twbsPagination('destroy');
		getActivities(1);
	});
    
</script>
@endpush