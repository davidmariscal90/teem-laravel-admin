@extends('layouts.app')
@section('title', 'Home')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Home</h2>
        <ol class="breadcrumb">
            <li>
                {{-- <a href="{{ url('/') }}">Home</a> --}}
            </li>
            <li class="active">
                Home
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Home</h5>
                </div>
                <div class="ibox-content " >
                <div class=""> 
                <h2>Welcome to Teemweb admin</h2>     
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

