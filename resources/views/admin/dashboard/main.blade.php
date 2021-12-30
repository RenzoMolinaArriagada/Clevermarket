@extends('admin.principal')

@section('content')
<div class="col align-self-center">
	@if(session('exito'))
	    <div class="alert alert-success text-md-center" role="alert">
			{{session('exito')}}
		</div>
	@endif
</div>
	<div class="row m-3">
		<h4>Datos sobre las ventas</h4>
	</div>
	<div class="row m-3">
		<div class="col-md-1">
			<h5><label for="anoVenta" class="form-label">Año:</label></h5>
		</div>
		<div class="col-md-2">
			<select name="anoVenta" class="selectAno form-control">
				<option selected value="{{now()->year}}">{{now()->year}}</option>
				<option value="{{now()->year - 1}}">{{now()->year - 1}}</option>
				<option value="{{now()->year - 2}}">{{now()->year - 2}}</option>
				<option value="{{now()->year - 3}}">{{now()->year - 3}}</option>
				<option value="{{now()->year - 4}}">{{now()->year - 4}}</option>
			</select>
		</div>
	</div>
	<div class="row m-3">
		<h5>Ventas por mes</h5>
		<div class="col-md-12">
			<div class="d-none d-sm-block">	
				<canvas id="myChart" height="50"></canvas>	
			</div>
			<div class="d-block d-sm-none">
				<canvas id="myChart2" height="150"></canvas>	
			</div>
		</div>
	</div>
	<div class="row m-3">
		<h5>Ventas por clase de producto (Anual)</h5>
		<div class="col-md-4 col-xs-12">
			<div class="d-none d-sm-block">	
				<canvas id="chartCatsm" height="150"></canvas>	
			</div>
			<div class="d-block d-sm-none">
				<canvas id="chartCatxs" height="150"></canvas>	
			</div>
		</div>
	</div>
	<div class="row m-3">
		<div class="col-md-6">
			<h4><i class="fas fa-file-download"></i> Descarga de reportes</h4>
		</div>
	</div>
	<div class="row m-3">
		<div class="col-md-6">
			<a class="btn btn-xs btn-primary m-1" id="desProdVenta" href="{{ route('admin.descargaProductosVendidos') }}">Reporte de productos vendidos</a>
		</div>
	</div>
	<div class="row m-3">
		<div class="col-md-6">
			<h4><i class="fas fa-tools"></i> Acciones masivas</h4>
		</div>
	</div>
	<div class="row m-3">
		<div class="col-md-6">
			<a class="btn btn-xs btn-primary m-1" href="{{route('admin.formProductoMasivo')}}">Carga masiva de Productos</a>
		</div>
	</div>
@endsection
@section('ajax')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

});

Chart.defaults.global.legend.display = false;

const colorScheme = [
    "#25CCF7","#FD7272","#54a0ff","#00d2d3",
    "#1abc9c","#2ecc71","#3498db","#9b59b6","#34495e",
    "#16a085","#27ae60","#2980b9","#8e44ad","#2c3e50",
    "#f1c40f","#e67e22","#e74c3c","#ecf0f1","#95a5a6",
    "#f39c12","#d35400","#c0392b","#bdc3c7","#7f8c8d",
    "#55efc4","#81ecec","#74b9ff","#a29bfe","#dfe6e9",
    "#00b894","#00cec9","#0984e3","#6c5ce7","#ffeaa7",
    "#fab1a0","#ff7675","#fd79a8","#fdcb6e","#e17055",
    "#d63031","#feca57","#5f27cd","#54a0ff","#01a3a4"
]

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        datasets: [{
            data: [{{$ventasPorMes[0]}}, {{$ventasPorMes[1]}}, {{$ventasPorMes[2]}}, {{$ventasPorMes[3]}}, {{$ventasPorMes[4]}}, {{$ventasPorMes[5]}},{{$ventasPorMes[6]}}, {{$ventasPorMes[7]}}, {{$ventasPorMes[8]}}, {{$ventasPorMes[9]}}, {{$ventasPorMes[10]}}, {{$ventasPorMes[11]}}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Custom Chart Title',
            },
            legend: {
            	display: false,
            }
        },
        responsive: true,
    },
});

var ctx2 = document.getElementById('myChart2').getContext('2d');
var myChart2 = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        datasets: [{
            data: [{{$ventasPorMes[0]}}, {{$ventasPorMes[1]}}, {{$ventasPorMes[2]}}, {{$ventasPorMes[3]}}, {{$ventasPorMes[4]}}, {{$ventasPorMes[5]}},{{$ventasPorMes[6]}}, {{$ventasPorMes[7]}}, {{$ventasPorMes[8]}}, {{$ventasPorMes[9]}}, {{$ventasPorMes[10]}}, {{$ventasPorMes[11]}}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Custom Chart Title',
            },
            legend: {
            	display: false,
            }
        },
        responsive: true,
    },
});
Chart.defaults.global.legend.display = true;

var cCatSm = document.getElementById('chartCatsm').getContext('2d');
var cCatXs = document.getElementById('chartCatxs').getContext('2d');
var myChartSm = new Chart(cCatSm, {
    type: 'pie',
    data: {
        labels: {!!$nombreClases!!},
        datasets: [{
            data: {!!$cantidadClases!!},
      		backgroundColor: colorScheme,
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Custom Chart Title',
            },
            legend: {	
            	position: 'top',
            	display: true
            }
        },
        responsive: true,
    },
});
var myChartXs = new Chart(cCatXs, {
    type: 'pie',
    data: {
        labels: {!!$nombreClases!!},
        datasets: [{
            data: {!!$cantidadClases!!},
      		backgroundColor: colorScheme,
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Custom Chart Title',
            },
            legend: {	
            	position: 'top',
            	display: true
            }
        },
        responsive: true,
    },
});


$('#content').on('change','.selectAno',function(){
	var anoVentas = $('.selectAno').children("option:selected").val();
	$.ajax({
	    	type:'POST',
	    	url:"{{ route('venta.ventasPorMes') }}",
	    	data:{anoVentas:anoVentas,_method:'POST'},
	    	success:function(data){
	    		var ventasPorMes = data.ventasPorMes;
	    		var nombreClases = data.nombreClases;
	    		var cantidadClases = data.cantidadClases;

	    		//Grafico Ventas por Mes
			    myChart.data.datasets.forEach((dataset) => {
			        dataset.data = ventasPorMes;
			    });
			    myChart.update();

			    myChart2.data.datasets.forEach((dataset) => {
			        dataset.data = ventasPorMes;
			    });
			    myChart2.update();

				//Grafico Ventas por Clases
			    myChartSm.data.labels = nombreClases;
			    myChartSm.data.datasets.forEach((dataset) => {
			        dataset.data = null;
			    });
			    myChartSm.data.datasets.forEach((dataset) => {
			        dataset.data = cantidadClases;
			    });
			    myChartSm.update();

			    myChartXs.data.labels = nombreClases;
			    myChartXs.data.datasets.forEach((dataset) => {
			        dataset.data = null;
			    });
			    myChartXs.data.datasets.forEach((dataset) => {
			        dataset.data = cantidadClases;
			    });
			    myChartXs.update();				
	    	},
	    	error:function(data){
	    		alert("Ha ocurrido un error inesperado");
	    	}
	    });
	});

</script>
@endsection