@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title.' '.$detail->name}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/propdetails">Back to list of property detail</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => ['App\Http\Controllers\PropertyDetailsController@update', $detail->id], 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-9">
                {{Form::label('name', 'Detail name')}}
                {{Form::text('name', $detail->name, ['class' => 'form-control', 'placeholder' => 'Detail name'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('unit', 'Unit')}}
                {{Form::select('unit', $units, $detail->unit_id, ['class' => 'form-select'])}}
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Edit property detail', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
@endsection