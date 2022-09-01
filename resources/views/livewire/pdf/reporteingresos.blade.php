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
        font-size: 12px;
        border-spacing: 0px;
        color: black;
        }
        .estilostable .tablehead{
            background-color: #dbd4d4;
            font-size: 10px;
        }
        .estilostable2 {
        width: 100%;
        font-size: 9px;
        border-spacing: 0px;
        color: black;
        }
        .estilostable2 .tablehead{
            background-color: white;
        }
        .fnombre{
            border: 0.5px solid rgb(204, 204, 204);
        }
        .filarow{
            border: 0.5px solid rgb(204, 204, 204);
            width: 20px;
            text-align: center;
        }
        .filarowpp{
            border: 0.5px solid rgb(204, 204, 204);
            width: 53px;
            text-align: center;
            font-size: 8px;
        }
        .filarownombre{
            border: 0.5px solid rgb(204, 204, 204);
            width: 150px;
        }
    
        .filarowx{
            border: 0.5px solid rgb(255, 255, 255);
            width: 100%;
            text-align: center;
        }
    
    
        </style>
</head>
<body class="row">
    <table class="filarowx">
        <tbody>
            <tr class="filarowx">
                <td rowspan="2">
                    <img src="{{ asset('storage/icons/' . $logoempresa) }}" width="50" height="50">
                </td>
                <td class="text-center">
                    <h4><b>REPORTE DE INGRESOS</b></h4>
                </td>
                <td rowspan="2">
                    <img src="{{ asset('storage/icons/' . $logoempresa) }}" width="50" height="50">
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    {{$nombreempresa}}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="estilostable">
        <tbody>
            <tr>
                <td colspan="2"><b>Sucursal:</b> {{$sucursal}}</td>
                <td><b>Caja:</b> {{$caja}}</td>
                <td><b>Fecha Inicial:</b> {{\Carbon\Carbon::parse($fromDate)->format('d-m-Y')}}</td>
                <td><b>Fecha Final:</b> {{\Carbon\Carbon::parse($toDate)->format('d-m-Y')}}</td>
            </tr>
        </tbody>
    </table>
    
<br>

    <div class="">
        <table class="estilostable">
            <thead>
                <tr class="tablehead">
                    <th>FECHA</th>
                    <th>TIPO DE MOVIMIENTO</th>
                    <th>CARTERA</th>
                    <th>IMPORTE</th>
                    <th>MOTIVO</th>
                    <th>USUARIO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos as $row)
                    <tr style="background-color: rgb(235, 235, 235)">
                        <td>
                            {{ \Carbon\Carbon::parse($row['movimientoCreacion'])->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            {{$row['carteramovtype']}}
                        </td>
                        <td>
                            {{ $row['nombre'] }}
                        </td>
                        <td>
                            {{ $row['import'] }}
                        </td>
                        <td>
                            {{ $row['comentario'] }}
                        </td>
                        <td>
                            {{ $row['usuarioNombre'] }}
                        </td>
                      
                    </tr>
                 
                @endforeach
                
             
        <br>
        <br>
        </table>

        <table class="estilostable">
            <thead>
                <tr class="tablehead">
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-right"></th>
                </tr>
            </thead>
          
            <tfoot class="estilostable">
                <tr>
                    <td colspan="3" style="border-top: 1px solid #dbd4d4">

                    </td>
                </tr>
                {{-- Ingresos Totales de las carteras tipo Caja Física --}}
                
            </tfoot>
        </table>

    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <table class="filarowx">
        <tbody>
            <tr class="filarowx">
                <td>
                    
                </td>
                <td class="text-center">
                    <hr style="height: 0.5px;
                    width: 150px;
                    background-color: rgb(0, 0, 0);">
                    Cajero
                </td>
                <td>
                    
                </td>
                <td class="text-center">
                    <hr style="height: 0.5px;
                    width: 150px;
                    background-color: rgb(0, 0, 0);">
                    Revisado por
                </td>
                <td>
                    
                </td>
            </tr>
            {{-- <tr>
                <td class="text-center">
                    Soluciones Informáticas Emanuel
                </td>
            </tr> --}}
        </tbody>
    </table>


</body>
</html>