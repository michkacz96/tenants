<?php
    use App\Models\Unit;
?>
@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary me-3" href="/properties/{{$property->id}}">Back to property</a>
    </nav>

    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Start</th>
                <th scope="col">End</th>
                <th scope="col">Quantity</th>
                <th scope="col">name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
                <tr>
                    <td>{{$detail->pivot->detail_start_date}}</td>
                    <td>{{$detail->pivot->detail_end_date}}</td>
                    <td>{{$detail->pivot->quantity}}</td>
                    <td>{{$detail->name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection