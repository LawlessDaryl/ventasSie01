<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ganacias de Transacciones Tigo Money</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
</head>

<body>
    <section class="header" style="top: -287px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="text-center" colspan="2">
                    <span style="font-size: 25px; font-weight:bold;">Sistema SIE</span>
                </td>
            </tr>
            <tr>
                <td width="30%" class="text-center"style="vertical-align: top; padding-top:10px; position:relative;">
                    <img src="{{ asset('assets/img/sie.png') }}" alt="" class="invoice-logo">
                </td>

                <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top:10px;">
                    @if ($reportType == 0)
                        <span style="font-size: 16px;"><strong>Reporte de Ganancias de Transacciones del día</strong></span>
                    @else
                        <span style="font-size: 16px;"><strong>Reporte de Ganancias de Transacciones por fecha</strong></span>
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
            <thead>
                <tr>
                    <th width="3%">Nº</th>
                    <th width="17%">FECHA</th>
                    <th width="10%">IMPORTE</th>
                    <th width="10%">CEDULA</th>
                    <th width="10%">ESTADO</th>
                    <th width="10%">ORIGEN</th>
                    <th width="10%">MOTIVO</th>
                    <th width="10%">GANANCIA</th>                    
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr height="10px">
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1> {{ $loop->iteration }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->created_at }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ number_format($item->importe, 2) }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1> {{ $item->cedula }}</FONT>
                        </td>                        
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->estado }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->origen_nombre }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->motivo_nombre }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ number_format($item->ganancia, 2) }}</FONT>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <br>

            <tfoot>
                <tr>
                    <td colspan="2" class="text-left">
                        <span><b>TOTALES</b></span>
                    </td>
                    <td class="text-right" colspan="6">
                        <span><strong>${{ number_format($data->sum('ganancia'), 2) }}</strong></span>
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
                <td width="60%" class="text-center"> sieemanuelsie@gmail.com</td>
                <td class="text-center" width="20%">
                    <span>Página</span><span class="pagenum">-</span>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
