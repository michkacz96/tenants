@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/tenants/">Back to list of tenants</a>
    </nav>

    <div class="mt-3">
        {!! Form::open(['action' => 'App\Http\Controllers\TenantsController@store', 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('tax_number', 'Taxpayer Identification Number')}}
                {{Form::text('tax_number', '', ['class' => 'form-control', 'placeholder' => 'TIN'])}}
            </div>
            <div class="col-md-12 col-lg-9"></div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('tenant_code', 'Short Name')}}
                {{Form::text('tenant_code', '', ['class' => 'form-control', 'placeholder' => 'Short Name', 'maxlength' => '30', 'required'])}}
            </div>
            <div class="form-group col-md-12 col-lg-9">
                {{Form::label('tenant_name', 'Full Name')}}
                {{Form::text('tenant_name', '', ['class' => 'form-control', 'placeholder' => 'Full Name', 'required'])}}
            </div>
            <hr class="col-12 mt-3">
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
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('zip_code', 'Postal code')}}
                {{Form::text('zip_code', '', ['class' => 'form-control', 'placeholder' => 'Postal code'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('city', 'City')}}
                {{Form::text('city', '', ['class' => 'form-control', 'placeholder' => 'City'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('state', 'State')}}
                {{Form::text('state', '', ['class' => 'form-control', 'placeholder' => 'State'])}}
            </div>
            <div class="form-group col-md-12 col-lg-3">
                {{Form::label('country', 'Country')}}
                {{Form::text('country', '', ['class' => 'form-control', 'placeholder' => 'Country'])}}
            </div>
            <hr class="col-12 mt-3">
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('phone', 'Phone number')}}
                {{Form::tel('phone', '', ['class' => 'form-control', 'placeholder' => 'Phone number'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('email', 'E-mail')}}
                {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'E-mail'])}}
            </div>
            <div class="form-group col-md-12 col-lg-4">
                {{Form::label('website', 'Website')}}
                {{Form::url('website', '', ['class' => 'form-control', 'placeholder' => 'Website'])}}
            </div>
        </div>
        <div class="my-3 clearfix">
            {{Form::submit('Add new tenant', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection