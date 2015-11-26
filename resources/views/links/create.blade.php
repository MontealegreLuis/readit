@extends('layout')

@section('content')
    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">
                    <i class="fa fa-reddit"></i>
                    Send to ReadIt
                </div>
            </div>
            <div class="panel-body" >
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="/links/store">
                    {!! csrf_field() !!}

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                        <input type="text" name="url" value="{{ old('url') }}" class="form-control" placeholder="URL">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 controls">
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="glyphicon glyphicon-share-alt"></i>
                                Send
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
