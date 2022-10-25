<?php
    use App\Models\Unit;
?>
@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
<h1>{{$title}}</h1>
<nav class="nav nav-pills my-3">
    <a class="btn btn-secondary me-3" href="/properties/">Back to list of properties</a>
    <a class="btn btn-secondary me-3" href="/properties/{{$property->id}}">Back to {{$property->getFullStreet()}}</a>
</nav>

<div class="my-3">
    {!! Form::open(['action' => ['App\Http\Controllers\PropertySellitemsController@connectInvoiceItem', $property->id], 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-6">
                {{Form::label('sellitem', 'Sell item')}}
                {{Form::select('sellitem', $sellitems, null, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-6">
                {{Form::label('formula', 'Formula')}}
                {{Form::select('formula', $formulas, null, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('start_date', 'Beginning date')}}
                {{Form::date('start_date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('end_date', 'Ending date')}}
                {{Form::date('end_date', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('price', 'Price')}}
                {{Form::number('price', '', ['class' => 'form-control', 'placeholder' => 'Price', 'step' => '0.01', 'min' => '0'])}}
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add item', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
</div>
@endsection
