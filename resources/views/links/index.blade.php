@extends('layout')

@section('content')
    @forelse($links as $i => $link)
        <div class="row">
            <div class="col-md-1 votes">
                <p class="rank">{{ $i + 1 }}</p>
            </div>
            <div class="col-md-1 votes">
                <a href="#" data-id="{{ $link->id() }}" class="upvote">
                    <i class="glyphicon glyphicon-chevron-up"></i>
                </a>
                <div class="votes-count">
                    {{ $link->votes() }}
                </div>
                <a href="#" data-id="{{ $link->id() }}" class="downvote">
                    <i class="glyphicon glyphicon-chevron-down"></i>
                </a>
            </div>
            <div class="col-md-10 link">
                <p class="lead">
                    <a href="{{ $link->url() }}" target="_blank">
                        {{ $link->title() }}
                    </a>
                    <small class="text-muted">({{ $link->url()->getHost() }})</small>
                </p>
                <p>
                    <span class="text-muted">Sent by</span> {{ $link->readitor()->name() }}
                </p>
            </div>
        </div>
    @empty
        <p class="lead">No links have been posted</p>
    @endforelse
@stop

@section('scripts')
    <script src="/js/app.js"></script>
@stop
