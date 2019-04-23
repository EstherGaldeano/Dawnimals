@extends('frontend.plantillas.master')
@section('titulo','CHART')
@section('contenido')
<br>
<div class="container">
        <img src="{{ asset('img/banner-stats.png') }}" class="img-fluid" alt="Responsive image">
        <h1 style="position: relative;left: -476px;top: -65px; text-align:center"id="typer"></h1>
    <!-- Bar and Line Chart -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-area-chart"></i> Donaciones del mes </div>
        <div class="card-body">
              <div id="groupFechasTipos" class="form-group row">
                    <div class="col-xl-4 m-auto">
                        <label for="fechaInicioTipos" class="">De: </label>
                        <input type="month" name="fechaInicioTipos" id="fechaInicioTipos" class="form-control d-inline" value="{{ \Carbon\Carbon::now()->subYears(1)->format('Y-m')}}">
                    </div>

                    <div class="col-xl-4 m-auto">
                        <label for="fechaFinalTipos" class="d-inline">Hasta: </label>
                        <input type="month" name="fechaFinalTipos" id="fechaFinalTipos" class="form-control" value="{{date('Y-m')}}">
                    </div>
                </div>
            <canvas id="myAreaChart" width="100%" data-upd="0" height="30"></canvas>
        </div>
        {{-- <div class="card-footer small text-muted">Updated today at @php  echo date('F j, Y', time() ) @endphp</div> --}}
    </div>

    <!-- Donut Chart -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-area-chart"></i> Donaciones por animal </div>
        <div class="card-body">
            <canvas id="doughnutChar" width="100%" height="30"></canvas>
        </div>
        {{-- <div class="card-footer small text-muted">Updated today at @php  echo date('F j, Y', time() ) @endphp</div> --}}
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-area-chart"></i> Donaciones por centro </div>
        <div class="card-body">
            <canvas id="polarAreaChar" width="100%" height="30"></canvas>
        </div>
        {{-- <div class="card-footer small text-muted">Updated today at @php  echo date('F j, Y', time() ) @endphp</div> --}}
    </div>


</div>


@endsection

@section( 'js_loaded' )
<script src="{{url( 'js/charts/jquery.min.js' )}}"></script>

<script src="{{url( 'js/charts/Chart.min.js' )}}"></script>

<script src="{{url( 'js/charts/create-line_bar-charts.js' )}}"></script>
<script src="{{url( 'js/charts/create-doughnut-chart.js' )}}"></script>
<script src="{{url( 'js/charts/create-polar-area-chart.js' )}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
        var typer = $('#typer');
        var txt = '{{__("frontend.estadisticas")}}';
        var textoAmostrar='';
        var speed = 50;
        var i=0;
        var j=0;
        typerEffect();

    function typerEffect(){
        if (i < txt.length){
            textoAmostrar+= txt.charAt(i)
            typer.html(textoAmostrar);
            i++;
            setTimeout(typerEffect, speed);
        }
    };
    </script>
    @endsection
