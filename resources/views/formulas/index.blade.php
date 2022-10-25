@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/formulas/create">Add new formula</a>
    </nav>

    @if(count((is_countable($formulas)?$formulas:[])))
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($formulas as $formula)
            <tr>
                <td>{{$formula->name}}</td>

                <td>
                    {!! Form::open(['action' => ['App\Http\Controllers\FormulasController@destroy', $formula->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                    {!! Form::close() !!}
                    <a href="/formulas/{{$formula->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>No formulas to show yet</p>
@endif
    
@endsection