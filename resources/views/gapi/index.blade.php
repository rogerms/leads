@extends('layouts.master')
    @section('title', 'Google API Auth')
    @section('content')
        <h4>Google Calendar Authentication</h4>
    @include('partials.feedback')

    @if(isset($google_auth_url))
        <br><a href="{{ $google_auth_url }}">Connect with Google</a>
    @endif
    @if(Session::has('access_token'))
        <br><a href="{{ URL::to('gapi/logout') }}">Logout</a>
    @endif
@endsection