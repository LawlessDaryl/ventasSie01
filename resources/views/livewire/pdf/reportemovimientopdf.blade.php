<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Transferencia</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link href="{{ asset('assets/css/tables/table-basic.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL CUSTOM STYLES -->

    <style>
        table {
        width: 100%;
        border: 1px solid rgb(255, 255, 255);
        }
        th, td {
       
        text-align: left;
        vertical-align: top;
        border: 1px solid rgb(255, 255, 255);
        }
    </style>



    
</head>

<body style="background-color: rgb(255, 255, 255)">

    
    <section class="header" style="top: -287px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="vertical-align: top; padding-top:10px; position:relative;">
                    <img src="{{ asset('assets/img/sie2022.jpg') }}" alt="" class="invoice-logo" height="70px">
                </td>
                <td class="text-left" colspan="2">
                    <p style="font-size: 20px; font-weight:bold;">Soluciones Informáticas Emanuel</p>
                   
                </td>
               
            </tr>
        
        </table>
        
    </section>

    <div style="margin-top: -150px;">
        <br>
        <table class="table table-bordered table-striped mt-1">
            
               
                   
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe text-center" style="font-size: 100%">#</th>
                                <th class="table-th text-withe text-center" style="font-size: 100%">FECHA</th>
                             
                                <th class="table-th text-withe text-center" style="font-size: 100%">DETALLE</th>
                                
                                <th class="table-th text-withe text-center" style="font-size: 100%">INGRESO</th>
                                <th class="table-th text-withe text-center" style="font-size: 100%">EGRESO</th>
                                <th class="table-th text-withe text-center" style="font-size: 100%">UTILIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($totalesIngresos as $p)
                                <tr>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">{{ $loop->iteration }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">
                                            {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                        </h6>
                                    </td>
                                  
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">
                                            {{ $p->carteramovtype }},{{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'EFECTIVO':$p->ctipo }}- Usuario: {{ $p->usuarioNombre }}</h6>
                              
                                  
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">{{ $p->mimpor }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">
                                            @if($p->tipoDeMovimiento == 'VENTA')
                                             {{ number_format($this->buscarutilidad($this->buscarventa($p->movid)->first()->idventa), 2) }}
                                             @elseif($p->tipoDeMovimiento == 'SERVICIOS')
                                             {{ $this->buscarservicio($p->movid)}}
                                            @endif
                                        </h6>
                                    </td>
                                    
                                </tr>
                            @endforeach
                            @foreach ($totalesEgresos as $p)
                            <tr>
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">{{ $loop->iteration }}
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">
                                        {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                    </h6>
                                </td>
                              
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">
                                        {{ $p->carteramovtype }}-{{ $p->tipoDeMovimiento }}-{{ $p->cajaNombre }}-{{ $p->usuarioNombre }}</h6>
                          
                              
                                </td>
                               
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">{{ $p->mimpor }}
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">
                                    </h6>
                                </td>
                                
                            </tr>


                           

                        @endforeach
                        
                        </tbody>
                    
                    <table>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                     <h5 class="text-dark-right" style="border-bottom:2rem">TOTAL INGRESOS Bs</h5>
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
                                    
                                </td>
                            </tr>
                            
                    </tfoot>
                    </table>
                
            
        </table>
        <div style="margin-top:100px;" >
            
            <table>
                <th colspan="1">

                </th>
                <th style="border-top: 2px solid #000; width: 2rem">
                    ENCARGADO
                </th>
                <th  colspan="1">

                </th>
                
                <th>

                </th>
            </table>
         
            
        
         </div>

    </div>


</body>

</html>