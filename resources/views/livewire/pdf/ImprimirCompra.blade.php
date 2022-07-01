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

<body>
    <section class="header" style="top: -287px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
               
                <td style="vertical-align: top; padding-top:10px; position:relative;">
                    <img src="{{ asset('assets/img/sie2022.jpg') }}" alt="" class="invoice-logo" height="70px">
                </td>
                <td class="text-center" colspan="2">
                    <span style="font-size: 20px; font-weight:bold;">Comprobante de Compra</span>
                    <p style="font-size: 20px; font-weight:bold;">Soluciones Informáticas Emanuel</p>
                </td>
            </tr>
            <tr>

                <td colspan="2" style="vertical-align: top; padding-top:5px; position:relative;">
                        <span style="font-size: 16px;"><strong>COMPRA N°</strong>{{$data->id}}</span>
                        <br>
                        <span style="font-size: 16px;"><strong>Proveedor:</strong>{{$data->nombre_prov}} </span>
                        <br>    
                        <span style="font-size: 16px;"><strong>Fecha de Compra:</strong>{{$data->fecha_compra}}</span>
                    <br>

                    <span style="font-size: 14px;">Usuario: {{ $data->user_id }}</span>
                    <br>
                </td>
            </tr>
        </table>
    </section>

    <div style="margin-top:-100px;">
        <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
            <thead>
                <tr>
                    <th class="table-th text-left text-dark">#</th>
                
                    <th class="table-th text-left text-dark" colspan="2">DESCRIPCION</th>
                    <th class="table-th text-left text-dark">UNIDAD</th>
                    <th class="table-th text-left text-dark">CANTIDAD</th>
                    <th class="table-th text-left text-dark">COSTO/U</th>
                  
                 
                    <th class="table-th text-left text-dark">TOTAL</th>
                   
                </tr>
            </thead>

            <tbody style="background-color: rgb(255, 255, 255)">
                @foreach ($detalle as $item)
                    <tr>
                        <td  style="padding: 0%" class="text-right">{{ $nro++ }}</td>
                       
                        <td style="padding: 0%" colspan="2">{{ $item->nombre }}</td>
                         <td style="padding: 0%" class="text-right">{{ $item->unidad}}</td>
                         <td style="padding: 0%" class="text-right">{{ $item->cantidad }}</td>
                         <td style="padding: 0%" class="text-right">{{ $item->precio }}</td>
                  
               
                         <td style="padding: 0%" class="text-right">{{ $item->precio*$item->cantidad}}</td>
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
