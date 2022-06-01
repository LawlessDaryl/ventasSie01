<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Compra</title>
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

<body>
    <section class="header" style="top: -287px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="text-center" colspan="2">
                    <span style="font-size: 25px; font-weight:bold;">Sistema SIE</span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top; padding-top:10px; position:relative;">
                    <img src="{{ asset('assets/img/sie.png') }}" alt="" class="invoice-logo">
                </td>

                <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top:8px;">
                        <span style="font-size: 16px;"><strong>COMPRA N°</strong>{{$data->id}}</span>
                        <br>
                        <span style="font-size: 16px;"><strong>Proveedor:</strong>{{$data->nombre_prov}} </span>
                        <br>    
                        <span style="font-size: 16px;"><strong>Fecha de Compra:</strong>{{$data->fecha_compra}}</span>
                    <br>

                    <span style="font-size: 14px;">Usuario: {{ Auth()->user()->name }}</span>}}
                    <br>
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th width="12%">CODIGO</th>
                    <th width="10%">DESCRIPCION</th>
                    <th width="12%">UNIDAD</th>
                    <th width="12%">CANTIDAD</th>
                    <th width="12%">COSTO/U</th>
                    <th width="12%">SUBTOTAL</th>
                    <th width="12%">DESCUENTO</th>
                    <th width="12%">TOTAL</th>
                   
                </tr>
            </thead>

            <tbody>
                @foreach ($detalle as $item)
                    <tr>
                        <td align="center">{{ $nro++ }}</td>
                        <td align="center">{{ $item->barcode}}</td>
                        <td align="center">{{ $item->nombre }}</td>
                        <td align="center">{{ $item->unidad}}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                        <td align="center">{{ $item->precio }}</td>
                        <td align="center">{{ $item->precio*$item->cantidad }}</td>
                        <td align="center">0</td>
                        <td align="center">{{ $item->precio*$item->cantidad}}</td>
                    </tr>
                @endforeach
            </tbody>
            <br>
    
            <tfoot>
                <tr>
                    <td class="text-center">
                        <span><b>TOTALES</b></span>
                    </td>
                    <td class="text-center" colspan="4">
                        <span><strong>Bs {{$data->importe_total}}</strong></span>
                        <br>
                        <span><strong>$us{{round($data->importe_total/6.96,2)}}</strong></span>
                    </td>
                  
                    <td colspan="2"></td>
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
                    <span>página</span><span class="pagenum">-</span>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
