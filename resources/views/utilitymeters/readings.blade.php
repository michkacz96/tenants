<?php
    use App\Models\VisualData;
?>
@extends('layouts.app')
@section('add_css')
@endsection

@section('content')
    <h1>{{$title}}</h1>
    <nav class="nav nav-pills my-3">
        <a class="btn btn-secondary me-3" href="/properties/">Back to list of properties</a>
        <a class="btn btn-secondary me-3" href="/utilitymeters/">Back to list of utility meters</a>
        <a class="btn btn-secondary me-3" href="/utilitymeters/{{$utility_meter->id}}/addreading">Add reading</a>
    </nav>

    <div class="row">
        <div class="mt-3 col-6">
            @if(count((is_countable($readings)?$readings:[])))
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Reading date</th>
                            <th scope="col">Reading</th>
                            <th scope="col">Usage</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $prev = null;

                            $vis = new VisualData;
                            $vis->setType('line');
                             foreach($readings as $reading){
                                 $vis->setLabels($reading->reading_date);
                             }
                            $vis->setDiagramLabel('Reading');

                            // foreach($readings as $reading){
                            //     $vis->setData($reading->reading);
                            // }
 
                            
                        ?> 
                    @foreach($readings as $reading)
                        <tr>
                            <th scope="row">{{$reading->reading_date}}</th>
                            <td>{{$reading->reading}} {!! $reading->utilityMeter->utilityMeterType->unit->HTML_entity !!}</td>
                            <td><?php
                                if($prev){
                                    $vis->setData($reading->reading - $prev);
                                    if($reading->reading - $prev < 0){
                                        echo '<span class="text-danger">';
                                    } else{
                                        echo '<span>';
                                    }
                                    echo $reading->reading - $prev.' '.$reading->utilityMeter->utilityMeterType->unit->HTML_entity.'</span>';
                                } else{
                                    $vis->setData(0);
                                }
                            ?></td>
                            <td>
                                {!! Form::open(['action' => ['App\Http\Controllers\UtilityMeterReadingsController@deleteReading', $reading->id], 'method' => 'POST', 'class' => 'float-end']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btn-block'])}}
                                {!! Form::close() !!}
                                <a href="/utilitymeters/{{$reading->id}}/editreading" class="btn btn-sm btn-secondary float-end mx-1 btn-block">Edit</a>
                            </td>
                        </tr>
    
                        <?php
                            $prev = $reading->reading;
                        ?>
                    @endforeach

                    <?php
                        $vis_data = $vis->generate();
                    ?>
                    </tbody>
                </table>
            @endif
        </div><!-- readings table -->

        <div class="mt-3 col-6">
            <h5 class="text-center">Usage of the utility</h5>
            <div class="d-none" id="chart_1_data">{{$vis_data}}</div>
            <canvas class="chart col" id="chart_1"></canvas>
        </div>
    </div>
    
    <script type="text/javascript">
        //global options
        Chart.defaults.plugins.legend.display = false;
    
        //chart 1
        let chart_1 = document.getElementById('chart_1').getContext('2d');
        let chart_1_str = document.getElementById('chart_1_data').textContent;
        eval('var chart_1_data='+chart_1_str);
        
        let barChart = new Chart(chart_1,  chart_1_data);
    </script>
@endsection