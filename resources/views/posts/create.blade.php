@extends('layouts.app')

@section('stylesheets')

    {!! Html::style('css/select2.min.css') !!}

@endsection

@section('content')

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Create New Post</h1>
                <hr>

                {!! Form::open(array('route' => 'posts.store')) !!}
                    {{ Form::label('title', 'Title:') }}
                    {{ Form:: text('title', null, array('class' => 'form-control')) }}

                    {{ Form::label('category_id', 'Category:') }}
                    <select class="form-control" name="category_id">
                        @foreach($categories as $category)
                            <option value='{{ $category->id }}'>{{ $category->name }}</option>
                        @endforeach
                    </select>

                    {{ Form::label('tags', 'Tags:') }}
                    <select id="tag_list" class="form-control js-example-basic-multiple form-control" name="tags[]" multiple="multiple">
                        @foreach($tags as $tag)
                            <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <hr>

                    {{ Form::label('body', 'Post Body:') }}
                    {{ Form:: textarea('body', null, array('class' => 'form-control')) }}

                    {{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block')) }}
                    <input type="hidden" value="{{ Session::token() }}" name="_token">
                {!! Form::close() !!}
            </div>
        </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        $('#tag_list').select2();
    </script>

@endsection