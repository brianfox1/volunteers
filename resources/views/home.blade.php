@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                      @if (session('alert-success'))
                          <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p>{{{ session('alert-success') }}}</p>
                          </div>
                      @endif

                      @if (session('alert-danger'))
                          <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p>{{{ session('alert-danger') }}}</p>
                          </div>
                      @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@section('pagescript')

@endsection
@endsection
