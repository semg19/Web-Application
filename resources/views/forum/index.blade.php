@extends('layouts.app')

@section('content')

    @foreach($posts as $post)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>{{ $post->title }}</h2>
                <h5>Published: {{ date('M j, Y', strtotime($post->created_at)) }}</h5>

                <p>{{substr($post->body, 0, 250) }}{{ strlen($post->body) > 250 ? '...' : "" }}</p>
                <p> {{ $post->user->name }}</p>
                <a href="{{ route('forum.show', $post->id) }}" class="btn btn-primary">Read more</a>
                <hr>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {!! $posts->links() !!}
            </div>
        </div>
    </div>
@endsection