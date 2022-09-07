<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<table style="width: 100%;">
    <tbody>
        <tr>
            <td class="text-center" style="font-size: 10px; width: 33%;">
                {{strtoupper($nombreempresa)}}
                <br>
                Sistema EDSOFT
                <br>
                {{$direccionempresa}}
                <br>
                4240013- 79771777
            </td>
            <td class="text-center" style="width: 33%;">
                
            </td>
            <td class="text-center" style="width: 33%;">
                <img src="{{ asset('storage/icons/' . $logoempresa) }}" alt="" class="invoice-logo" height="70px">
            </td>
        </tr>
    </tbody>
</table>

<hr style="height:1px;border:none;color:rgb(189, 188, 188);background-color:rgb(0, 0, 0);" />

<table style="width: 100%;">
    <tbody>
        <tr>
            <td style="font-size: 10px; width: 33%;">
                Señor(es);
                <br>
                {{ucwords(strtolower($detalles_extra->nombrecliente))}}
                <br>
                Presente.-
            </td>
            <td class="text-center" style="width: 33%;">
                
            </td>
            <td class="text-center" style="font-size: 10px; width: 33%;">
                Cochabamba, {{$dia_mes_actual}} de {{$year}}
                <br>
                {{-- I.T.No: 6952/3913 --}}
            </td>
        </tr>
    </tbody>
</table>


    <div class="row">
        
        <div class="card-body text-center">
          <h5 class="card-title">INFORME TÉCNICO ORDEN N°: {{$codigo}}</h5>
          
        </div>
        <div style="padding-left: 17px;">
            <p style="font-size: 12px;">Saludos</p>
            <p style="font-size: 12px;">
              De mi mayor consideración, y a petición del interesado le hacemos llegar el detalle del trabajo realizado e
  información adicional adjunta, en relación al servicio prestado por personal de nuestra empresa, al igual que el
  detalle de costos y materiales empleados descritos a continuación:
            </p>
        </div>



        <div style="padding-left: 57px;">




            <table class="table table-striped" style="font-size: 11px;">
                <tbody>
                    <tr>
                        <td class="text-center">
                            {{ucwords(strtolower($detalles_extra->nombrecategoria))}}
                            {{ucwords(strtolower($datos_servicio->marca))}}
                            {{$detalles_extra->detalle}} - 
                            {{ucwords(strtolower($detalles_extra->tipotrabajo))}}

                        </td>
                    </tr>
                    <tr>
                        <td><b>Fecha Recepción:</b> {{ \Carbon\Carbon::parse($fecharecepcion)->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><b>Falla Según Cliente:</b> {{ ucwords(strtolower($datos_servicio->falla_segun_cliente)) }}</td>
                    </tr>
                    <tr>
                        <td><b>Diagnóstico</b> {{ ucwords(strtolower($datos_servicio->diagnostico)) }}</td>
                    </tr>
                    <tr>
                        <td><b>Solución:</b> {{ ucwords(strtolower($datos_servicio->solucion)) }}</td>
                    </tr>
                    <tr>
                        <td><b>Responsable Técnico:</b> {{ ucwords(strtolower($responsable_tecnico)) }}</td>
                    </tr>
                    <tr>
                        <td><b>Precio Servicio:</b> {{ ucwords(strtolower($detalles_extra->precioservicio)) }} Bs</td>
                    </tr>
                </tbody>
              </table>
            
        </div>






        <div style="padding-left: 17px;">
            <p style="font-size: 12px;">
                Para veracidad de la misma firmamos al pie del documento tanto los responsables como el personal encargado
                de la supervisión y control de calidad de nuestra Empresa.
                Sin más que decir me despido,
                Atentamente
            </p>
        </div>


        <br>
        <br>
        <br>
        <br>



        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td class="text-center" style="font-size: 10px; width: 50%;">
                        <hr style="height:1px; border:none ;background-color:rgb(0, 0, 0); width: 50%;" />
                        Administrador
                        <br>
                        DPTO. TECNICO 
                    </td>
                </tr>
            </tbody>
        </table>

        <br>
        <div style="font-size: 10px;"">
            {{strtoupper($nombreempresa)}} | Cochabamba, {{$dia_mes_actual}} de {{$year}}
        </div>




      </div>
</body>
</html>