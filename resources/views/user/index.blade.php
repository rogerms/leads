@extends('layouts.master')

@section('title', 'List of users')

@section('content')
    <div class="container">
    @include('partials.feedback')
    <h4>Users</h4>
            <table class="table table-striped" >
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Update</th>
                </tr>
        @foreach($users as $user)
            <tr style="border: 0px solid transparent">
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    <a href="/user/{{ $user->id }}" class="btn btn-default" ><span class="glyphicon glyphicon-pencil"></span></a>
                </td>
            </tr>
        @endforeach
            </table>
    </div>
@endsection
