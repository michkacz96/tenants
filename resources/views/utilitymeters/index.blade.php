@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/utilitymeters/create">Add new utility meter</a>
    </nav>

    @if(count((is_countable($utility_meters)?$utility_meters:[])))
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Property</th>
                <th scope="col">Utility meter type</th>
                <th scope="col">Serial number</th>
                <th scope="col">Start date</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($utility_meters as $util_meter)
            <tr>
                <th scope="row">{{$util_meter->property->getAddress()}}</th>
                <td>{{$util_meter->utilityMeterType->type_name}} [{!! $util_meter->utilityMeterType->unit->HTML_entity !!}]</td>
                <td>{{$util_meter->serial_number}}</td>
                <td>{{$util_meter->start_date}}</td>
                <td>
                    {!! Form::open(['action' => ['App\Http\Controllers\UtilityMetersController@destroy', $util_meter->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                    {!! Form::close() !!}
                    <a href="/utilitymeters/{{$util_meter->id}}/edit" class="btn btn-sm btn-secondary float-end mx-1 btn-block">Edit</a>
                    <a href="/utilitymeters/{{$util_meter->id}}/addreading/" class="btn btn-sm btn-primary float-end mx-1 btn-block">Add reading</a>
                    <a href="/utilitymeters/{{$util_meter->id}}/readings/" class="btn btn-sm btn-primary float-end mx-1 btn-block">Readings</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p class="text-center">No suppliers to show yet</p>
@endif
@endsection