              <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                 <div class="col-md-6">
                <label for="input-one">Title</label>
                {{ Form::text('title',null,['class'=>'form-control','id'=>'title']) }}
                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
               <div class="form-group{{ $errors->has('imageurl') ? ' has-error' : '' }}">
               <div class="col-md-6">
                <label for="input-one">Image url</label>
                {{ Form::text('imageurl',null,['class'=>'form-control','id'=>'imageurl']) }}
                 @if ($errors->has('imageurl'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('imageurl') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
              