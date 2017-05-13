 
                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                            <label for="password">Firstname</label>
                            {{ Form::text('firstname',null,['class'=>'form-control']) }}
                                

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <label for="password-confirm">Lastname</label>        
                                {{ Form::text('lastname',null,['class'=>'form-control']) }}
                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <label for="name">Username</label>
                            {{ Form::text('username',null,['class'=>'form-control']) }}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                            <label for="email" >Email</label>
                                 {{ Form::email('email',null,['class'=>'form-control']) }}

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                       
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                             <label for="city" >City</label>     
                                {{ Form::text('city',null,['class'=>'form-control']) }}
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                             <label for="description" >Description</label>     
                                {{ Form::textarea('description',null,['class'=>'form-control']) }}
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                          <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                              <label for="description" >Account active status</label>     
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

                    