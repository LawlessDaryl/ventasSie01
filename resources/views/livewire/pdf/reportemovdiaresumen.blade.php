<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movimiento Diario General-Resumen</title>



    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

    <style>
        .estilostable {
        width: 100%;
        font-size: 10px;
        border-spacing: 0px;
        color: black;
        }
        .estilostable .tablehead{
            background-color: #dbd4d4;
            font-size: 8px;
        }
        .estilostable2 {
        width: 100%;
        font-size: 7px;
        border-spacing: 0px;
        color: black;
        }
        .estilostable2 .tablehead{
            background-color: white;
        }
        .fnombre{
            border: 0.5px solid rgb(148, 148, 148);
        }
        .filarow{
            border: 0.5px solid rgb(148, 148, 148);
            width: 20px;
            text-align: center;
        }
        .filarowpp{
            border: 0.5px solid rgb(148, 148, 148);
            width: 53px;
            text-align: center;
        }
    
    
    
    
        </style>
</head>
<body class="row">
    
    <center><b>REPORTE DE MOVIMIENTO DIARIO</b></center>
    <center>Soluciones Informáticas Emanuel</center>

    
    


    <div class="">
        <table class="estilostable">
            <thead>
                <tr class="tablehead">
                    <th class="text-center">FECHA</th>
                    <th class="text-center">DETALLE</th>
                    <th class="text-right">INGRESO(Bs)</th>
                    <th class="text-right">EGRESO(Bs)</th>
                    <th class="text-right">UTILIDAD(Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($totalesIngresosV as $row)
                    <tr>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($row['movcreacion'])->format('d/m/Y H:i') }}
                        </td>
                        <td class="text-center">
                            {{ $row['tipoDeMovimiento'] }} {{ $row['ctipo'] =='CajaFisica'?'Efectivo':$row['ctipo'] }} ({{ $row['nombrecartera'] }})
                        </td>
                        <td class="text-right">
                            {{ $row['importe'] }}
                        </td>
                        <td>
                            
                        </td>
                        <td class="text-right">
                            {{ number_format($row['utilidadventa'],2) }}
                        </td>
                        <td>
                            
                        </td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <table class="estilostable2">
                                <thead>
                                    <tr>
                                        <td class="fnombre">
                                            Nombre
                                        </td>
                                        <td class="filarowpp">
                                            Precio Original
                                        </td>
                                        <td class="filarow">
                                            Descuento
                                        </td>
                                        <td class="filarowpp">
                                            Precio Venta
                                        </td>
                                        <td class="filarow">
                                            Cantidad
                                        </td>
                                        <td class="filarow">
                                            Total
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($row['detalle'] as $item)
                                    <tr class="">
                                        <td class="fnombre">
                                            {{-- {{rtrim(mb_strimwidth($item['nombre'], 0, 2, '...', 'UTF-8'))}} --}}
                                            {{$item['nombre']}}
                                        </td>
                                        <td class="filarow">
                                            {{$item['precioventa']}}
                                        </td>
                                        <td class="filarow">
                                            NN
                                        </td>
                                        <td class="filarow">
                                            {{$item['pv']}}
                                        </td>
                                        <td class="filarow">
                                            {{$item['cant']}}
                                        </td>
                                        <td class="filarow">
                                            NN
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>
</html>