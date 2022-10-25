@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/properties">Back to list of properties</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => 'App\Http\Controllers\PropertiesController@store', 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-8">
                {{Form::label('street_name', 'Street name')}}
                {{Form::text('street_name', '', ['class' => 'form-control', 'placeholder' => 'Street name'])}}
            </div>
            <div class="form-group col-md-12 col-lg-2">
                {{Form::label('street_number', 'Street number')}}
                {{Form::text('street_number', '', ['class' => 'form-control', 'placeholder' => 'Street number'])}}
            </div>
            <div class="form-group col-md-12 col-lg-2">
                {{Form::label('apt_number', 'Apartment number')}}
                {{Form::text('apt_number', '', ['class' => 'form-control', 'placeholder' => 'Apartment number'])}}
            </div>
            <div class="my-2"></div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('zip_code', 'Postal code')}}
                {{Form::text('zip_code', '', ['class' => 'form-control', 'placeholder' => 'Postal code'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('city', 'City')}}
                {{Form::text('city', '', ['class' => 'form-control', 'placeholder' => 'City'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('state', 'State')}}
                {{Form::text('state', '', ['class' => 'form-control', 'placeholder' => 'State'])}}
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add new property', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
@endsection