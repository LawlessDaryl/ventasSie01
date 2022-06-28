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
                    <span style="font-size: 20px; font-weight:bold;">Transferencia N° 000{{$ide}} </span>
                </td>
               
            </tr>
            <tr style="color: rgb(75, 75, 75)">
                
                <td colspan="2" style="vertical-align: top; padding-top:5px; position:relative;">
                        Origen de Transferencia:{{$origen}}
                        <br>
                        Destino de Transferencia:{{$destino}}
                        <br>
                      
                </td>
                <td style="vertical-align: top; padding-top:5px; position:relative;" colspan="2">
                    Fecha de Recepcion:{{ \Carbon\Carbon::parse($fecha)->format('Y-m-d')}}
                    <br>
                    Responsable de Recepcion: {{$userrecepcion}}
                </td>
            </tr>
        </table>
        
    </section>

    <div style="margin-top: -150px;">
        <br>
        <table class="table table-bordered table-striped mt-1">
            <thead class="text-white" style="background: #e4e0e0 ">
                <tr>
                    <th class="table-th text-left text-dark">Item</th>
                    <th class="table-th text-left text-dark">DESCRIPCIóN</th>
                    <th class="table-th text-center text-dark">CANTIDAD</th>
                </tr>
            </thead>
            <tbody style="background-color: rgb(255, 255, 255)">
                
                    @foreach ($datalist_destino as $ob)
                    <tr>
                        <td>
                            <h6 class="text-center">{{ $loop->iteration }}</h6>
                        </td>
                        <td>
                            <h6 class="text-center">{{ $ob->producto->nombre }}</h6>
                        </td>
                        <td>
                            <h6 class="text-center">{{ $ob->cantidad }}</h6>
                        </td>
                        
                    </tr>
                @endforeach
               
                <br>
                <br>
                <br>
                <br>
                <br>
                
            </tbody>
        </table>
        <div style="margin-top:100px;" >
            
            <table>
                <th colspan="1">

                </th>
                <th style="border-top: 2px solid #000; width: 2rem">
                    Recibido por
                </th>
                <th  colspan="1">

                </th>
                <th style="border-top: 2px solid #000;  width: 2rem">
                    Entregado por
                </th>
                <th>

                </th>
            </table>
         
            
        
         </div>

    </div>


</body>

</html>