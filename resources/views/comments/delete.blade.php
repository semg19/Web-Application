@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Delete This Comment.</h1>
            <p>
                <strong>Name:</strong> {{ $comment->user->name }}<br>
                <strong>Comment:</strong> {{ $comment->comment }}
            </p>

            @if(Auth::user() == $comment->user)
            {{ Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'DELETE']) }}
                {{ Form::submit('Yes delete this comment', ['class' => 'btn btn-lg btn-block btn-danger']) }}
            {{ Form::close() }}
            @endif
            @if(Auth::user()->isAdmin())
            {{ Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'DELETE']) }}
            {{ Form::submit('Yes delete this comment', ['class' => 'btn btn-lg btn-block btn-danger']) }}
            {{ Form::close() }}
            @endif
        </div>
    </div>

@endsection