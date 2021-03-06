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
               <div class="form-group{{ $errors->has('imageurl') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Image url</label>
               <div class="col-md-6">
                {{ Form::text('imageurl',null,['class'=>'form-control','id'=>'imageurl']) }}
                 @if ($errors->has('imageurl'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('imageurl') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
              