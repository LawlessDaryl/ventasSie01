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
                    <img src="assets/img/fav05.png" width="50" height="50" alt="navbar brand">
                </td>
                <td class="text-center">
                    <h4><b>REPORTE DE MOVIMIENTO DIARIO</b></h4>
                </td>
                <td rowspan="2">
                    <img src="assets/img/fav05.png" width="50" height="50" alt="navbar brand">
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    Soluciones Informáticas Emanuel
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
                    <th class="text-center">FECHA</th>
                    <th class="text-center">DETALLE</th>
                    <th class="text-right">INGRESO(Bs)</th>
                    <th class="text-right">EGRESO(Bs)</th>
                    <th class="text-right">
                        @if(@Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
                        UTILIDAD(Bs)
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($totalesIngresosV as $row)
                    <tr style="background-color: rgb(235, 235, 235)">
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($row['movcreacion'])->format('d/m/Y H:i') }}
                        </td>
                        <td class="text-center">
                            {{$row['idventa']}} {{ $row['tipoDeMovimiento'] }} {{ $row['ctipo'] =='CajaFisica'?'Efectivo':$row['ctipo'] }} ({{ $row['nombrecartera'] }})
                        </td>
                        <td class="text-right">
                            {{ $row['importe'] }}
                        </td>
                        <td>
                            
                        </td>
                        <td class="text-right">
                            @if(@Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
                            {{ number_format($row['utilidadventa'],2) }}
                            @endif
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
                                            Desc/Rec
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
                                        <td class="filarownombre">
                                            {{-- {{rtrim(mb_strimwidth($item['nombre'], 2, 2, '...', 'UTF-8'))}} --}}
                                            {{-- {{$item['nombre']}} --}}
                                            {{substr($item['nombre'], 0, 25)}}
                                        </td>
                                        <td class="filarow">
                                            {{number_format($item['po'],2)}}
                                        </td>
                                        <td class="filarow">
                                            @if($item['po'] - $item['pv'] == 0)
                                            {{$item['po'] - $item['pv']}}
                                            @else
                                            {{($item['po'] - $item['pv']) * -1}}
                                            @endif
                                        </td>
                                        <td class="filarow">
                                            {{number_format($item['pv'],2)}}
                                        </td>
                                        <td class="filarow">
                                            {{$item['cant']}}
                                        </td>
                                        <td class="filarow">
                                            {{number_format($item['pv'] * $item['cant'],2)}}
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
                
                @foreach ($totalesIngresosS as $p)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($p['movcreacion'])->format('d/m/Y H:i') }}
                    </td>
                
                    <td class="text-center">
                        {{ $p['idordenservicio'] }} {{ $p['tipoDeMovimiento'] }} {{ $p['ctipo'] =='CajaFisica'?'Efectivo':$p['ctipo'] }} ({{ $p['nombrecartera'] }})
                    </td>
                    <td class="text-right">
                        {{ number_format($p['importe'],2) }}
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-right">
                        @if(@Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
                        {{ number_format($p['utilidadservicios'],2) }}
                        @endif
                    </td>
                </tr>
                @endforeach
                @foreach ($totalesIngresosIE as $ie)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($ie['movcreacion'])->format('d/m/Y H:i') }}
                    </td>
                  
                    <td class="text-center">
                        {{ $ie['ctipo'] =='CajaFisica'?'Efectivo':$ie['ctipo'] }}({{ $ie['nombrecartera']}})
                    </td>
                    <td class="text-right">
                        {{ $ie['importe'] }}
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    
                </tr>
            @endforeach
            @foreach ($totalesEgresosV as $px)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($px['movcreacion'])->format('d/m/Y H:i') }}
                    </td>
                  
                    <td class="text-center">
                        {{ $px['tipoDeMovimiento'] }} {{ $px['ctipo'] =='CajaFisica'?'Efectivo':$px['ctipo'] }} {{ $px['nombrecartera'] }})
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-right">
                        {{ $px['importe'] }}
                    </td>
                    <td>
                        
                    </td>
                    
                </tr>
                @endforeach

                @foreach ($totalesEgresosIE as $st)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($st['movcreacion'])->format('d/m/Y H:i') }}
                    </td>
                
                    <td class="text-center">
                        {{ $st['ctipo'] =='CajaFisica'?'Efectivo':$st['ctipo'] }}({{ $st['nombrecartera'] }})
                    </td>
                    <td>
                    
                    </td>
                    <td class="text-right">
                        {{ $st['importe'] }}
                    </td>
                    <td>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
            
        </table>

        <br>
        <br>

        <table class="estilostable">
            <thead>
                <tr class="tablehead">
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot class="estilostable">
                <tr>
                    <td colspan="6" style="background-color: rgb(224, 157, 80)">

                    </td>
                </tr>
                {{-- INGRESOS TOTALES --}}
                <tr>
                <td class="text-right" colspan="3">
                    INGRESOS TOTALES
                </td>
                <td class="text-right">
                    {{ number_format($ingresosTotales,2) }}
                </td>
                <td colspan="2">
                </td>
                </tr>

                {{-- DESCOMPOSICION DE LOS INGRESOS TOTALES --}}
                {{-- OPERACIONES EN EFECTIVO --}}
                <tr>
                    <td class="text-right" colspan="3">
                        Operaciones en efectivo
                    </td>
                    <td class="text-right">
                        {{ number_format($ingresosTotalesCF,2) }}
                    </td>
                    <td class="text-right" colspan="2">
                    </td>
                </tr>

                {{-- OPERACIONES NO EFECTIVAS TIGO/SISTEMAS/TELEFONO --}}

                <tr>
                    <td class="text-right" colspan="3">
                        Operaciones en TIGO/SISTEMA/TELEFONO
                    </td>
                    <td class="text-right">
                        {{ number_format($ingresosTotalesNoCFNoBancos,2) }}
                    </td>
                    <td colspan="2">
                    </td>
                </tr>

                {{-- OPERACIONES NO EFECTIVAS BANCOS --}}

                <tr>
                    <td class="text-right" colspan="3">
                        Operaciones en Bancos
                    </td>
                    <td class="text-right">
                        {{ number_format($ingresosTotalesNoCFBancos,2) }}
                    </td>
                    <td colspan="2">
                    </td>
                </tr>
                {{-- OPERACIONES DEDUCCION TIGOMONEY --}}
                <tr>
                    <td class="text-right" colspan="3">
                        Saldo en caja fisica de operaciones en Tigo Money
                    </td>
                    <td class="text-right">
                        {{ number_format($total,2) }}
                    </td>
                    <td colspan="2">
                    </td>
                </tr>

                {{-- FIN DESCOMPOSICION DE LOS INGRESOS TOTALES --}}

                {{-- EGRESOS TOTALES --}}
                <tr>
                    <td class="text-right" colspan="3">
                        EGRESOS TOTALES
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-right">
                        {{ number_format($EgresosTotales,2) }}
                    </td>

                    <td>

                    </td>
                </tr>

                {{-- DESCOMPOSICION DE LOS INGRESOS TOTALES --}}

                {{-- egresos en efectivo --}}
                <tr>
                    <td class="text-right" colspan="3">
                        Egresos en efectivo
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-right">
                        {{ number_format($EgresosTotalesCF,2) }}
                    </td>

                    <td>

                    </td>
                </tr>

                {{-- Egresos por sistema --}}

                <tr>
                    <td class="text-right" colspan="3">
                        Egresos sistema/telefono
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-right">
                        {{ number_format($EgresosTotalesNoCFNoBancos,2) }}
                    </td>

                    <td>

                    </td>
                </tr>

                {{-- EgresosTotalesNoCFBancos --}}

                <tr>
                    <td class="text-right" colspan="3">
                        Egresos por bancos
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-right">
                        {{ number_format($EgresosTotalesNoCFBancos,2) }}
                    </td>

                    <td>

                    </td>
                </tr>

                {{-- FIN DESCOMPOSICION DE LOS INGRESOS TOTALES --}}

                {{-- subtotalcaja --}}

                    <tr>
                        <td class="text-right" colspan="3">
                            SUBTOTAL EN CAJA
                        </td>
                        <td class="text-right">
                                {{ number_format($subtotalcaja,2) }}
                                
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>

                    <tr>
                        <td class="text-right" colspan="3">
                            SALDO EFECTIVO
                        </td>
                        <td class="text-right">
                                {{ number_format($operacionesefectivas,2) }}
                                
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>

                    <tr>
                        <td class="text-right" colspan="3">
                            APERTURA
                        </td>
                        <td class="text-right">
                            {{ number_format($ops,2) }}
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>

                
                    <tr>
                        <td class="text-right" colspan="3">
                            TOTAL
                        </td>
                        <td class="text-right">
                            {{ number_format($operacionesW,2) }}
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>
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