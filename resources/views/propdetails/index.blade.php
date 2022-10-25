@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/propdetails/create">Add new property detail</a>
    </nav>

    @if(count((is_countable($details)?$details:[])))
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Unit</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($details as $detail)
            <tr>
                <td>{{$detail->id}}</td>
                <td>{{$detail->name}}</td>
                <td>{!! $detail->unit->HTML_entity !!}</td>

                <td>
                    {!! Form::open(['action' => ['App\Http\Controllers\PropertyDetailsController@destroy', $detail->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                    {!! Form::close() !!}
                    <a href="/propdetails/{{$detail->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>No property details to show yet</p>
@endif
    
@endsection