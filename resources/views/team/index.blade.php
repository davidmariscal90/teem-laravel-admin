@extends('layouts.app')
@section('title', 'Team')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Teams</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Teams List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Teams</h5>
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
                                <th>Username</th>  
                                <th>Team name</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Username</th>  
                                <th>Team name</th>
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
    var teamDataTable = $('#sporttable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        "bRetrieve": true,
        responsive: true,
        "sAjaxSource": '{!! url('/team/data') !!}',
         "aoColumns": [
             {"mData": 'matchdetail.sportcenterdetail.name'},
            {"mData": 'matchdetail.sportcenterdetail.address'},
            {"mData": 'userdetail.username'},
            {"mData": 'teamid'}
               
         ],
       
           "aaSorting": [[0, "asc"]],
    });

</script>
@endpush