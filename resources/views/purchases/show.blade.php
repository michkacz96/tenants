@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary me-3" href="/purchases/">Back to list of purchases documents</a>
        <a class="btn btn-secondary me-3" href="/purchases/edit/{{$document->id}}">Edit document {{$document->invoice_number}}</a>
    </nav>

    
@endsection