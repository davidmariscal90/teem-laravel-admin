              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                 <div class="col-md-6">
                <label for="input-one">Name</label>
                {{ Form::text('name',null,['class'=>'form-control','id'=>'name']) }}
                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                </div>
              </div>
               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
               <div class="col-md-6">
                <label for="input-one">Email</label>
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
              <div class="col-md-6">
                <label for="input-one">Old Password</label>
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
              <div class="col-md-6">
                @if(isset($adminuser->_id)) <label for="input-one">New Password</label> @else <label for="input-one">Password</label> @endif
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
              <div class="col-md-6">
                <label for="input-one">Confirm Password</label>
               {{ Form::password('confirmpassword', ['class' => 'form-control','id'=>'confirmpassword']) }}
              </div>  
              </div>
              
              @endif