<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Venta</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
</head>

<body>
    <section class="header" style="top: -287px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="text-center" colspan="2">
                    <span style="font-size: 20px; font-weight:bold;">Comprobante de Venta</span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top; padding-top:10px; position:relative;">
                    <img src="{{ asset('assets/img/sie2022.jpg') }}" alt="" class="invoice-logo">
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: -110px;">
    Total Bs: {{$total}}
    Usuario: {{$usuario}}


    <br>

    <table class="table table-bordered table-striped mt-1">
        <thead class="text-white" style="background: #3b3f5c ">
            <tr>
                <th class="table-th text-left text-white">IMAGEN</th>
                <th class="table-th text-left text-white">DESCRIPCIóN</th>
                <th class="table-th text-center text-white">PRECIO</th>
                <th width="12%" class="table-th text-center text-white">CANTIDAD</th>
                <th class="table-th text-center text-white">IMPORTE</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($idventa as $item)
            <tr>
                <td>
                    <h6>{{ $item->id }}</h6>
                </td>
                <td>
                    <h6>{{ $item->price }}</h6>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>




    
    <br>



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