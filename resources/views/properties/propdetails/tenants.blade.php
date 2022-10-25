        @if(count((is_countable($propten)?$propten:[])))
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Tenant name</th>
                    <th scope="col">Start date</th>
                    <th scope="col">End date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($propten as $pten)
                <tr>
                    <th scope="row">
                        {{$pten->tenant_name}}
                    </th>
                    <td>
                        {{$pten->pivot->start_rent_date}}
                    </td>
                    <td>
                        @if($pten->pivot->end_rent_date !== NULL)
                        {{$pten->pivot->end_rent_date}}
                        @else
                        <span class="text-success">Current</span>
                        @endif
                    </td>
                    <td>
                        {!! Form::open(['action' => ['App\Http\Controllers\RentsController@deleteRecord', $pten->pivot->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                        {!! Form::close() !!}
                        <a href="/properties/{{$pten->pivot->id}}/editrecord" class="btn btn-sm btn-primary float-end mx-1 btn-block">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Nothing to display yet</p>
        @endif
