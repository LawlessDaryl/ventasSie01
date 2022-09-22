
@section('css')
<style>
  #chart {
  /* max-width: 650px; */
  /* margin: 100px auto; */
  margin-left: 0px;
}
</style>
@endsection

<div class="container">
  <div class="row">
    <div class="col-12 text-center">
      <p class="h2">Reporte de Ventas por Gestión</p>
      <button wire:click="$emit('cargar-grafico')">
        Iniciar
      </button>
    </div>
  </div>
  <div class="row">
    <div class="col order-first">
      <div class="form-group">
        <label for="exampleFormControlSelect1">Seleccione Sucursal</label>
        <select wire:model="sucursal_id" class="form-control" id="exampleFormControlSelect1">
          @foreach($listasucursales as $l)
          <option value="{{$l->id}}">{{$l->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="exampleFormControlSelect1">Seleccione Usuario</label>
        <select wire:model="usuario_id" class="form-control" id="exampleFormControlSelect1">
          @foreach($listausuarios as $lu)
          <option value="{{$lu->id}}">{{$lu->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col order-last">
      <div class="form-group">
        <label for="exampleFormControlSelect1">Seleccione Gestión</label>
        <select wire:model="year" class="form-control" id="exampleFormControlSelect1">
          @foreach($years_sales as $a)
          <option value="{{$a->year}}">{{$a->year}}</option>
          @endforeach
        </select>
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
              data: [@this.enero, @this.febrero,@this.marzo,@this.abril,@this.mayo,@this.junio,@this.julio,@this.agosto,@this.septiembre,@this.octubre,@this.noviembre,@this.diciembre]
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

