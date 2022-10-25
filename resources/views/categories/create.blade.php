@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/categories/">Back to list of categories</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => 'App\Http\Controllers\CategoriesController@store', 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-8">
                {{Form::label('category_name', 'Category name')}}
                {{Form::text('category_name', '', ['class' => 'form-control', 'placeholder' => 'Category name'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('cat_type', 'Category type')}}
                {{Form::select('cat_type', $cat_type, null, ['class' => 'form-select'])}}
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add new category', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection