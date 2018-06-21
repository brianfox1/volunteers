@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Change Password</div>

                <div class="panel-body">
                        @if (session('success_message'))
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <p>{{{ session('success_message') }}}</p>
                            </div>
                        @endif

                        @if (session('error_message'))
                            <div class="alert alert-warning alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <p>{{{ session('error_message') }}}</p>
                            </div>
                        @endif                 
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/update_password') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input minlength="6" id="password" type="password" class="form-control" name="password" value="" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input minlength="6" id="password-confirm" type="password" class="form-control" name="password_confirmation" value="" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i> Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
