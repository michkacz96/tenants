@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/items/create">Add good or service</a>
    </nav>

    @if(count((is_countable($sellitems)?$sellitems:[])))
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($sellitems as $sellitem)
                
                    <tr>
                        <td>{{$sellitem->item_name}}</td>
                        <td>{{$sellitem->category->category_name}}</td>
                        <td>
                            {!! Form::open(['action' => ['App\Http\Controllers\SellItemsController@destroy', $sellitem->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                            {!! Form::close() !!}
                            <a href="/items/{{$sellitem->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No Sell categories to show yet</p>
        @endif


@endsection