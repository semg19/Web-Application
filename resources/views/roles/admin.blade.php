@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <table class="table">
        <thead>
        <th>Name</th>
        <th>E-Mail</th>
        <th>User</th>
        <th>Author</th>
        <th>Admin</th>
        <th></th>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <form action="{{ route('admin.assign') }}" method="post">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email}} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                <td><input type="checkbox" {{ $user->hasRole('User') ? 'checked' : ''}} name="role_user"></td>
                <td><input type="checkbox" {{ $user->hasRole('Author') ? 'checked' : ''}} name="role_author"></td>
                <td><input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : ''}} name="role_admin"></td>
                {{ csrf_field() }}
                <td><button type="submit" class="btn btn-default btn-sm">Assign Roles</button></td>
                </form>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection