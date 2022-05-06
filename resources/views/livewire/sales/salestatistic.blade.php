
@section('css')


<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" class="dashboard-sales" />

<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto);

body {
  font-family: Roboto, sans-serif;
}

#chart {
  max-width: 650px;
  margin: 35px auto;
}
</style>


@endsection

<div id="chart">
</div>
    


@section('javascript')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



<script>
  var options = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'Ventas',
    data: [{{$numero}},40,45,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: [
      'Emanuel',1992,1993,1994,1995,1996,1997, 1998,1999
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

