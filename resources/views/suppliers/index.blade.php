@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/suppliers/create">Add new supplier</a>
    </nav>

    @if(count((is_countable($suppliers)?$suppliers:[])))
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Short</th>
                <th scope="col">Name</th>
                <th scope="col">TIN</th>
                <th scope="col">Address</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($suppliers as $supplier)
            <tr>
                <td scope="row">{{$supplier->supplier_code}}</td>
                <td>{{$supplier->supplier_name}}</td>
                <td>{{$supplier->TIN}}</td>
                <td>{{$supplier->getAddress()}}</td>
                <td>
                    {!! Form::open(['action' => ['App\Http\Controllers\SuppliersController@destroy', $supplier->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                    {!! Form::close() !!}
                    <a href="/suppliers/{{$supplier->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p class="text-center">No suppliers to show yet</p>
@endif
@endsection