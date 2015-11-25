@extends('layout')

@section('content')
    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">
                    <i class="fa fa-reddit"></i>
                    Welcome back
                </div>
            </div>
            <div class="panel-body" >
                <form method="POST" action="/auth/login">
                    {!! csrf_field() !!}

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 controls">
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="glyphicon glyphicon-log-in"></i>
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
