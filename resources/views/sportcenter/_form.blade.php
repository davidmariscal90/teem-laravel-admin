             <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-sm-2 col-sm-2 control-label">Name</label>
                            <div class="col-md-6">
                            {{ Form::text('name',null,['class'=>'form-control']) }}
                           
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
              </div>
			  <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-sm-2 col-sm-2 control-label">Phone</label>
                            <div class="col-md-6">
                            {{ Form::text('phone',null,['class'=>'form-control']) }}
                           
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
              </div>
			   <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-sm-2 col-sm-2 control-label">Description</label>
                            <div class="col-md-6">
                            {{ Form::text('description',null,['class'=>'form-control']) }}
                           
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
              </div>
			  <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="col-sm-2 col-sm-2 control-label">Address</label>
                            <div class="col-md-6">
                            {{ Form::text('address',null,['class'=>'form-control','id'=>'pac-input']) }}
                           
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
              </div>
			  {{ Form::hidden('lat',null,['class'=>'form-control','id'=>'lat']) }}
			  {{ Form::hidden('long',null,['class'=>'form-control','id'=>'long']) }}
			   <div class="form-group">
			    	<div class="col-sm-offset-2 col-md-6">
				  		<div id="map" ></div>
			 	 	</div>
			  </div>
			  
@push("scripts")
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDD7oo0yCjyp2pIBLbRr_h3b0_NiMXXu3g&libraries=places&callback=initAutocomplete"
         async defer></script>
<script type="text/javascript">

	function initAutocomplete() {
		var initlat = 40.415363;
		var initlng = -3.707398;
		var lat=$("#lat").val();
		var long=$("#long").val();
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
			draggable: true,
			animation: google.maps.Animation.DROP,
			map: map
		});

		// Create the search box and link it to the UI element.
		var input = document.getElementById('pac-input');
		var searchBox = new google.maps.places.SearchBox(input);

		// default marker array
		var markers = [];
		// pushing value for update sportcenter
		markers.push(myMarker);
		google.maps.event.addListener(markers[0], 'dragend', function () {
					map.setCenter(this.getPosition()); // Set map center to marker position
					lat = this.getPosition().lat();
					long = this.getPosition().lng();
					$("#lat").val(lat);
					$("#long").val(long);
				});
		// Listen for the event fired when the user selects a prediction and retrieve
		// more details for that place.
		searchBox.addListener('places_changed', function () {
			var places = searchBox.getPlaces();

			if (places.length == 0) {
				return;
			}

			// Clear out the old markers.
			markers.forEach(function (marker) {
				marker.setMap(null);
			});
			markers = [];

			// For each place, get the icon, name and location.
			var bounds = new google.maps.LatLngBounds();
			places.forEach(function (place) {
				if (!place.geometry) {
					console.log("Returned place contains no geometry");
					return;
				}
			
				// Create a marker for each place.
				markers.push(new google.maps.Marker({
					map: map,
					// icon: icon,
					title: place.name,
					draggable: true,
					animation: google.maps.Animation.DROP,
					position: place.geometry.location
				}));
				google.maps.event.addListener(markers[0], 'dragend', function () {
					map.setCenter(this.getPosition()); // Set map center to marker position
					lat = this.getPosition().lat();
					long = this.getPosition().lng();
					$("#lat").val(lat);
					$("#long").val(long);

				});

				var location = place.geometry.location;
				var lat = location.lat();
				var long = location.lng();
				$("#lat").val(lat);
				$("#long").val(long);

				if (place.geometry.viewport) {
					// Only geocodes have viewport.
					bounds.union(place.geometry.viewport);
				} else {
					bounds.extend(place.geometry.location);
				}
			});
			map.fitBounds(bounds);
		});
		google.maps.event.addDomListener(input, 'keydown', function (e) {
			if (e.keyCode == 13) {
				e.preventDefault();
			}
		});
	}
</script>	
@endpush			  
              