@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/categories/create">Add category</a>
    </nav>
    
    <div class="row">
        <div class="col-6">
            <h4>Sale categories</h4>
            @if(count((is_countable($categories_sales)?$categories_sales:[])))
            <table class="table table-sm">
                <thead>
                    <tr>

                        <th scope="col">Name</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($categories_sales as $category)
                
                    <tr>
                        <td class="">{{$category->category_name}}</td>
                        <td>
                            {!! Form::open(['action' => ['App\Http\Controllers\CategoriesController@destroy', $category->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                            {!! Form::close() !!}
                            <a href="/categories/{{$category->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No Sell categories to show yet</p>
        @endif
        </div>

        <div class="col-6">
            <h4>Purchase categories</h4>
            @if(count((is_countable($categories_purchases)?$categories_purchases:[])))
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    
                @foreach($categories_purchases as $category)
                
                    <tr>
                        <td class="">{{$category->category_name}}</td>
                        <td>
                            {!! Form::open(['action' => ['App\Http\Controllers\CategoriesController@destroy', $category->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                            {!! Form::close() !!}
                            <a href="/categories/{{$category->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No Purchases categories to show yet</p>
        @endif
        </div>
    </div>
@endsection