@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/properties/{{$property->id}}">Back to property</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => ['App\Http\Controllers\PropertyPropertyDetailsController@storeDetails', $property->id], 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('detail', 'Detail name')}}
                {{Form::select('detail', $listOfDetails, null, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('quantity', 'Quantity')}}
                {{Form::number('quantity', '', ['class' => 'form-control', 'required', 'min' => '0', 'step' => '.0001'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('start_date', 'Start date')}}
                {{Form::date('start_date', '', ['class' => 'form-control'])}}
            </div>

            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('end_date', 'End date')}}
                {{Form::date('end_date', '', ['class' => 'form-control'])}}
            </div>
            
            
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add detail', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
@endsection