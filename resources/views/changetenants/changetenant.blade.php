@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
<h1>{{$texts['title']}}</h1>
<nav class="nav nav-pills my-3">
    <a class="btn btn-secondary" href="/properties">Back to list of properties</a>
</nav>
<div class="mt-3">
    <div class="row">
        <div class="col-md-12 col-lg-6">
            @if(count((is_countable($propten)?$propten:[])))
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Tenant name</th>
                        <th scope="col">Start date</th>
                        <th scope="col">End date</th>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class='text-center'>{{$texts['no_find']}}</p>
            @endif
        </div>

        <div class="col-md-12 col-lg-6">
            {!! Form::open(['action' => ['App\Http\Controllers\RentsController@changeTenant', $property->id], 'method'
            => 'POST']) !!}
            <div class="row">
                <div class="form-group col-md-12 col-lg-6">
                    {{Form::label('start_date', 'Beginning of tenancy')}}
                    {{Form::date('start_date', date('Y-m-d'), ['class' => 'form-control', 'required'])}}
                </div>
                <div class="form-group col-md-12 col-lg-6">
                    {{Form::label('end_date', 'End of tenancy')}}
                    {{Form::date('end_date', '', ['class' => 'form-control'])}}
                </div>

                <div class="form-group col-md-12 col-lg-12">
                    {{Form::label('tenant', 'Tenant')}}
                    {{Form::select('tenant', $tenants, '', ['class' => 'form-select', 'required'])}}
                </div>
            </div>
            <div class="my-3 clearfix">
                {{Form::submit('Change tenant', ['class' => 'btn btn-primary float-end'])}}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
