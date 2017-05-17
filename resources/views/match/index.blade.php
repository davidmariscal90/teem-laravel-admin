@extends('layouts.app')
@section('title', 'Match')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Match</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Match List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Match</h5>
                    <div class="ibox-tools">
                        {{-- <a id="addUser1" href="{{ url('') }}">
                            <i class="fa fa-plus"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="ibox-content " >
                <div class=""> 
                    <table class="table table-bordered dataTable no-footer dtr-inline" id="sporttable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
								<th>Sport name</th>
								<th>Subsport name</th>
                                <th>Match date</th>
                                <th>Benchplayers</th>
								<th>Username</th>  
                                <th>Payment</th>
								<th class="actionTag">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                <th>Name</th>
                                <th>Address</th>
								<th>Sport name</th>
								<th>Subsport name</th>
                                <th>Match date</th>
								<th>Benchplayers</th>
                                <th>Username</th>  
                                <th>Payment</th>
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
    var matchDataTable = $('#sporttable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        "bRetrieve": true,
        responsive: true,
        "sAjaxSource": '{!! url('/match/data') !!}',
         "aoColumns": [
             {"mData": 'sportcenterdetail.name'},
            {"mData": 'sportcenterdetail.address'},
            {"mData": 'sportdetail.title'},
            {"mData": 'subsportdetail.title'},
            {"mData": 'matchtime'},
            {"mData": 'benchplayers',"sWidth":"5%"},
            {"mData": 'userdetail.username'},
            {
                 "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
					console.log(o);
					if(o.paymenttype=="free")
                     return "FREE";
					else
						return o.currency+" "+o.price; 
                }
			},
			 {
                 "mData": null,
                "sWidth": "5%",
                "mRender": function (o) {
					return "<a href='javascript:void(0)'  title='Delete'  id='matchdelete' data-id="+o._id+"   ><i class='fa fa-trash'></i></a>";
			    }
			}
               
         ],
		  "aoColumnDefs": [
           {"bSortable": false, "aTargets": [8]}
         ],

		   "aaSorting": [[0, "asc"]],
    });

	 $(document).on('click','#matchdelete',function(e){
            if(confirm("Are you sure you want to delete this match?")==true){
            var id=$(this).data("id");
            var deleteUrl = '{!!  url('match')  !!}/'+id 
				$.ajax({
					url:deleteUrl,
					type: 'delete',
					dataType: 'json',
					success:function(data){
						toastrDisplay("success",data['message']);

						matchDataTable.draw(false);
					},
					error:function(err){
						toastrDisplay("error",err['message']);
					}
				});
             }
        });

</script>
@endpush