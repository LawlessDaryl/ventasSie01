<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movimiento Diario General</title>
    <style>
        .estilostable {
        width: 100%;
        font-size: 10px;
        border-spacing: 0px;
        }
        
        .tablehead{
            background-color: #434343;
            color: aliceblue;
            font-size: 10px;
        }
        .text-center{
            text-align:center;
        }
        .text-right{
            text-align:right;
        }
        .text-left{
            text-align:left;
        }
    
    
    
    
        </style>
</head>
<body>
    <center><h4 class="card-title text-center">REPORTE DE MOVIMIENTO DIARIO - GENERAL</h4></center>
    


    <div class="">
        <table class="estilostable">
            <thead>
                <tr class="tablehead">
                    <th>#</th>
                    <th>FECHA</th>
                    <th>DETALLE</th>
                    <th>INGRESO</th>
                    <th>EGRESO</th>
                    <th>UTILIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($totalesIngresos as $p)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                        </td>
                      
                        <td>
                            {{ $p->carteramovtype }},{{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'EFECTIVO':$p->ctipo }}- Usuario: {{ $p->usuarioNombre }}
                        </td>
                        <td>
                            {{ $p->mimpor }}
                        </td>
                        <td>

                        </td>
                        <td>
                            {{-- @if($p->tipoDeMovimiento == 'VENTA')
                                {{ number_format($this->buscarutilidad($this->buscarventa($p->movid)->first()->idventa), 2) }}
                                @elseif($p->tipoDeMovimiento == 'SERVICIOS')
                                {{ $this->buscarservicio($p->movid)}}
                            @endif --}}
                        </td>
                        
                    </tr>
                @endforeach
                @foreach ($totalesEgresos as $p)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                    </td>
                  
                    <td>
                        {{ $p->carteramovtype }}-{{ $p->tipoDeMovimiento }}-{{ $p->cajaNombre }}-{{ $p->usuarioNombre }}
                    </td>
                   
                    <td>
                        
                    </td>
                    <td class="text-right">
                        {{ $p->mimpor }}
                    </td>
                    <td>
                        
                    </td>
                </tr>


               

            @endforeach
            
            </tbody>
        </table>


        <table class="estilostable">
            <tfoot>
                <tr>
                    <td colspan="4">
                         <h5 class="text-dark-right">TOTAL INGRESOS Bs</h5>
                         <h5 class="text-dark">OPERACIONES EN EFECTIVO Bs</h5>
                         <h5 class="text-dark">BANCOS/SISTEMA/TELEFONO Bs</h5>
                         <h5 class="text-dark">TOTAL EGRESOS Bs</h5>
                         <h5 class="text-dark">SUB TOTAL EN CAJA Bs </h5>
                         <h5 class="text-dark">TOTAL TRANSACCIONES BANCO/TARJ. CREDITO/DEBITO Bs  </h5>
                         <h5 class="text-dark">TOTAL EFECTIVO EN CAJA Bs </h5>
                         <h5 class="text-dark">UTILIDAD Bs  </h5>
                    </td>
                    <td>
                        <h5 class="text-dark text-center">{{number_format($importetotalingresos),2}}</h5>
                        <h5 class="text-dark text-center">{{number_format($operacionefectivoing),2}}</h5>
                        <h5 class="text-dark text-center">{{number_format($noefectivoing),2}}</h5>
                        <h5 class="text-dark text-center">{{number_format($importetotalegresos),2}}</h5>
                        <h5 class="text-dark text-center">{{number_format($subtotalcaja),2}}</h5>
                        <h5 class="text-dark text-center">{{number_format($noefectivoing-$noefectivoeg),2}}</h5>
                        <h5 class="text-dark text-center">{{number_format($subtotalcaja-$noefectivoing+$noefectivoeg),2}}</h5>
                        <h5 class="text-dark text-center">{{number_format($utilidadtotal),2}}</h5>
                    </td>
                </tr>
                
        </tfoot>
        </table>
    </div>


</body>
</html>