<?php
    use App\Models\Formula;
    use App\Models\PropertySellitem;

    $months = array();
    for($m=1; $m<=12; ++$m){
        $months[$m] = date('F', mktime(0, 0, 0, $m, 1));
    }
?>
@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/properties/">Back to list of properties</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => ['App\Http\Controllers\RentsController@storeInvoice', $property->id], 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-12">
                {{Form::label('tenant', 'Tenant')}}
                {{Form::select('tenant', $tenants_list, $current_tenant, ['class' => 'form-select', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('invoice_number', 'Invoice number')}}
                {{Form::text('invoice_number', '', ['class' => 'form-control', 'placeholder' => 'Invoice number', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('invoicing_year', 'Invoicing year')}}
                {{Form::number('invoicing_year', date('Y'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('invoicing_month', 'Invoicing month')}}
                {{Form::select('invoicing_month', $months, date('n'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('invoice_date', 'Invoice date')}}
                {{Form::date('invoice_date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('sell_date', 'Sell date')}}
                {{Form::date('sell_date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('due_date', 'Due date')}}
                {{Form::date('due_date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
            </div>
            <div class="col-md-12 col-lg-9"></div>
            <div class="form-group col-md-12 col-lg-12">
                {{Form::label('description', 'Description')}}
                {{Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'Description (optional)'])}}
            </div>            
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add invoice details', ['class' => 'btn btn-warning float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection