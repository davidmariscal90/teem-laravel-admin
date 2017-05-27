              <!-- sportcenter -->
               <div class="form-group{{ $errors->has('sport') ? ' has-error' : '' }}">
            		<label class="col-sm-2 col-sm-2 control-label">Sport Centre</label>
               <div class="col-md-6">
					{{ Form::select('scid', $sportCenterArr, null,['class'=>'form-control','id'=>'sportcenter']) }}
                 @if ($errors->has('scid'))
                	<span class="help-block">
                    	<strong>{{ $errors->first('scid') }}</strong>
                    </span>
                @endif
                </div>
				</div>

			  <!-- name -->
			  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Name</label>
                 <div class="col-md-6">
                {{ Form::text('name',null,['class'=>'form-control','id'=>'name']) }}
                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
			  
			  <!-- covering -->
               <div class="form-group{{ $errors->has('covering') ? ' has-error' : '' }}">
            		<label class="col-sm-2 col-sm-2 control-label">Covering</label>
               <div class="col-md-6">
				<div class="checkbox-inline i-checks">
					{{ Form::radio('covering', 'Outdoor') }}  Outdoor
					{{ Form::radio('covering', 'Indoor') }} Indoor
					{{ Form::radio('covering', 'Outdoor/Indoor') }} Outdoor/Indoor
                 @if ($errors->has('covering'))
                	<span class="help-block">
                    	<strong>{{ $errors->first('covering') }}</strong>
                    </span>
                @endif
				</div>
                </div>
              </div>

			  <!-- lights -->
               <div class="form-group{{ $errors->has('lights') ? ' has-error' : '' }}">
            		<label class="col-sm-2 col-sm-2 control-label">Lights</label>
               <div class="col-md-6">
				<div class="checkbox-inline i-checks">
					<label> {{ Form::radio('lights', 'yes') }} <i></i> Yes</label>
					<label> {{ Form::radio('lights', 'no') }} <i></i> No</label>
				</div>
                 @if ($errors->has('lights'))
                	<span class="help-block">
                    	<strong>{{ $errors->first('lights') }}</strong>
                    </span>
                @endif
                </div>
              </div>

			  <!-- surface -->
               <div class="form-group{{ $errors->has('surface') ? ' has-error' : '' }}">
            		<label class="col-sm-2 col-sm-2 control-label">Surface</label>
               <div class="col-md-6">
					{{ Form::select('surface', [
						'synthethic turf' => 'Synthethic turf',
						'natural grass' => 'Natural grass',
						'parquet floor' => 'Parquet floor',
						'rubber/pvc' => 'Rubber/PVC',
						'resin' => 'Resin',
						'terrain' => 'Terrain',
						'Cement' => 'Cement',
					], '',['class'=>'form-control']) }}
                 @if ($errors->has('surface'))
                	<span class="help-block">
                    	<strong>{{ $errors->first('surface') }}</strong>
                    </span>
                @endif
                </div>
              </div>

			  <!-- sport -->
               <div class="form-group{{ $errors->has('sport') ? ' has-error' : '' }}">
            		<label class="col-sm-2 col-sm-2 control-label">Sports</label>
               <div class="col-md-6" id="sportsSelect">
				@foreach($field['sport'] as $sportkey=>$sportObj)
				
				<div class="row" id="select-wrapper">
				   <div class="col-md-10">
						{{ Form::select('sport[]', $sportArr, $sportObj,['class'=>'form-control','id'=>'sport']) }}
					</div>
					<div id="bt" class="col-md-2">
						@if($sportkey>0)
							<button id='btn-remove' type='button' class='btn btn-primary'><i class='fa fa-minus'></i></button>
						@else	
							<button id="addMore" type="button" class="btn btn-primary addMore"><i class="fa fa-plus"></i></button>
						@endif	
					</div>
				 </div>
				@endforeach 
                 @if ($errors->has('sport'))
                	<span class="help-block">
                    	<strong>{{ $errors->first('sport') }}</strong>
                    </span>
                @endif
                </div>
              </div>


			  	<!-- price -->
			    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Price</label>
                 <div class="col-md-6">
				 <div class="input-group">
				 <span class="input-group-addon">$</span>
                	{{ Form::number('price',null,['class'=>'form-control','id'=>'price']) }}
				</div>
                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
              