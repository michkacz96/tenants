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
        {!! Form::open(['action' => ['App\Http\Controllers\UtilityMeterReadingsController@storeReading', $utility_meter->id],'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('date', 'Reading date')}}
                {{Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('reading', 'Reading')}}
                <div class="input-group">
                    {{Form::number('reading', null, ['class' => 'form-control', 'required', 'step' => '0.0001', 'min' => '0'])}}
                    <span class="input-group-text">{!! $utility_meter->utilityMeterType->unit->HTML_entity !!}</span>
                </div>
                
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add new reading', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection