              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                
                <label class="col-sm-2 col-sm-2 control-label">Name</label>
				 <div class="col-sm-6">
                {{ Form::text('name',null,['class'=>'form-control','id'=>'name']) }}
                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Email</label>
               <div class="col-md-6">
                {{ Form::email('email',null,['class'=>'form-control','id'=>'email']) }}
                 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
              @if(isset($adminuser->_id))
              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Old Password</label>
              <div class="col-md-6">
               {{ Form::password('oldpassword', ['class' => 'form-control','id'=>'password']) }}
                 @if ($errors->has('oldpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oldpassword') }}</strong>
                                    </span>
                                @endif
              </div>  
              </div>
              @endif
              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                @if(isset($adminuser->_id)) <label class="col-sm-2 col-sm-2 control-label">New Password</label> @else <label class="col-sm-2 col-sm-2 control-label">Password</label> @endif
              <div class="col-md-6">
               {{ Form::password('password', ['class' => 'form-control','id'=>'password']) }}
                 @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
              </div>  
              </div>
              @if(!isset($adminuser->_id))
              <div class="form-group{{ $errors->has('confirmpassword') ? ' has-error' : '' }}">
                <label class="col-sm-2 col-sm-2 control-label">Confirm Password</label>
              <div class="col-md-6">
               {{ Form::password('confirmpassword', ['class' => 'form-control','id'=>'confirmpassword']) }}
              </div>  
              </div>
              
              @endif