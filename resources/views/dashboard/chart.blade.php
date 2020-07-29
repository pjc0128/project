@extends('layout.layout')

@section('content')
    <div class="card-body" style="margin:10px;">
        <div class="chart-area"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
            @yield('chart1')
        </div>
        <hr>
        Styling for the area chart can be found in the <code>/js/demo/chart-area-demo.js</code> file.
    </div>


    <div class="card shadow mb-4" style="margin : 10px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
        </div>
        <div class="card-body">
            <div class="chart-bar"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                @yield('chart2')
                {{--                <canvas id="myBarChart" width="327" height="160" class="chartjs-render-monitor" style="display: block; width: 327px; height: 160px;"></canvas>--}}
            </div>
            <hr>
            Styling for the bar chart can be found in the <code>/js/demo/chart-bar-demo.js</code> file.
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Donut Chart</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    @yield('chart3')
                </div>
                <hr>
                Styling for the donut chart can be found in the <code>/js/demo/chart-pie-demo.js</code> file.
            </div>
        </div>
    </div>
@endsection

