<?php
    use App\Models\Unit;
?>
        @if(count((is_countable($details)?$details:[])))
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $detail)
                <tr>
                    <td>{{$detail->name}}</td>
                    <td>{{$detail->pivot->quantity}} {!!Unit::getUnitEntity($detail->unit_id)!!}</td>
                    <td>{{Unit::checkBlankDate($detail->pivot->detail_start_date)}}</td>
                    <td>{{Unit::checkBlankDate($detail->pivot->detail_end_date)}}</td>
                    <td>
                        {!! Form::open(['action' =>
                        ['App\Http\Controllers\PropertyPropertyDetailsController@deleteDetail', $detail->pivot->id],
                        'method' => 'POST', 'class' => 'float-end']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                        {!! Form::close() !!}
                        <a href="/properties/{{$detail->pivot->id}}/editdetailinfo"
                            class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No content to show yet</p>
        @endif

