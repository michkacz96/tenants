@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/purchases/">Back to list of purchases documents</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => 'App\Http\Controllers\PurchasesController@store', 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('supplier', 'Supplier')}}
                {{Form::select('supplier', $suppliers, null, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('category', 'Category')}}
                {{Form::select('category', $categories, null, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="col-md-12 col-lg-4"></div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('invoice_number', 'Invoice number')}}
                {{Form::text('invoice_number', '', ['class' => 'form-control', 'placeholder' => 'Invoice number', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('invoice_date', 'Invoice date')}}
                {{Form::date('invoice_date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('due_date', 'Due date')}}
                {{Form::date('due_date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('sell_date', 'Sell date')}}
                {{Form::date('sell_date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('amount', 'Amount')}}
                {{Form::number('amount', '', ['class' => 'form-control', 'placeholder' => 'Amount', 'step' => '0.01' ,'required'])}}
            </div>
            <div class="col-md-12 col-lg-9"></div>
            <div class="form-group col-md-12 col-lg-12">
                {{Form::label('description', 'Description')}}
                {{Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'Description'])}}
            </div>
            
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add new document', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection