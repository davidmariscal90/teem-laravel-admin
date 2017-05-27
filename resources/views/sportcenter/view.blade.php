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
                Sportcentre Details
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
                        <a id="addUser1" href="{{ url('/activity') }}">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
					<div class="form-group row">
						<label class="col-sm-2 col-sm-2 control-label">Name</label>
						<div class="col-md-6">
							<div class="form-control">{{ $sportCentreDetails[0]->name }}</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-sm-2 control-label">Phone</label>
						<div class="col-md-6">
							<div class="form-control">{{ $sportCentreDetails[0]->phone }}</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-sm-2 control-label">Description</label>
						<div class="col-md-6">
							<div class="form-control">{{ $sportCentreDetails[0]->description }}</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-sm-2 control-label">Address</label>
						<div class="col-md-6">
							<div class="form-control">{{ $sportCentreDetails[0]->address }}</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-sm-2 control-label"></label>
						<div class="col-md-6">
							<div id="map" ></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push("scripts")
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDD7oo0yCjyp2pIBLbRr_h3b0_NiMXXu3g&libraries=places&callback=initAutocomplete"
         async defer></script>
<script type="text/javascript">

	function initAutocomplete() {
		var initlat = 40.415363;
		var initlng = -3.707398;
		var lat={{ $sportCentreDetails[0]->lat }};
		var long={{ $sportCentreDetails[0]->long }};
		// setting marker coordinate to display on map when record update
		if (lat!="" && long!="") {
			initlat = parseFloat(lat);
			initlng = parseFloat(long);
		}
		// setting map from here for update record manually
		var map = new google.maps.Map(document.getElementById('map'), {
			center: { lat: initlat, lng: initlng },
			zoom: 16,
			mapTypeId: 'roadmap'
		});
		var myMarker = new google.maps.Marker({
			position: { lat: initlat, lng: initlng },
			draggable: false,
			animation: google.maps.Animation.DROP,
			map: map
		});
	}
</script>	
@endpush	