<?php
    use App\Models\Formula;
?>
@if(count((is_countable($sellitems)?$sellitems:[])))
<table class="table table-sm">
    <thead>
        <tr>
            <th scope="col">Sell item</th>
            <th scope="col">Formula</th>
            <th scope="col">Start date</th>
            <th scope="col">End date</th>
            <th scope="col">Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($sellitems as $sellitem)
        <tr>
            <th scope="row">
                {{$sellitem->item_name}}
            </th>
            <td>
                {{Formula::getName($sellitem->pivot->formula_id)}}
            </td>
            <td>
                {{$sellitem->pivot->start_date}}
            </td>
            <td>
                {{$sellitem->pivot->end_date}}
            </td>
            <td>
                {{$sellitem->pivot->price}}
            </td>
            <td>
                {!! Form::open(['action' => ['App\Http\Controllers\RentsController@deleteRecord', $sellitem->pivot->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                {!! Form::close() !!}
                <a href="/properties/{{$sellitem->pivot->id}}/editrecord" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Nothing to display yet</p>
@endif
