<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Servicios</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
    {{-- <style type="text/css" media="print">
        .page
        {
         -webkit-transform: rotate(-90deg); 
         -moz-transform:rotate(-90deg);
         filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
        }
    </style> --}}
</head>

<body>
    <section class="header" style="top: -287px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center" colspan="2">
                    <span style="font-size: 25px; font-weight:bold;">Sistema SIE</span>
                </td>
            </tr>
            <tr>
                <td width="30%" align="center" style="vertical-align: top; padding-top:10px; position:relative;">
                    <img src="{{ asset('assets/img/sie.png') }}" alt="" class="invoice-logo">
                </td>

                <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top:10px;">
                    @if ($reportType == 0)
                        <span style="font-size: 16px;"><strong>Reporte de Servicios del día</strong></span>
                    @else
                        <span style="font-size: 16px;"><strong>Reporte de Servicios por fecha</strong></span>
                    @endif
                    <br>
                    @if ($reportType != 0)
                        <span style="font-size: 16px;"><strong>Fecha de consulta: {{ $dateFrom }} al
                                {{ $dateTo }}</strong></span>
                    @else
                        <span style="font-size: 16px;"><strong>Fecha de consulta:
                                {{ \Carbon\Carbon::now()->format('d-M-Y') }}</strong></span>
                    @endif

                    <br>

                   
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: -110px;">
        <table cellpadding="0" cellspacing="-1" class="table-items" width="100%" height="50%">
            <thead>
                <tr>
                    <th width="4%">#</th>
                    <th width="7%">Fecha</th>
                    <th width="8%">Cliente</th>
                    <th width="4%">Orden</th>
                   {{--  <th width="12%">Fecha Hora Recep.</th>
                    <th width="11%">Fecha Hora Term.</th>
                    <th width="11%">Fecha Hora Entr.</th> --}}
                    <th width="7%">Detalle</th>
                    <th width="5%">Costo</th>
                    <th width="8%">Utilidad</th>
                    {{-- <th width="5%">A cuenta</th>
                    <th width="5%">Saldo</th>
                    <th width="8%">Tipo Servicio</th> --}}

                    
                    {{-- <th width="6%">Estado</th> --}}
                    {{-- <th width="10%">Tec. Resp.</th> --}}
                    
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $d)
                    <tr height="10px">
                        {{-- # --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $loop->iteration }}
                            </FONT>
                        </td>
                        {{-- FECHA --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>
                                @foreach($d->movservices as $movser)
                                @if($movser->movs->type=='ENTREGADO' && $movser->movs->status == 'ACTIVO')
                                    {{ $movser->movs->created_at }}
                                @endif
                            @endforeach
                            </FONT>
                        </td>
                        
                        {{-- CLIENTE --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $d->movservices[0]->movs->climov->client->nombre }}
                            </FONT>
                        </td>
                        {{-- NUMERO ORDEN --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $d->order_service_id }}</FONT>
                        </td>
                        {{-- DETALLE --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $d->categoria->nombre }} {{ $d->marca }} {{ $d->detalle }}
                            </FONT>
                        </td>
                        {{-- COSTO --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ number_format($d->costo, 2) }}</FONT>
                        </td>
                        {{-- IMPORTE --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>
                                {{ number_format($d->movservices[0]->movs->import, 2) }}</FONT>
                        </td>
                    </tr>
                @endforeach
                @if($caja != 'Todos')
                    <tr>
                        <td colspan="9">
                            <h5 class="text-center">Servicios entregados y pagados por banco</h5>
                        </td>
                    </tr>
                @foreach ($movbancarios as $d)
                    <tr height="10px">
                        {{-- # --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $loop->iteration+$contador }}
                            </FONT>
                        </td>
                        {{-- FECHA --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>
                            {{-- @foreach($d->movservices as $movser)
                                @if($movser->movs->type=='ENTREGADO' && $movser->movs->status == 'ACTIVO') --}}
                                    {{ $d->creacion_Mov }}
                                {{-- @endif
                            @endforeach --}}
                            </FONT>
                        </td>
                        
                        {{-- CLIENTE --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $d->nomCli }}
                            </FONT>
                        </td>
                        {{-- NUMERO ORDEN --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $d->orderId }}</FONT>
                        </td>
                        {{-- DETALLE --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $d->nomCat }} {{ $d->marca }} {{ $d->detalle }}
                            </FONT>
                        </td>
                        {{-- COSTO --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ number_format($d->costo, 2) }}</FONT>
                        </td>
                        {{-- IMPORTE --}}
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>
                                {{ number_format($d->import, 2) }}</FONT>
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
            <br>

            <tfoot>
                <tr>
                    <td colspan="2" class="text-left">
                        <span><b>EFECTIVO</b></span>
                    </td>
                    <td class="text-right" colspan="5">
                        <span>
                            
                            {{$sumaEfectivo}}

                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-left">
                        <span><b>TRANSFERENCIA BANCARIA</b></span>
                    </td>
                    <td class="text-right" colspan="5">
                        <span>
                            
                            {{$sumaBanco}}

                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-left">
                        <span><b>TOTALES</b></span>
                    </td>
                    <td class="text-right" colspan="4">
                        <span><strong>
                                
                            ${{ number_format($data->sum('costo'), 2) }}

                            </strong></span>
                    </td>
                    <td class="text-right" colspan="1">
                        <span><strong>
                                @php
                                    $mytotal = 0;                                     
                                @endphp
                                @foreach ($data as $d)
                                    @foreach ($d->movservices as $mv)
                                        @if ($mv->movs->status == 'ACTIVO')
                                            @php
                                                $mytotal = $sumaBanco + $sumaEfectivo;
                                            @endphp                                    
                                        @endif
                                    @endforeach
                                @endforeach
                                ${{ number_format($mytotal, 2) }}

                            </strong></span>
                    </td>
                    
                </tr>
            </tfoot>
        </table>
    </section>

    <section class="footer">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="20%">
                    <span>Sistema SIE</span>
                </td>
                <td width="60%" align="center"> sieemanuelsie@gmail.com</td>
                <td align="center" width="20%">
                    <span>Página</span><span class="pagenum">-</span>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
