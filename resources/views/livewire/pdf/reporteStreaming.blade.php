<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Servicios</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
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
                        @if ($cuenPerf == 0)
                            @if ($vigVenc == 0)
                                <span style="font-size: 16px;"><strong>Reporte de perfiles vigentes de Streaming del
                                        día</strong></span>
                            @else
                                <span style="font-size: 16px;"><strong>Reporte de perfiles vencidos de Streaming del
                                        día</strong></span>
                            @endif
                        @else
                            @if ($vigVenc == 0)
                                <span style="font-size: 16px;"><strong>Reporte de cuentas vigentes de Streaming del
                                        día</strong></span>
                            @else
                                <span style="font-size: 16px;"><strong>Reporte de cuentas vencidos de Streaming del
                                        día</strong></span>
                            @endif
                        @endif
                    @else
                        @if ($cuenPerf == 0)
                            @if ($vigVenc == 0)
                                <span style="font-size: 16px;"><strong>Reporte de perfiles vigentes de Streaming por
                                        fechas
                                    </strong></span>
                            @else
                                <span style="font-size: 16px;"><strong>Reporte de perfiles vencidos de Streaming por
                                        fechas
                                    </strong></span>
                            @endif
                        @else
                            @if ($vigVenc == 0)
                                <span style="font-size: 16px;"><strong>Reporte de cuentas vigentes de Streaming por
                                        fechas
                                    </strong></span>
                            @else
                                <span style="font-size: 16px;"><strong>Reporte de cuentas vencidos de Streaming por
                                        fechas
                                    </strong></span>
                            @endif
                        @endif
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

                    <span style="font-size: 14px;">Usuario: {{ $user }}</span>
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: -110px;">
        <table cellpadding="0" cellspacing="-1" class="table-items" width="100%" height="50%">
            @if ($cuenPerf == 0)
                <thead>
                    <tr>
                        <th width='8%'>PLATAFORMA</th>
                        <th width='8%'>CLIENTE</th>
                        <th width='8%'>CELULAR</th>
                        <th width='8%'>CORREO</th>
                        <th width='8%'>CONTRASEÑA CUENTA</th>
                        <th width='8%'>VENCIMIENTO CUENTA</th>
                        <th width='8%'>NOMBRE PERFIL</th>
                        <th width='8%'>PIN</th>
                        <th width='8%'>IMPORTE</th>
                        <th width='8%'>PLAN INICIO</th>
                        <th width='8%'>PLAN FIN</th>
                    </tr>
                </thead>
            @else
                <thead>
                    <tr>
                        <th width='8%'>PLATAFORMA</th>
                        <th width='8%'>CLIENTE</th>
                        <th width='8%'>CELULAR</th>
                        <th width='8%'>CORREO</th>
                        <th width='8%'>CONTRASEÑA CUENTA</th>
                        <th width='8%'>VENCIMIENTO CUENTA</th>
                        <th width='8%'>IMPORTE</th>
                        <th width='8%'>PLAN INICIO</th>
                        <th width='8%'>PLAN FIN</th>
                    </tr>
                </thead>
            @endif
            @if ($cuenPerf == 0)
                <tbody>
                    @foreach ($data as $p)
                        <tr height="10px">
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->plataforma }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->cliente }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->celular }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->correo }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->password_account }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->accexp }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->nameprofile }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->pin }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->importe }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>
                                    {{ \Carbon\Carbon::parse($p->planinicio)->format('d:m:Y') }}
                                </FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>
                                    {{ \Carbon\Carbon::parse($p->planfin)->format('d:m:Y') }} </FONT>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <tbody>
                    @foreach ($data as $p)
                        <tr height="10px">
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->plataforma }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->cliente }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->celular }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->correo }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->password_account }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->accexp }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>{{ $p->importe }}</FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>
                                    {{ \Carbon\Carbon::parse($p->planinicio)->format('d:m:Y') }}
                                </FONT>
                            </td>
                            <td align="center">
                                <FONT FACE="times new roman" SIZE=1>
                                    {{ \Carbon\Carbon::parse($p->planfin)->format('d:m:Y') }} </FONT>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
            <br>

            <tfoot>
                <tr>
                    <td colspan="2" class="text-left">
                        <span><b>TOTALES</b></span>
                    </td>
                    @if ($cuenPerf == 0)
                        <td class="text-right " colspan="7">
                            <span><strong>
                                    ${{ number_format($data->sum('importe'), 2) }}
                                </strong></span>
                        </td>
                    @else
                        <td class="text-right " colspan="5">
                            <span><strong>
                                    ${{ number_format($data->sum('importe'), 2) }}
                                </strong></span>
                        </td>
                    @endif
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
