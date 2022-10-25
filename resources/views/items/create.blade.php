@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/items/">Back to list of goods and services</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => 'App\Http\Controllers\SellItemsController@store', 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-8">
                {{Form::label('item_name', 'Goods or services name')}}
                {{Form::text('item_name', '', ['class' => 'form-control', 'placeholder' => 'Goods or services name'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('category', 'Category')}}
                {{Form::select('category', $categories, null, ['class' => 'form-select'])}}
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add new item', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection