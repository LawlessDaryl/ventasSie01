
@section('css')


<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" class="dashboard-sales" />

<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto);

body {
  font-family: Roboto, sans-serif;
}

#chart {
  max-width: 60%;
  margin: 35px auto;
}
</style>


@endsection


<div class="row sales layout-top-spacing">
  <div class="col-sm-12" >

          <!-- Secciones para las Ventas -->
          <div class="widget widget-chart-one">
              <div class="widget-heading text-center">






                <div class="container">
                  <div class="row">
                    <div class="col-12">
                      
                      <h2>
                        Ventas por Mes - 2022
                      </h2>
                      


                    </div>



                    <div class="col-4">





                      {{-- <div class="col-lg-2 col-md-12 col-sm-12">
                        <div>
                            <h6>Seleccionar Usuario</h6>
                        </div>
                        <select wire:model="usuarioseleccionado" class="form-control">
                            @foreach ($listausuarios as $u)
                            <option value="{{$u->id}}">{{$u->nombreusuario}}</option>
                            @endforeach
                            <option value="Todos" selected>Todos los Usuarios</option>
                        </select>
                      </div> --}}






                      <div class="col-lg-8">
                        <div>
                            <h6>Seleccionar Usuario</h6>
                        </div>
                        <select wire:model="usuarioseleccionado" class="form-control">
                          @foreach ($listausuarios as $u)


                            @if($this->verificarpermisosventa($u->id))
                            <option value="{{$u->id}}">{{$u->nombreusuario}}</option>
                            @endif






                          @endforeach
                          <option value="Todos" selected>Todos los Usuarios</option>
                      </select>
                      </div>
                    </div>



                    <div class="col-4">
                      <div class="col-lg-8">
                        <div>
                            <h6>Seleccionar Tipo Bs</h6>
                        </div>
                          <select wire:model="usuarioseleccionado" class="form-control">
                              
                              <option value="">Emanuel</option>
                              
                              <option value="Todos" selected>Todos los Usuarios</option>
                          </select>
                      </div>
                    </div>



                    <div class="col-4">
                      <div class="col-lg-8">
                        <div>
                            <h6>Seleccionar Año</h6>
                        </div>
                          <select wire:model="usuarioseleccionado" class="form-control">
                              
                            <option value="">2022</option>
                            <option value="">2022</option>
                            <option value="">2022</option>
                            <option value="">2022</option>
                              
                              <option value="Todos" selected>Todos los Usuarios</option>
                          </select>
                      </div>
                    </div>

                  </div>
                </div>





              </div>


              <div id="chart">
              </div>



          </div>
  </div>
</div>







    


@section('javascript')

<script>
      var options = {
      chart: {
        type: 'bar'
      },
      series: [{
        name: 'Ventas Emanuel',
        data: [{{$enero}},{{$febrero}},{{$marzo}},{{$abril}},{{$mayo}},{{$junio}},{{$julio}},{{$agosto}},{{$septiembre}},{{$octubre}},{{$noviembre}},{{$diciembre}}]
      }],
      xaxis: {
        categories: [
          'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre'
        ]
      }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
</script>

{{-- <script>
    var options = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'Ventas',
    data: [{{$numero}},40,45,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: ['Emanuel',1992,1993,1994,1995,1996,1997, 1998,1999]
  }
}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
</script> --}}


<script>
    var options = {
          series: [{
          data: [21, 22, 10, 28, 16, 21, 13, 30]
        }],
          chart: {
          height: 350,
          type: 'bar',
          events: {
            click: function(chart, w, e) {
              // console.log(chart, w, e)
            }
          }
        },
        colors: colors,
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        xaxis: {
          categories: [
            ['John', 'Doe'],
            ['Joe', 'Smith'],
            ['Jake', 'Williams'],
            'Amber',
            ['Peter', 'Brown'],
            ['Mary', 'Evans'],
            ['David', 'Wilson'],
            ['Lily', 'Roberts'], 
          ],
          labels: {
            style: {
              colors: colors,
              fontSize: '12px'
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>


@endsection

