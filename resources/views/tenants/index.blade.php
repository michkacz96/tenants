@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/tenants/create">Add new tenant</a>
    </nav>

    @if(count((is_countable($tenants)?$tenants:[])))
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
        @foreach($tenants as $tenant)
            <tr>
                <td scope="row">{{$tenant->tenant_code}}</td>
                <td>{{$tenant->tenant_name}}</td>
                <td>{{$tenant->TIN}}</td>
                <td>{{$tenant->getAddress()}}</td>
                <td>
                    {!! Form::open(['action' => ['App\Http\Controllers\TenantsController@destroy', $tenant->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                    {!! Form::close() !!}
                    <a href="/tenants/{{$tenant->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p class="text-center">No suppliers to show yet</p>
@endif
@endsection