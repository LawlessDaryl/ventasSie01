<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movimiento Diario</title>


    

    <style>
    .contenedortabla{
        /* overflow:scroll; */
        overflow-x:auto;
        /* max-height: 100%; */
        /* min-height:200px; */
        /* max-width: 100%; */
        /* min-width:100px; */
    }

    .estilostable {
    width: 100%;
    font-size: 11px;
    text-align:center;
    border-spacing:  0px;
    /* font-size: 8px; */
    }
    .estilostable2 {
    font-size: 11px;
    text-align:center;
    border-spacing:  0px;
    margin-left: auto;
    margin-right: auto;
    }
    
    .tablehead{
        background-color: #383938;
        color: aliceblue;
    }




    </style>

</head>
<body>
    <div class="widget-heading">
        <div class="col-12 col-lg-12 col-md-10">
            <!-- Titulo Detalle Venta -->
            <center><h4 class="card-title text-center"><b>REPORTE DE MOVIMIENTO DIARIO - VENTAS</b></h4></center>
    
        </div>
    </div>
    <table class="estilostable">
        <thead>
          <tr class="tablehead">
            <th class="text-center">N°</th>
            <th style="width: 100px;">FECHA</th>
            <th style="width: 70px;">USUARIO</th>
            <th>CARTERA</th>
            <th style="width: 90px;">CAJA</th>
            <th>MOVIMIENTO</th>
            <th class="text-right" style="width: 70px;">IMPORTE</th>
            <th class="text-center" style="width: 90px;">MOTIVO</th>
            @if($permiso == true)
            <th class="text-center">UTILIDAD</th>
            {{-- <th class="text-center" style="width: 90px;">SUCURSAL</th> --}}
            @endif
          </tr>
        </thead>
        <tbody>
            @foreach ($value as $item)
                <tr>
                    <td class="text-center">
                        {{$loop->iteration}}
                    </td>
                    <td>
                        {{ date("d/m/Y h:i A", strtotime($item['fecha'])) }}
                    </td>
                    <td>
                        {{ $item['nombreusuario'] }}
                    </td>
                    <td>
                        {{ ucwords(strtolower($item['nombrecartera'])) }}
                    </td>
                    <td>
                    {{ ucwords(strtolower($item['nombrecaja'])) }}
                    </td>
                    @if($item['tipo'] == "INGRESO")
                    <td style="color: rgb(8, 157, 212)">
                        <b>{{ $item['tipo'] }}</b>
                    </td>
                    @else
                    <td style="color: rgb(205, 21, 0)">
                    <b>{{ $item['tipo'] }}</b>
                    </td>
                    @endif
                    <td class="text-right">
                    {{ number_format($item['importe'],2) }} Bs
                    </td>
                    <td class="text-center">
                    {{ ucwords($item['motivo']) }}
                    </td>
                    @if($permiso == true)
                    <td class="text-center">
                        @if($item['idmovimiento'] != '-')
                        {{ number_format($item['idmovimiento'],2) }} Bs
                        @endif
                    </td>
                    {{-- <td class="text-center">
                    {{ ucwords($item['nombresucursal']) }}
                    </td> --}}
                    @endif
                </tr>
                @endforeach


                
                <tr>
                    <td colspan="10"></td>
                </tr>

                <br>

                @if($permiso == true)
                <tr>
                    <td colspan="8" class="text-left">
                        TOTAL UTILIDAD
                    </td>
                    <td class="text-right">
                        {{number_format($utilidad,2)}}
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="8">

                    </td>
                </tr>

                @foreach($listacarteras as $cartera)

                    @if($cartera->totales != 0)
                    <tr>
                        <td colspan="8">Total en Cartera: {{ucwords(strtolower($cartera->nombre))}}</td>
                        <td class="text-right">{{number_format($cartera->totales,2)}}</td>
                    </tr>
                    @endif
                @endforeach








                <tr>

                    <td colspan="8">TOTAL INGRESOS</td>
                    <td class="text-right">{{number_format($ingreso,2)}} </td>
                </tr>

                <tr>

                    <td colspan="8">TOTAL EGRESOS</td>
                    <td class="text-right">{{number_format($egreso,2)}} </td>
                </tr>
                <tr>

                    <td class="text-letf" colspan="8">TOTAL INGRESOS - EGRESOS</td>
                    <td class="text-right"> <b>{{number_format( $ingreso - $egreso,2)}}</b> </td>
                </tr>
        </tbody>
    </table>

</body>
</html>