@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome to the Laravel Todo App</h1>
        <h5 class="mt-4">This is a simple Laravel App to help keep track of your daily tasks!</p>
        <p class="mt-4">
            @auth
                <a class="btn btn-primary btn-lg" href="/home" role="button">Back to Dashboard</a>
            @endauth
            @guest
                <a class="btn btn-primary btn-lg mr-2" href="/login" role="button">Login</a> 
                <a class="btn btn-success btn-lg" href="/register" role="button">Register</a>
            @endguest
        </p>
    </div>
@endsection