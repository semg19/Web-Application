@extends('layouts.app')

@section('content')

    <h1>{{ $post->title }}</h1>
    <p class="lead">{{ $post->body }}</p>

@endsection