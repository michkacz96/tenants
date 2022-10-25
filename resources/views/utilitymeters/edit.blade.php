@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary me-3" href="/properties/">Back to list of properties</a>
        <a class="btn btn-secondary me-3" href="/utilitymeters/">Back to list of utility meters</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => ['App\Http\Controllers\UtilityMetersController@update', $utility_meter->id], 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('serial_number', 'Serial number')}}
                {{Form::text('serial_number', $utility_meter->serial_number, ['class' => 'form-control', 'placeholder' => 'Serial number', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('meter_type', 'Utility meter type')}}
                {{Form::select('meter_type', $utility_meter_types, $utility_meter->unit_id, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4"></div>

            <div class="form-group col-md-12 col-lg-6">
                {{Form::label('property', 'Property')}}
                {{Form::select('property', $properties, $utility_meter->property_id, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('start_date', 'Start date')}}
                {{Form::date('start_date', $utility_meter->start_date, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('end_date', 'End date')}}
                {{Form::date('end_date', $utility_meter->end_date, ['class' => 'form-control'])}}
                <!--{{Form::date('end_date', date('Y-m-d', strtotime('+10 years')), ['class' => 'form-control'])}}-->
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Edit utility meter', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection