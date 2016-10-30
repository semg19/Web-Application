@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Edit Comment</h1>

                {{ Form::model($comment, ['route' => ['comments.update', $comment->id], 'method' => "PUT"]) }}

                    {{ Form::label('comment', "Comment:") }}
                    {{ Form::textarea('comment', null, ['class' => 'form-control']) }}

                 @if(Auth::user() == $comment->user)
                    {{ Form::submit('Update Comment', ['class' => 'btn btn-success', 'style' => 'margin-top:15px;']) }}
                 @endif
                 @if (Auth::user()->isAdmin())
                 {{ Form::submit('Update Comment', ['class' => 'btn btn-success', 'style' => 'margin-top:15px;']) }}
                 @endif
                {{ Form::close() }}

    </div>
</div>

@endsection