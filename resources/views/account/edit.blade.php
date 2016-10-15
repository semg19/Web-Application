@extends('layouts.app')

@section('content')

    {{ Form::model($user, ['route' => ['account.save', $user->id], 'method' => "PUT"]) }}

    {{ Form::label('name', "Name:") }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}

    {{ Form::label('email', "Email:") }}
    {{ Form::text('email', null, ['class' => 'form-control']) }}

    {{ Form::submit('Save Changes', ['class' => 'btn btn-success', 'style' => 'margin-top:20px;']) }}
    {{ Form::close() }}

@endsection