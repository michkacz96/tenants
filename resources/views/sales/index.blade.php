@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$texts['title']}}</h1>
    <nav class="nav nav-pills my-3">
        <!--<a class="btn btn-secondary" href="/sales/create">Add new document</a>-->
    </nav>

    @if(count((is_countable($documents)?$documents:[])))
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Tenant</th>
                <th scope="col">Invoice number</th>
                <th scope="col">Invoice date</th>
                <th scope="col">Due date</th>
                <th scope="col">Sell date</th>
                <th scope="col">Amount</th>
                <th scope="col">Description</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($documents as $document)
            <tr>
                <td>{{$document->tenant->tenant_name}}</td>
                <td>{{$document->invoice_number}}</td>
                <td>{{$document->invoice_date}}</td>
                <td>{{$document->due_date}}</td>
                <td>{{$document->sell_date}}</td>
                <td>{{$document->total_amount}}</td>
                <td colspan="8">{{$document->description}}</td>
                <td>
                    {!! Form::open(['action' => ['App\Http\Controllers\SellDocumentsController@destroy', $document->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                    {!! Form::close() !!}
                    <!--<a href="/sales/$document->id}}/edit" class="btn btn-sm btn-primary float-end mx-1 btn-block" disabled>Edit</a>-->
                    <a href="/sales/{{$document->id}}" class="btn btn-sm btn-secondary float-end mx-1 btn-block">Details</a>
                </td>
                
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p class="text-center">{{$texts['no_results']}}</p>
@endif
@endsection