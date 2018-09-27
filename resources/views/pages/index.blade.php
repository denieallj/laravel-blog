@extends('layouts/app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{ $title }}</h1>
        <p>Some Laravel App</p>
        <br>
        <p><a href="/login" class="btn btn-success btn-lg">Login</a>&nbsp;<a href="/register" class="btn btn-warning btn-lg">Register</a></p>
    </div>
@endsection
