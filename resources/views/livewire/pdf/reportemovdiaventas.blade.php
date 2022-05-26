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
    }
    .seleccionar:hover {
    background-color: skyblue;
    cursor: pointer;
    /* box-shadow: 10px 10px 0px 0px #46A2FD, 20px 20px #83C1FD, 30px 30px 14px #ACD5FD; */
    /* transform: translate(-5px, -5px); */

    background: #f1eaa9d2;
    transform: translate(0px, -4px);;
    transition-duration: 0.3s;
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
    <table class="estilostable" style="color: rgb(0, 0, 0)">
        <thead>
          <tr class="tablehead">
            <th class="text-center">N°</th>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Cartera</th>
            <th>Caja</th>
            <th>Movimiento</th>
            <th class="text-right">Importe</th>
            <th class="text-center">Motivo</th>
            @if($num2 == true)
            <th class="text-center">Sucursal</th>
            @endif
          </tr>
        </thead>
        <tbody>
            @foreach ($value as $item)
                <tr class="seleccionar">
                    <td class="text-center">
                        {{$loop->iteration}}
                    </td>
                    <td>
                        {{ date("d/m/Y", strtotime($item['fecha'])) }}
                    </td>
                    <td>
                        {{ $item['nombreusuario'] }}
                    </td>
                    <td>
                        {{ $item['nombrecartera'] }}
                    </td>
                    <td>
                    {{ ucwords($item['nombrecaja']) }}
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
                    {{ ucwords($item['importe']) }} Bs
                    </td>
                    <td class="text-center">
                    {{ ucwords($item['motivo']) }}
                    </td>
                    @if($num2 == true)
                    <td class="text-center">
                    {{ ucwords($item['nombresucursal']) }}
                    </td>
                    @endif
                </tr>
                @endforeach
        </tbody>
    </table>
</body>
</html>