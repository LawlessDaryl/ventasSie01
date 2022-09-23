
@section('css')
<style>
  #chart {
  /* max-width: 650px; */
  /* margin: 100px auto; */
  margin-left: 0px;
}
</style>
@endsection

<div class="">
  <div class="row">
    <div class="col-12 text-center">
      <p class="h2">Reporte de Ventas por Gestión</p>
    </div>
  </div>





  <div class="form-group">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 text-center">
            <b>Seleccione Sucursal</b>
            <div class="form-group">
              <select wire:model="sucursal_id" class="form-control" id="exampleFormControlSelect1">
                @foreach($listasucursales as $l)
                <option value="{{$l->id}}">{{$l->name}}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 text-center">
            <b>Seleccione Usuario</b>
            <div class="form-group">
              <select wire:model="usuario_id" class="form-control" id="exampleFormControlSelect1">
                <option value="Todos">Todos los Usuarios</option>
                @foreach($listausuarios as $lu)
                <option value="{{$lu->id}}">{{$lu->name}}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 text-center">
            <b>Seleccione Gestión</b>
            <div class="form-group">
              <select wire:model="year" class="form-control" id="exampleFormControlSelect1">
                @foreach($years_sales as $a)
                <option value="{{$a->year}}">{{$a->year}}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 text-center">
          <b style="color: aliceblue;">|</b>
            <div class="form-group">
              <button wire:click.prevent="aplicar_filtros()" type="button" class="btn btn-outline-primary form-control">Aplicar Filtros</button>
            </div>
        </div>
    </div>
</div>
  <div id="chart">
  </div>
</div>



@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



<script>
      document.addEventListener('DOMContentLoaded', function() {
        


        window.livewire.on('cargar-grafico', msg => {





            
          var options = {
            chart: {
              type: 'area',
              height: '500',
              // width: '1000',
            },
            series: [{
              name: 'Ventas',
              data: [@this.meses[0], @this.meses[1], @this.meses[2], @this.meses[3], @this.meses[4], @this.meses[5], @this.meses[6], @this.meses[7], @this.meses[8], @this.meses[9], @this.meses[10], @this.meses[11]]
            }],
            xaxis: {
              categories: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
            }
          }

          var chart = new ApexCharts(document.querySelector("#chart"), options);

          chart.render();
          
          
        });


        
    });
</script>
@endsection

