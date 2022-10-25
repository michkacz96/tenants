<?php
    use App\Models\Unit;
?>
@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
<h1>{{$property->getAddress()}}</h1>
<nav class="nav nav-pills my-3">
    <a class="btn btn-secondary me-3" href="/properties/">Back to list of properties</a>
    <a class="btn btn-secondary me-3" href="/properties/{{$property->id}}/edit">Edit address</a>
    <a class="btn btn-secondary me-3" href="/properties/{{$property->id}}/adddetail">Add detail</a>
    <a class="btn btn-secondary me-3" href="/properties/{{$property->id}}/changetenant">Change tenant</a>
    <a class="btn btn-secondary me-3" href="/properties/{{$property->id}}/additem">Add item</a>
</nav>
<div class="my-3">
    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-details-tab" data-bs-toggle="pill" data-bs-target="#v-pills-details" type="button" role="tab" aria-controls="v-pills-details" aria-selected="true">Details</button>

            <button class="nav-link" id="v-pills-invoice-items-tab" data-bs-toggle="pill" data-bs-target="#v-pills-invoice-items" type="button" role="tab" aria-controls="v-pills-invoice-items" aria-selected="false">Invoice items</button>

            <button class="nav-link" id="v-pills-tenants-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tenants" type="button" role="tab" aria-controls="v-pills-tenants" aria-selected="false">Tenants</button>
        </div>
        <div class="tab-content flex-fill" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-details" role="tabpanel" aria-labelledby="v-pills-details-tab">
                @include('properties.propdetails.details')
            </div>
            <div class="tab-pane fade" id="v-pills-invoice-items" role="tabpanel" aria-labelledby="v-pills-invoice-items-tab">
                @include('properties.propdetails.invoiceitems')
            </div>
            <div class="tab-pane fade" id="v-pills-tenants" role="tabpanel" aria-labelledby="v-pills-tenants-tab">
                @include('properties.propdetails.tenants')
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
