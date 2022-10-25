
@extends('layouts.app')
@section('add_css')
    <style>
        .chart{
            max-width: 440px;
            max-height: 15rem;
        }
    </style>
@endsection

@section('content')
<h3 class="mb-5">{{$title}}</h3>

    <div class="row">
        <div class="d-none" id="chart_1_data">{{$chart_purchases}}</div>
        <div class="col-4">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Purchases in categories</h4>
                    <canvas class=" chart" id="chart_1"></canvas>
                </div>
                
                <div class="col-12">
                    <table class="mt-5 table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Category</th>
                                <th scope="col" class="text-end">Sum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tab_purchases as $key => $value)
                                <tr>
                                    <td>
                                        {{$key}}
                                    </td>
                                    @if($value > 0)
                                        <td class="text-end text-danger">
                                            {{$value[0]}}
                                        </td>
                                    @else
                                        <td class="text-end text-success">
                                            {{$value[0]}}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        
        <div class="d-none" id="chart_2_data">{{$chart_sales}}</div>
        <div class="col-4">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Sales in categories</h4>
                    <canvas class="chart col-4" id="chart_2"></canvas>
                </div>

                <div class="col-12">
                    <table class="mt-5 table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Category</th>
                                <th scope="col" class="text-end">Sum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tab_sales as $key => $value)
                                <tr>
                                    <td>
                                        {{$key}}
                                    </td>
                                    @if($value < 0)
                                        <td class="text-end text-danger">
                                            {{$value[0]}}
                                        </td>
                                    @else
                                        <td class="text-end text-success">
                                            {{$value[0]}}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        

        <div class="d-none" id="chart_3_data">{{$sales_vs_purchases}}</div>
        <div class="col-4">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Sales vs. purchases</h4>
                    <canvas class="chart col-4" id="chart_3"></canvas>
                </div>

                <div class="col-12">
                    <table class="mt-3 table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Totals</th>
                                <th scope="col" class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tab_sales_vs_purchases as $key => $value)
                                <tr>
                                    <th>
                                        {{$key}}
                                    </th>
                                    @if($value < 0)
                                        <th class="text-end text-danger">
                                            {{$value}}
                                        </th>
                                    @else
                                        <th class="text-end text-success">
                                            {{$value}}
                                        </th>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        

        <!--<div class="d-none" id="chart_4_data"></div>
        <canvas class="chart col" id="chart_4"></canvas>-->
    </div>
    

    

<script type="text/javascript">
    //global options
    //don't display chart's legend
    Chart.defaults.plugins.legend.display = false;

    //chart 1
    let chart_1 = document.getElementById('chart_1').getContext('2d');
    let chart_1_str = document.getElementById('chart_1_data').textContent;
    eval('var chart_1_data='+chart_1_str);
    
    let barChart = new Chart(chart_1,  chart_1_data);

    //chart 2
    let chart_2 = document.getElementById('chart_2').getContext('2d');
    let chart_2_str = document.getElementById('chart_2_data').textContent;
    eval('var chart_2_data='+chart_2_str);
    
    let barChart2 = new Chart(chart_2,  chart_2_data);

    //chart 3
    let chart_3 = document.getElementById('chart_3').getContext('2d');
    let chart_3_str = document.getElementById('chart_3_data').textContent;
    eval('var chart_3_data='+chart_3_str);
    
    let pieChart3 = new Chart(chart_3,  chart_3_data);   
</script>
@endsection
