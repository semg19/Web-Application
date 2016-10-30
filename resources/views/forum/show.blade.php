@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->body }}</p>
            <hr>
            <p>Placed by: {{ $post->user->name }}</p>
            <p>Posted In: {{ $post->category->name }}</p>
            <div class="tags">
                @foreach($post->tags as $tag)
                    <span class="label label-default">{{ $tag->name }}</span>
                @endforeach
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3><b>Comments</b></h3>
            @foreach($post->comments as $comment)
                <div class="comment">
                    <p><strong>Name:</strong> {{ $comment->user->name }}</p>
                    <p><strong>Comment:</strong> {{ $comment->comment }}</p>
                    <p>
                        @if(Auth::user() == $comment->user)
                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary">Edit</a>
                            <a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger">Delete</a>
                        @endif
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary">Edit</a>
                            <a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger">Delete</a>
                        @endif
                    </p>
                    <hr>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div id="comment-form" class="col-md-8 col-md-offset-2" style="margin-top: 50px;">
            {{ Form::open(['route' => ['comments.store', $post->id, 'method' => 'POST']]) }}

                <div class="col-md-12">
                    {{ Form::label('comment', 'Comment:') }}
                    {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

                    {{ Form::submit('Add Comment', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:15px;']) }}
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>

@endsection