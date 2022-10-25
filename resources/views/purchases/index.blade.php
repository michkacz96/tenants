@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/purchases/create">Add new document</a>
    </nav>

    @if(count((is_countable($documents)?$documents:[])))
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Supplier</th>
                <th scope="col">Invoice number</th>
                <th scope="col">Invoice date</th>
                <th scope="col">Due date</th>
                <th scope="col">Sell date</th>
                <th scope="col">Amount</th>
                <th scope="col">Category</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($documents as $document)
            <tr>
                <td>{{$document->supplier->supplier_name}}</td>
                <td>{{$document->invoice_number}}</td>
                <td>{{$document->invoice_date}}</td>
                <td>{{$document->due_date}}</td>
                <td>{{$document->sell_date}}</td>
                <td>{{$document->amount}}</td>
                <td>{{$document->category->category_name}}</td>
                <td>
                    {!! Form::open(['action' => ['App\Http\Controllers\PurchasesController@destroy', $document->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                    {!! Form::close() !!}
                    <a href="/purchases/{{$document->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p class="text-center">No documents to show yet</p>
@endif
@endsection