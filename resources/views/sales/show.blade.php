@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/sales">Back to sell documents</a>
    </nav>

<div class="row">
    <div class="col-4">
        <!-- wystawca -->
        <p class="fw-bold mb-2">Invoice from:</p>
        <p>
            {{$seller->name}}<br>
            {{$seller->email}}<br>
            <br>
            @if(isset($seller->TIN))
            TIN: {{$seller->TIN}}
            @endif
        </p>
    </div>

    <div class="col-4">
        <!-- Invoice to -->
        <p class="fw-bold mb-2">Invoice to:</p>
        <p>
            {{$tenant->tenant_name}}<br>
            {{$tenant->getFullStreet()}}<br>
            {{$tenant->getCityAddress()}}<br>
            @if(isset($tenant->TIN))
            TIN: {{$tenant->TIN}}
            @endif
        </p>
    </div>

    <div class="col-4">
        <span class="fw-bold fs-3">Invoice No. {{$document->invoice_number}}</span>
        <p>
            <span>Invoice date: {{$document->invoice_date}}</span><br>
            <span>Sell date: {{$document->sell_date}}</span><br>
            <span>Due date: {{$document->due_date}}</span>
        </p>
    </div>
</div>

<p>
    {{$document->description}}
</p>
<p>
    {{$property}}
</p>
<hr>
<table class="table table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Item name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Unit</th>
            <th scope="col">Price</th>
            <th scope="col">Tax [%]</th>
            <th scope="col">Tax amount</th>
            <th scope="col">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
        ?>
    @foreach($details as $detail)
        <tr>
            <td><?php echo $i ?></td>
            <td>{{$detail->item_name}}</td>
            <td>{{$detail->quantity}}</td>
            <td>{{$detail->unit_id}}</td>
            <td>{{$detail->price}}</td>
            <td>{{$detail->tax}}</td>
            <td>{{$detail->tax_amount}}</td>
            <td>{{$detail->amount}}</td>
        </tr>
        <?php
            $i += 1;
        ?>
    @endforeach
    </tbody>
</table>
<p class="mt-4">
    <span class="fw-bold fs-2">Total: </span><span class="fw-bold fs-2">{{$document->total_amount}}</span>
</p>
@endsection