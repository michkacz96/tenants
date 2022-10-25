@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary me-3" href="/properties/create">Add property</a>
        <a class="btn btn-secondary me-3" href="/utilitymeters/create">Add new utility meter</a>
    </nav>
    @if(count((is_countable($properties)?$properties:[])))
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Address</th>
                    <th scope="col">Zip-code</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Tenant</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                
            @foreach($properties as $property)
                <tr>
                    <th scope="row">{{$property->getFullStreet()}}</th>
                    <td>{{$property->zip_code}}</td>
                    <td>{{$property->city}}</td>
                    <td>{{$property->state}}</td>
                    <td>
                        @foreach($property->tenants as $tenant)
                            @if($tenant->pivot->end_rent_date === null || $tenant->pivot->end_rent_date >= date('Y-m-d'))
                                <span>{{$tenant->tenant_name}}</span><br>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        {!! Form::open(['action' => ['App\Http\Controllers\PropertiesController@destroy', $property->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                        {!! Form::close() !!}
                        <a href="/properties/{{$property->id}}/edit" class="btn btn-sm btn-secondary float-end mx-1 btn-block">Edit</a>
                        <a href="/properties/{{$property->id}}" class="btn btn-sm btn-secondary ms-1 float-end btn-block">Show</a>
                        <a href="/properties/{{$property->id}}/createinvoice" class="btn btn-sm btn-primary ms-1 float-end btn-block">Issue invoice</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No properties to show yet</p>
    @endif
@endsection