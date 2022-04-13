<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Servicio</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">



    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

    </style>

<body>
    <section class="header" style="top: -290px; left:-30px">
        <table style=" font-size: 11px;">
            <tr>
                <td style="width: 4.3cm; vertical-align: top; margin-left: 5px; margin-right:5px">
                    <div style=" font-size: 9pt; text-align: center;">
                        <div>
                            <b>SERVICIO TÉCNICO<br>{{ $data[0]->order_service_id }}</b><br>
                            <b>Sucursal: </b>{{ $sucursal->name }}
                        </div>
                    </div>
                    <hr
                        style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                    <div style="text-align: center; font-size: 7pt;">
                        <b>{{ $data[0]->nombreC }}</b>
                        Celular: <b>{{ $data[0]->celular }}</b>
                    </div>
                    <div style=" font-size: 7pt; line-height: 12px">
                        <b>CANT.:{{ $datos->services->count() }}</b>&nbsp;&nbsp;

                        <b>DESCRIPCIÓN: </b>
                        @php
                            $x=0;
                        @endphp
                        @foreach ($datos->services as $item)
                            @php
                                if($x>0){
                                    $n='|';
                                }else{
                                    $n=null;
                                }
                                $x++;
                            @endphp
                            {{$n}} {{ $item->categoria->nombre }} {{ $item->marca }} {{$n}}
                        @endforeach<br>
                        <b><u>FALLA:</u> </b>
                        @foreach ($datos->services as $item)
                            {{ $item->falla_segun_cliente }} {{$n}}
                        @endforeach<br>
                        <b><u>DIAGNOSTICO:</u> </b>
                        @foreach ($datos->services as $item)
                            {{ $item->diagnostico }} {{$n}}
                        @endforeach<br>
                        <b><u>SOLUCION:</u> </b>
                        @foreach ($datos->services as $item)
                            {{ $item->solucion }} {{$n}}
                        @endforeach<br>
                        <b>FECHA ENTREGA APROX.: </b>
                        @foreach ($datos->services as $item)
                            {{ $item->fecha_estimada_entrega }} {{$n}}
                        @endforeach<br>
                        <b>RESPONSABLE TÉCNICO: </b>{{ $usuario->name }}<br>
                    </div>
                    <hr
                        style="border-color: black; margin-top: 0px; margin-bottom: 1px; margin-left: 5px; margin-right:5px">
                    <table id="derechatabla" style="font-weight: bold; font-size: 7pt">
                        <tr>
                            <td style="text-align: right;">TOTALES:</td>
                            <td style="text-align: right;">
                                @foreach ($data as $item)
                                    {{ $item->import }} {{$n}}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">A CUENTA:</td>
                            <td style="text-align: right;">
                                @foreach ($data as $item)
                                    {{ $item->on_account }} {{$n}}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">SALDO:</td>
                            <td style="text-align: right;">
                                @foreach ($data as $item)
                                    {{ $item->saldo }} {{$n}}
                                @endforeach
                            </td>
                        </tr>
                    </table>
                    <div style="font-size: 7pt">
                        TIPO SERV.:{{ $datos->type_service }}<br>
                        @php
                            $today = date('d-m-Y h:i:s', time());
                        @endphp
                        {{$today}}
                        {{-- 27/01/2022 06:25:15 pm --}} 
                    
                    </div>
                </td>

                <td style="width: 5px;"></td> {{-- espaciador entre columnas --}}

                <td style="width: 15.3cm; vertical-align: top; margin-left: 5px; margin-right:5px;">
                    <div>
                        <table>
                            <tr>
                                <td width="50%">
                                    <div class="col-sm-6 col-md-6" style="text-align: center">
                                        <div class="text-bold"
                                            style="font-size: 15px; margin-top: 0px; margin-bottom: 0px;">
                                            <b>ORDEN DE SERVICIO TÉCNICO<br>{{ $data[0]->order_service_id }}</b>
                                        </div>
                                        <!--<font size="2"><b>Nro.:  </b></font>-->
                                        <span style="font-size: 9px">
                                            @php
                                                $today = date('d-m-Y h:i:s', time());
                                            @endphp
                                            {{$today}}
                                        </span><br>
                                    </div>
                                </td>

                                <td width="50%">
                                    <div class="col-sm-6 col-md-6">
                                        <div style=" font-size: 10px; text-align: center;">
                                            <span class="text-bold"><u>SOLUCIONES INFORMÁTICAS EMANUEL ( S.I.E.
                                                    )</u></span><br>
                                            <span style="font-size: 8px">
                                                Sucursal: {{ $sucursal->name }}<br>
                                                {{$sucursal->adress}}<br>
                                                {{ $sucursal->telefono }} - {{ $sucursal->celular}}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </table>


                        {{-- <div style=" width: 20%; text-align: right">
                            <div style="padding-top: 45px; width: 100%"><b>TIPO SERV.: </b>Normal</div>
                        </div> --}}

                    </div>
                    <hr style="border-color: black; margin: 0px;">

                    <div style=" margin-left: 5px; margin-right:5px;">
                        <div style=" display: flex;">
                            <table>
                                <tr>
                                    <td style="width: 300px">
                                        <div style="width: auto;">
                                            <b>FECHA: </b>{{\Carbon\Carbon::now()->format('Y-m-d')}}&nbsp; - &nbsp;{{\Carbon\Carbon::now()->format('H:i:s')}}<br>
                                            <b>CODIGO: </b>MAA1191<br>
                                            <b>CLIENTE: </b>{{ $data[0]->nombreC }}
                                        </div>
                                    </td>

                                    <td style="width: 140px"></td>

                                    <td style="width: auto;">
                                        <div style="width: auto; display: flex;">
                                            <table id="derechatabla" style="font-weight: bold;">
                                                <tr>
                                                    <td style="text-align: right;">TOTAL:</td>
                                                    <td style="text-align: right;">
                                                        @foreach ($data as $item)
                                                        {{ $item->import }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;">A CUENTA:</td>
                                                    <td style="text-align: right;">
                                                        @foreach ($data as $item)
                                                            {{ $item->on_account }} 
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;">SALDO:</td>
                                                    <td style="text-align: right;">
                                                        @foreach ($data as $item)
                                                            {{ $item->saldo }} 
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr style="border-color: black; margin-top: 2px; margin-bottom: 2px">

                        <table>
                            <tr>
                                <td style="font-size: 10px; width: 10cm">
                                    <b>CANT.: </b>{{ $datos->services->count() }}<br>
                                    <b>DESCRIPCIÓN: </b>
                                    @php
                                        $x=0;
                                    @endphp
                                    @foreach ($datos->services as $item)
                                        @php
                                            if($x>0){
                                                $n='|';
                                            }else{
                                                $n=null;
                                            }
                                            $x++;
                                        @endphp
                                        {{$n}} {{ $item->categoria->nombre }} {{ $item->marca }} {{$n}}
                                    @endforeach<br>
                                    <b>FALLA SEGUN CLIENTE: </b>
                                    @foreach ($datos->services as $item)
                                        {{ $item->falla_segun_cliente }} {{$n}}
                                    @endforeach<br>
                                    <b>DIAGNOSTICO: </b>
                                    @foreach ($datos->services as $item)
                                        {{ $item->diagnostico }} {{$n}}
                                    @endforeach<br>
                                    <b>SOLUCION: </b>
                                    @foreach ($datos->services as $item)
                                        {{ $item->solucion }} {{$n}}
                                    @endforeach<br>
                                    <b>FECHA ENTREGA APROX.: </b>
                                    @foreach ($datos->services as $item)
                                        {{ $item->fecha_estimada_entrega }} {{$n}}
                                    @endforeach<br>
                                    <b>RESPONSABLE TÉCNICO: </b>{{ $usuario->name }}<br>
                                    <b>ESTADO: {{ $data[0]->type }}</b>
                                </td>

                            </tr>
                        </table>
                    </div>


                    <hr style="border-color: black;">
                    <div style="width: 100%; font-size: 10px">
                        <table>
                            <tr>
                                <td>
                                    <div class="" style="text-align: center">
                                        Administrador<br>
                                        DPTO. TECNICO
                                    </div>
                                </td>

                                <td style="width: 350px"></td>

                                <td>
                                    <div class="text-center">
                                        CLIENTE<br>
                                        {{ $data[0]->nombreC }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div style="display: flex; font-size: 9px; width: 100%">
                        <div style="text-align:center">
                            @php
                                $today = date('d-m-Y h:i:s', time());
                            @endphp
                            CCA: SIS.INF.SOLUCIONES INFORMÁTICAS EMANUEL ( S.I.E. ) | {{$today}}
                        </div>
                    </div>
                </td>
            </tr>
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
