@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold" style="font-size: 20px">{{ __('Dashboard') }}</div>

                <div class="card-body" style="font-size: 16px">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @endif
                    
                    <div class="text-white mt-3 mb-5 rounded">
                        <div class="card-header" style="background-color: rgb(20, 77, 143)">Create a New List</div>
                        <div class="card-body" style="background-color: rgb(25, 107, 184)">
                            {!! Form::open(['action' => 'App\Http\Controllers\HomeController@store', 'method' => 'POST']) !!}
                            <div class="form-group">
                                {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'List Name']) }}
                            </div>
                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    
                    <div class="card mb-5">
                        <div class="card-header font-weight-bold">
                            Your Todo Lists
                        </div>
                        <ul class="list-group list-group-flush">
                            @if (count($lists) > 0)
                                @foreach ($lists as $list)
                                <li class="list-group-item" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                                    <a href="/list/{{$list->id}}/items">{{ $list->name }}</a>
                                    {!! Form::open(['action' => ['App\Http\Controllers\HomeController@destroy', $list->id], 'method' => 'DELETE']) !!}
                                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                    {!! Form::close() !!}
                                </li>
                                @endforeach
                            @else
                                <li class="list-group-item" style="display: flex; align-items: center;">
                                    <p class="mb-0">You have no list items!</p>
                                </li>
                            @endif
                        </ul>
                        {{ $lists->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
