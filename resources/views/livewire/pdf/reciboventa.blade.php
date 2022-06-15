<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Venta</title>
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
        width: 25%;
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
                <td class="text-center" colspan="2">
                    <span style="font-size: 20px; font-weight:bold;">Comprobante de Venta</span>
                    <p style="font-size: 20px; font-weight:bold;">Soluciones Informáticas Emanuel</p>
                </td>
                <td class="text-right">
                    <p style="font-size: 9px; color: black">{{$datossucursal->nombresucursal}} <br>{{$datossucursal->direccionsucursal}}</p>
                </td>
            </tr>
            <tr style="color: rgb(75, 75, 75)">
                
                <td colspan="2" style="vertical-align: top; padding-top:5px; position:relative;">
                        Razón Social:{{$datoscliente->razonsocial}}
                        <br>
                        NIT:{{$datoscliente->nit}}
                        <br>
                        Celular:{{$datoscliente->celular}}
                </td>
                <td style="vertical-align: top; padding-top:5px; position:relative;" colspan="2">
                    Fecha Emisión:{{$fecha}}
                    <br>
                    Cajero: {{$nombreusuario->name}}
                </td>
            </tr>
        </table>
        
    </section>

    <div style="margin-top: -150px;">
        <br>
        <table class="table table-bordered table-striped mt-1">
            <thead class="text-white" style="background: #e4e0e0 ">
                <tr>
                    <th class="table-th text-left text-dark" colspan="2">DESCRIPCIóN</th>
                    <th class="table-th text-center text-dark">PRECIO (Bs)</th>
                    <th class="table-th text-center text-dark">CANTIDAD</th>
                    <th class="table-th text-center text-dark">IMPORTE (Bs)</th>
                </tr>
            </thead>
            <tbody style="background-color: rgb(255, 255, 255)">
                @foreach ($venta as $item)
                <tr>
                    <td style="padding: 0%" colspan="2">
                        {{ $item->nombre }}
                    </td>
                    <td style="padding: 0%" class="text-right">
                        {{ number_format($item->precio, 2) }}
                    </td>
                    <td style="padding: 0%" class="text-center">
                        {{ $item->cantidad }}
                    </td>
                    <td style="padding: 0%" class="text-right">
                        {{ number_format($item->precio *  $item->cantidad, 2) }} Bs
                    </td>
                </tr>
                @endforeach
                <tr style="background: #e4e0e0 ">
                    <td>
                        <b>TOTALES</b>
                    </td>
                    <td class="text-right">
                        
                    </td>
                    <td class="text-right">
                        
                    </td>
                    <td class="text-center">
                        <b>{{$totalitems}}</b>
                    </td>
                    <td style="padding: 0%" class="text-right">
                        <b>{{ number_format($total,2) }} Bs</b>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    {{-- <section class="footer">
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
    </section> --}}

</body>

</html>