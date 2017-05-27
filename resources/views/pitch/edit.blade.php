@extends('layouts.app')
@section('title', 'Edit pitch')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Pitch</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('/field') }}">Pitch</a>
            </li>
            <li class="active">
                Edit Pitch
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Edit Pitch</h5>
                </div>
                <div class="ibox-content " >
                {{ Form::model($field,['method' => 'PATCH','route' => ['pitch.update', $field->_id],'class'=>"form-horizontal","name"=>"editpitch"]) }}
                    
                    @include('pitch/_form')

                   <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                                <a href="{{ url('/pitch') }}" class="btn btn-danger">
                                    Cancel
                                </a>
                            </div>
                        </div> 
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push("scripts")

@if(Session::has('pitcherr'))
    <script> toastrDisplay("error","{{ Session::get('pitcherr') }}"); </script>
@endif

<script type="text/javascript">
$(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

				$('#addMore').click(function(){
					var wrapper = $("#select-wrapper").clone().appendTo("#sportsSelect");
					var btnminus = wrapper.find(".addMore").remove();
					wrapper.find("#bt").append("<button id='btn-remove' type='button' class='btn btn-primary'><i class='fa fa-minus'></i></button>");
				});
				 $("#sportsSelect").on("click","#btn-remove", function(e){ //user click on remove text
				 	e.preventDefault();
					var md2 = $(this).parent();
					var selectWrapper = $(md2).parent();
					selectWrapper.remove();
				});


            });

	$("form[name='editpitch']").validate({
             rules: {
                sportcenter:"required",
                name:"required",
                covering:"required",
                lights:"required",
                surface:"required",
                sport:"required",
                price:"required",
             },
              messages:{
				sportcenter: {required:"Sport Centre is required"},
                name: {required:"Name is required"},
                covering:{required:"Covering is reqired"},    
                lights:{required:"Lights is reqired"},
                surface:{required:"Surface is reqired"},
                sport:{required:"Sport is reqired"},
                price:{required:"Price is reqired"}
             }
	});

</script>
@endpush

