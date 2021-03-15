@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold pt-3" style="font-size: 20px">
                    <span class="align-middle">{{ $list->name }}</span>
                    <a href="/home" class="btn btn-secondary float-right">Back to Lists</a>
                </div>

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
                        <div class="card-header" style="background-color: rgb(20, 77, 143)">Add a New Todo</div>
                        <div class="card-body" style="background-color: rgb(25, 107, 184)">
                            {!! Form::open(['action' => ['App\Http\Controllers\ItemsController@store', $list->id], 'method' => 'POST']) !!}
                            <div class="form-group">
                                {{ Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'Description of Todo']) }}
                            </div>
                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="card mb-5">
                        <table class="table table-hover rounded mb-0">
                            <thead class="thead-dark">
                              <tr style="height: 60px;">
                                <th scope="col" class="align-middle">Todo Description</th>
                                <th scope="col" class="align-middle"></th>
                              </tr>
                            </thead>
                            <tbody>
                            @if (count($items) > 0)
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="align-middle" style="width: 80%">{{ $item->description }}</td>
                                        <td style="width: 20%">
                                            {!! Form::open(['action' => ['App\Http\Controllers\ItemsController@markCompleted', $list->id, $item->id], 'method' => 'PUT']) !!}
                                            {{ Form::submit('Mark Done', ['class' => 'btn btn-success']) }}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="width: 80%">You have no Todo items!</td>
                                    <td style="width: 20%"></td>
                                </tr>
                            @endif
                            </tbody>
                          </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
