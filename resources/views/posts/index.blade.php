@extends('layouts.app')

{{--@include('pages.search',['url'=>'posts','link'=>'posts'])--}}

@section('content')

    <div class="row">
        <div class="col-md-10">
            <h1>All Posts</h1>
        </div>

        <div class="col-md-2">
            <a href="{{ route('posts.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create New Post</a>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>

    {!! Form::open(['method'=>'GET','url'=>'posts','class'=>'navbar-form navbar-left','role'=>'search'])  !!}
    <div class="input-group custom-search-form">
        <input type="text" class="form-control" name="search" placeholder="Title search...">
        <span class="input-group-btn">
                <button class="btn btn-primary btn-block" type="submit">
                    <i class="fa fa-search">Search</i>
                </button>
                    </span>
    </div>
    {!! Form::close() !!}

    <div class="row">
        <div class="col-md-12">
            <table class="table" >
                <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Created At</th>
                    <th>Posted By</th>
                    <th></th>
                </thead>

                <tbody>

                    @foreach ($posts as $post)

                        <tr>
                            <th>{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            <td>{{substr($post->body, 0, 50) }}{{ strlen($post->body) > 50 ? '...' : "" }}</td>
                            <td>{{ date('M j, Y', strtotime($post->created_at)) }}</td>
                            <td>{{ $post->user->name }}</td>
                            @if(Auth::user() == $post->user)
                            <td><a href="{{ route('posts.show', $post->id) }}" class="btn btn-default btn-sm">View</a> <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-default btn-sm">Edit</a></td>
                            @endif
                        </tr>

                    @endforeach

                </tbody>
            </table>

            <div class="text-center">
                {!! $posts->links() !!}
            </div>
        </div>
    </div>

@endsection

