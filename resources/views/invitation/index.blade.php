@extends('layouts.app')
@section('title', 'Invitation')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Invitation</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="active">
                Invitation List
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Invitation</h5>
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
                                <th>Match date</th>
                                <th>Sender username</th>  
                                <th>Receiver username</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Match date</th>
                                <th>Sender username</th>  
                                <th>Receiver username</th>
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
    var invitationDataTable = $('#sporttable').DataTable({
        processing: true,
        serverSide: true,
        "bRedraw": true,
        "bStateSave": true,
        "bRetrieve": true,
        responsive: true,
        "sAjaxSource": '{!! url('/invitation/data') !!}',
         "aoColumns": [
             {"mData": 'matchdetail.sportcenterdetail.name'},
            {"mData": 'matchdetail.sportcenterdetail.address'},
            {"mData": 'matchdetail.matchtime'},
            {"mData": 'senderuserdetail.username'},
            {"mData": 'receiveruserdetail.username'},
               
         ],
       
           "aaSorting": [[0, "asc"]],
    });

</script>
@endpush