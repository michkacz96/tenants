<?php
    use App\Models\Formula;
    use App\Models\PropertySellitem;
?>
@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary" href="/properties/">Back to list of properties</a>
    </nav>
    <button type="button" onclick="calculate()">Calculate</button>
    <div class="mt-3">
        {!! Form::open(['action' => ['App\Http\Controllers\RentsController@storeInvoiceDetails', $invoice->id], 'method' => 'POST', 'id' => 'items_form']) !!}
        <table id="items_table" class ="table">
            <thead>
                <tr>
                    <th scope="col">Item name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Unit price</th>
                    <th scope="col">Tax</th>
                    <th scope="col">Tax amount</th>
                    <th scope="col">Amount</th>
                    <th scope="col"><button type="button" class="btn btn-sm btn-success" onclick="addRow()">+</button></th>
                </tr>
            </thead>
            <?php
                $i = 0;
            ?>
            <tbody>
                @if(count((is_countable($items)?$items:[])))
                    @foreach($items as $item)
                    <tr>
                        <td>
                            {{Form::text('invoice['.$i.'][item]', $item->item_name, ['class' => 'form-control form-control-sm', 'placeholder' => 'Item name', 'required'])}}
                        </td>
                        <td>
                            {{Form::text('invoice['.$i.'][quantity]', PropertySellitem::calculateQuantity($item->pivot->id, $invoice), ['class' => 'form-control form-control-sm', 'placeholder' => 'Quantity', 'required', 'min' => '0', 'step' => '0.0001', 'onChange' => 'calculate()'])}}
                        </td>
                        <td></td>
                        <td>
                            {{Form::number('invoice['.$i.'][unit_price]', $item->pivot->price, ['class' => 'form-control form-control-sm', 'placeholder' => 'Unit price', 'required', 'min' => '0', 'step' => '0.01', 'onChange' => 'calculate()'])}}
                        </td>
                        <td>
                            {{Form::number('invoice['.$i.'][tax]', '', ['class' => 'form-control form-control-sm', 'placeholder' => 'Tax', 'required', 'min' => '0', 'step' => '0.01', 'onChange' => 'calculate()'])}}
                        </td>
                        <td>
                            {{Form::number('invoice['.$i.'][tax_amount]', '', ['class' => 'form-control form-control-sm', 'placeholder' => 'Tax amount', 'required', 'min' => '0', 'step' => '0.01', 'readonly'])}}
                        </td>
                        <td>
                            {{Form::number('invoice['.$i.'][amount]', '', ['class' => 'form-control form-control-sm', 'placeholder' => 'Amount', 'required', 'min' => '0', 'step' => '0.01', 'readonly'])}}
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow()">-</button>
                        </td>
                        <?php
                            $i += 1;
                        ?>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="my-3 clearfix">
            {{Form::submit('Add new document', ['class' => 'btn btn-primary float-end'])}}
        </div>
        {!! Form::close() !!}
    </div>
    
@endsection

<script>
    function addRow(){
        var table = document.getElementById("items_table");
        var lastRow = table.rows[ table.rows.length - 1 ];
        var lastNumber = parseInt(lastRow.cells[0].innerHTML);
        var item = lastNumber + 1;
        var row = table.insertRow(-1);
        var cells = new Array(8);

        for(var i = 0; i<8; i++){
            cells[i] = row.insertCell(i);
        }

        cells[0].innerHTML = '<td><input class="form-control form-control-sm" placeholder="Item name" required="" name="invoice['+item+'][\'item\']" type="text"></td>';
        cells[1].innerHTML = '<td><input class="form-control form-control-sm" placeholder="Quantity" required min="0" step="0.0001" name="invoice['+item+'][\'quantity\']" type="number" onChange="calculate()"></td>';
        cells[2].innerHTML = '<td></td>';
        cells[3].innerHTML = '<td><input class="form-control form-control-sm" placeholder="Unit price" required min="0" step="0.01" name="invoice['+item+'][\'unit_price\']" type="number" onChange="calculate()"></td>';
        cells[4].innerHTML = '<td><input class="form-control form-control-sm" placeholder="Tax" required min="0" step="0.01" name="invoice['+item+'][\'tax\']" type="number" onChange="calculate()"></td>';
        cells[5].innerHTML = '<td><input class="form-control form-control-sm" placeholder="Tax amount" required min="0" step="0.01" readonly name="invoice['+item+'][\'tax_amount\']" type="number"></td>';
        cells[6].innerHTML = '<td><input class="form-control form-control-sm" placeholder="Amount" required min="0" step="0.01" readonly name="invoice['+item+'][\'amount\']" type="number"></td>';
        cells[7].innerHTML = '<button type="button" class="btn btn-sm btn-danger" onclick="deleteRow()">-</button>';
    }

    function calculate(){
        var table = document.getElementById("items_table");

        for(var i=1; i<table.rows.length; i++){
            //calculate value no tax
            var amount_noTax = parseFloat(table.rows[i].cells[1].children[0].value).toFixed(4) * parseFloat(table.rows[i].cells[3].children[0].value).toFixed(4);
            

            //calculate tax
            var tax = amount_noTax * table.rows[i].cells[4].children[0].value / 100;
            table.rows[i].cells[5].children[0].value = tax.toFixed(2);
            
            //calculate amount
            var amount = amount_noTax + tax;
            table.rows[i].cells[6].children[0].value = amount.toFixed(2);
        }
    }

    function deleteRow(){
        var td = event.target.parentNode; 
        var tr = td.parentNode; // the row to be removed
        tr.parentNode.removeChild(tr);
    }
</script>