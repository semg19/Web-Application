@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="row">
                        <div>
                            <a href="{{ route('posts.create') }}"class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create New Post</a>
                        </div>
                        @foreach($posts as $post)
                        <div class="col-md-8">
                        <h2>{{ $post->title }}</h2>
                        <p>{{ $post->body }}</p>
                        <a href="{{ route('forum.index', $post->id) }}" class="btn-primary btn-lg">Read more</a>
                        <hr>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
