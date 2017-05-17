 
                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label class="col-sm-2 col-sm-2 control-label">Firstname</label>
                            <div class="col-md-6">
                            {{ Form::text('firstname',null,['class'=>'form-control']) }}
                                

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label class="col-sm-2 col-sm-2 control-label">Lastname</label>        
                            <div class="col-md-6">
                                {{ Form::text('lastname',null,['class'=>'form-control']) }}
                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label class="col-sm-2 col-sm-2 control-label">Username</label>
                            <div class="col-md-6">
                            {{ Form::text('username',null,['class'=>'form-control']) }}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-sm-2 col-sm-2 control-label">Email</label>
                            <div class="col-md-6">
                                 {{ Form::email('email',null,['class'=>'form-control']) }}

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                       
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                             <label class="col-sm-2 col-sm-2 control-label">City</label>     
                            <div class="col-md-6">
                                {{ Form::text('city',null,['class'=>'form-control']) }}
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                             <label class="col-sm-2 col-sm-2 control-label">Description</label>     
                            <div class="col-md-6">
                                {{ Form::textarea('description',null,['class'=>'form-control']) }}
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                          <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                              <label class="col-sm-2 col-sm-3 control-label">Account active status</label>     
                            <div class="col-md-6">
                        <div class="switch">
                                <div class="onoffswitch">
                                {{  Form::checkbox('isactive', true, null,['class'=>'onoffswitch-checkbox','id'=>'example1']) }}
                                    <label class="onoffswitch-label" for="example1">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            </div>
                     </div>       

                    