@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary me-3" href="/properties/">Back to list of properties</a>
        <a class="btn btn-secondary me-3" href="/formulas/">Back to list of formulas</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => 'App\Http\Controllers\FormulasController@store', 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('name', 'Formula name')}}
                {{Form::text('name', '', ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('formula', 'Formula')}}
                {{Form::select('formula', $formulas, null, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('detail', 'Property detail')}}
                {{Form::select('detail', $property_details, null, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('meter', 'Utility meter')}}
                {{Form::select('meter', $utility_meters, null, ['class' => 'form-select', 'required'])}}
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add formula', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection