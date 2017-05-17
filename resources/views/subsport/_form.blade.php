              <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Title</label>
                 <div class="col-md-6">
                {{ Form::text('title',null,['class'=>'form-control','id'=>'title']) }}
                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
               <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Value</label>
               <div class="col-md-6">
                {{ Form::text('value',null,['class'=>'form-control','id'=>'value']) }}
                 @if ($errors->has('value'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
               <div class="form-group{{ $errors->has('sportid') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Sport</label>
               <div class="col-md-6">
                {{ Form::select('sportid', $sport, null, ['placeholder' => 'Select sport...','class'=>'form-control','id'=>'sportid']) }}
                 @if ($errors->has('sportid'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sportid') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
              