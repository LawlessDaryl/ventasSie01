@if($datos->services->count()==1)
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
        .page-break {
            page-break-after: always;
        }

        body {
            font-family: 'Open Sans', sans-serif;
        }

    </style>

<body>

    @php
        $x = 0;
    @endphp
    @foreach ($datos->services as $key => $item2)
        {{-- @if (count($datos->services) != $key) --}}

    
        @php
            $x++;
        @endphp
        <section class="header" style="top: -290px; left:-30px">


            <table style=" font-size: 11px;">
                <tr>
                    {{-- Primera columna --}}
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
                            <b>CLIENTE: </b>{{ $data[0]->nombreC }}

                        </div>
                        <div style=" font-size: 7pt; line-height: 12px">
                            @if ($data[0]->telefono != 0)
                                <b>CELULAR: </b>{{ $data[0]->celular }} - {{ $data[0]->telefono }}<br>
                            @else
                                <b>CELULAR: </b>{{ $data[0]->celular }}<br>
                            @endif
                            <b>SERVICIO: </b>{{ $loop->iteration }}&nbsp;&nbsp;<br>

                            <b>DESCRIPCIÓN: </b>
                            @php
                                $x = 0;
                            @endphp
                            @foreach ($datos->services as $key2 => $item)
                                @if ($key2 == $key)
                                    {{-- {{$loop->iteration}} --}}
                                    @php
                                        if ($x > 0) {
                                            $n = '|';
                                        } else {
                                            $n = null;
                                        }
                                        $x++;
                                    @endphp
                                    {{ $n }} {{ $item->categoria->nombre }} {{ $item->marca }}
                                    {{ $item->detalle }}{{ $n }}
                                @endif
                            @endforeach
                            <br>
                            <b>FALLA: </b>
                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    {{ $item->falla_segun_cliente }} {{ $n }}
                                @endif
                            @endforeach
                            <br>
                            <b>DIAGNÓSTICO: </b>
                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    {{ $item->diagnostico }} {{ $n }}
                                @endif
                            @endforeach
                            <br>
                            <b>SOLUCIÓN: </b>
                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    {{ $item->solucion }} {{ $n }}
                                @endif
                            @endforeach
                            <br>
                            @php
                                $today = date('d-m-Y H:i', time());
                            @endphp
                            <b>F. RECEPCIÓN:
                            </b>{{ \Carbon\Carbon::parse($today)->format('d/m/Y - H:i') }}<br>

                            <b>F. ENTREGA: </b>

                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    {{ \Carbon\Carbon::parse($item->fecha_estimada_entrega)->format('d/m/Y - H:i') }}
                                    {{ $n }}
                                @endif
                            @endforeach
                            <br>
                            <div style="font-size: 7pt">
                                <b>TIPO SERV.: </b>{{ $datos->type_service }}<br>
                            </div>

                            <b>RESP. TÉCNICO: </b>
                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    @foreach ($item->movservices as $mm)
                                        @if ($mm->movs->status == 'ACTIVO')
                                            {{ $mm->movs->usermov->name }} {{ $n }}
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <!-- {{ $usuario->name }} --><br>
                        </div>
                        <hr
                            style="border-color: black; margin-top: 0px; margin-bottom: 1px; margin-left: 5px; margin-right:5px">
                        <table id="derechatabla" style="font-weight: bold; font-size: 7pt">
                            <tr>
                                <td style="text-align: right;">TOTALES:</td>
                                <td style="text-align: right;">
                                    @foreach ($data as $item)
                                        @if ($item->id == $item2->id)
                                            {{ $item->import }} {{ $n }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">A CUENTA:</td>
                                <td style="text-align: right;">
                                    @foreach ($data as $item)
                                        @if ($item->id == $item2->id)
                                            {{ $item->on_account }} {{ $n }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">SALDO:</td>
                                <td style="text-align: right;">
                                    @foreach ($data as $item)
                                        @if ($item->id == $item2->id)
                                            {{ $item->saldo }} {{ $n }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        </table>

                    </td>

                    <td style="width: 5px;"></td> {{-- espaciador entre columnas --}}
                    {{-- Aqui comienza la segunda columna --}}
                    <td style="width: 15.3cm; vertical-align: top; margin-left: 5px; margin-right:5px;">
                        <div>
                            <table>
                                <tr>
                                    <td width="50%">
                                        <div class="col-sm-6 col-md-6" style="text-align: center">
                                            <div class="text-bold"
                                                style="font-size: 15px; margin-top: 0px; margin-bottom: 0px;">
                                                <b>ORDEN DE SERVICIO
                                                    TÉCNICO<br>{{ $data[0]->order_service_id }}</b>
                                            </div>
                                            <!--<font size="2"><b>Nro.:  </b></font>-->
                                            <span style="font-size: 9px">
                                                @php
                                                    $today = date('d-m-Y H:i', time());
                                                @endphp
                                                {{ $today }}
                                            </span><br>
                                        </div>
                                    </td>

                                    <td width="50%">
                                        <div class="col-sm-6 col-md-6">
                                            <div style=" font-size: 10px; text-align: center;">
                                                <span class="text-bold"><u>SOLUCIONES INFORMÁTICAS EMANUEL (
                                                        S.I.E.
                                                        )</u></span><br>
                                                <span style="font-size: 8px">
                                                    Sucursal: {{ $sucursal->name }}<br>
                                                    {{ $sucursal->adress }}<br>
                                                    {{ $sucursal->telefono }} -
                                                    {{ $sucursal->celular }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- LOGO --}}
                                    {{-- <td width="30%" align="center" style="vertical-align: top; padding-top:10px; position:relative;">
                                        <img src="{{ asset('assets/img/Vertical.png') }}" alt="" class="invoice-logo">   
                                    </td> --}}

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
                                                <b>FECHA:
                                                </b>{{ \Carbon\Carbon::now()->format('Y-m-d') }}&nbsp; -
                                                &nbsp;{{ \Carbon\Carbon::now()->format('H:i') }}<br>

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
                                                                @if ($item->id == $item2->id)
                                                                    {{ $item->import }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right;">A CUENTA:</td>
                                                        <td style="text-align: right;">
                                                            @foreach ($data as $item)
                                                                @if ($item->id == $item2->id)
                                                                    {{ $item->on_account }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right;">SALDO:</td>
                                                        <td style="text-align: right;">
                                                            @foreach ($data as $item)
                                                                @if ($item->id == $item2->id)
                                                                    {{ $item->saldo }}
                                                                @endif
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
                                        <b>SERVICIO: </b>{{ $loop->iteration }}&nbsp;&nbsp;<br>
                                        <b>DESCRIPCIÓN: </b>
                                        @php
                                            $x = 0;
                                        @endphp
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                @php
                                                    if ($x > 0) {
                                                        $n = '|';
                                                    } else {
                                                        $n = null;
                                                    }
                                                    $x++;
                                                @endphp
                                                {{ $n }} {{ $item->categoria->nombre }}
                                                {{ $item->marca }} {{ $item->detalle }} {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>FALLA SEGUN CLIENTE: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                {{ $item->falla_segun_cliente }} {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>DIAGNÓSTICO: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                {{ $item->diagnostico }} {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>SOLUCIÓN: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                {{ $item->solucion }} {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>FECHA ENTREGA APROX.: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                {{ \Carbon\Carbon::parse($item->fecha_estimada_entrega)->format('d/m/Y - H:i') }}
                                                {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>RESPONSABLE TÉCNICO: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                @foreach ($item->movservices as $mm)
                                                    @if ($mm->movs->status == 'ACTIVO')
                                                        {{ $mm->movs->usermov->name }} {{ $n }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        <!-- {{ $usuario->name }} --><br>
                                        <b>ESTADO: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                @foreach ($item->movservices as $mm)
                                                    @if ($mm->movs->status == 'ACTIVO')
                                                        {{ $mm->movs->type }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
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
                                            <b>RESPONSABLE TÉCNICO </b><br>
                                            @foreach ($datos->services as $item)
                                                @if ($item->id == $item2->id)
                                                    @foreach ($item->movservices as $mm)
                                                        @if ($mm->movs->status == 'ACTIVO')
                                                            {{ $mm->movs->usermov->name }} {{ $n }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            <!-- {{ $usuario->name }} -->
                                        </div>
                                    </td>

                                    <td style="width: 350px"></td>

                                    <td>
                                        <div class="text-center">
                                            <b>CLIENTE</b><br>
                                            {{ $data[0]->nombreC }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div style="display: flex; font-size: 9px; width: 100%">
                            <div style="text-align:center">
                                @php
                                    $today = date('d-m-Y H:i', time());
                                @endphp
                                CCA: SIS.INF.SOLUCIONES INFORMÁTICAS EMANUEL ( S.I.E. ) | {{ $today }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>


        </section>
        </div>

        {{-- @endif --}}
    @endforeach




</body>

</html>


@endif




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
        .page-break {
            page-break-after: always;
        }

        body {
            font-family: 'Open Sans', sans-serif;
        }

    </style>

<body>

    @php
        $x = 0;
    @endphp
    @foreach ($datos->services as $key => $item2)
        {{-- @if (count($datos->services) != $key) --}}

        @if ($x == $key - 1)
            <div>
            @else
                <div class="page-break">
        @endif
        @php
            $x++;
        @endphp
        <section class="header" style="top: -290px; left:-30px">


            <table style=" font-size: 11px;">
                <tr>
                    {{-- Primera columna --}}
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
                            <b>CLIENTE: </b>{{ $data[0]->nombreC }}

                        </div>
                        <div style=" font-size: 7pt; line-height: 12px">
                            @if ($data[0]->telefono != 0)
                                <b>CELULAR: </b>{{ $data[0]->celular }} - {{ $data[0]->telefono }}<br>
                            @else
                                <b>CELULAR: </b>{{ $data[0]->celular }}<br>
                            @endif
                            <b>SERVICIO: </b>{{ $loop->iteration }}&nbsp;&nbsp;<br>

                            <b>DESCRIPCIÓN: </b>
                            @php
                                $x = 0;
                            @endphp
                            @foreach ($datos->services as $key2 => $item)
                                @if ($key2 == $key)
                                    {{-- {{$loop->iteration}} --}}
                                    @php
                                        if ($x > 0) {
                                            $n = '|';
                                        } else {
                                            $n = null;
                                        }
                                        $x++;
                                    @endphp
                                    {{ $n }} {{ $item->categoria->nombre }} {{ $item->marca }}
                                    {{ $item->detalle }}{{ $n }}
                                @endif
                            @endforeach
                            <br>
                            <b>FALLA: </b>
                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    {{ $item->falla_segun_cliente }} {{ $n }}
                                @endif
                            @endforeach
                            <br>
                            <b>DIAGNÓSTICO: </b>
                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    {{ $item->diagnostico }} {{ $n }}
                                @endif
                            @endforeach
                            <br>
                            <b>SOLUCIÓN: </b>
                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    {{ $item->solucion }} {{ $n }}
                                @endif
                            @endforeach
                            <br>
                            @php
                                $today = date('d-m-Y H:i', time());
                            @endphp
                            <b>F. RECEPCIÓN:
                            </b>{{ \Carbon\Carbon::parse($today)->format('d/m/Y - H:i') }}<br>

                            <b>F. ENTREGA: </b>

                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    {{ \Carbon\Carbon::parse($item->fecha_estimada_entrega)->format('d/m/Y - H:i') }}
                                    {{ $n }}
                                @endif
                            @endforeach
                            <br>
                            <div style="font-size: 7pt">
                                <b>TIPO SERV.: </b>{{ $datos->type_service }}<br>
                            </div>

                            <b>RESP. TÉCNICO: </b>
                            @foreach ($datos->services as $item)
                                @if ($item->id == $item2->id)
                                    @foreach ($item->movservices as $mm)
                                        @if ($mm->movs->status == 'ACTIVO')
                                            {{ $mm->movs->usermov->name }} {{ $n }}
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <!-- {{ $usuario->name }} --><br>
                        </div>
                        <hr
                            style="border-color: black; margin-top: 0px; margin-bottom: 1px; margin-left: 5px; margin-right:5px">
                        <table id="derechatabla" style="font-weight: bold; font-size: 7pt">
                            <tr>
                                <td style="text-align: right;">TOTALES:</td>
                                <td style="text-align: right;">
                                    @foreach ($data as $item)
                                        @if ($item->id == $item2->id)
                                            {{ $item->import }} {{ $n }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">A CUENTA:</td>
                                <td style="text-align: right;">
                                    @foreach ($data as $item)
                                        @if ($item->id == $item2->id)
                                            {{ $item->on_account }} {{ $n }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">SALDO:</td>
                                <td style="text-align: right;">
                                    @foreach ($data as $item)
                                        @if ($item->id == $item2->id)
                                            {{ $item->saldo }} {{ $n }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        </table>

                    </td>

                    <td style="width: 5px;"></td> {{-- espaciador entre columnas --}}
                    {{-- Aqui comienza la segunda columna --}}
                    <td style="width: 15.3cm; vertical-align: top; margin-left: 5px; margin-right:5px;">
                        <div>
                            <table>
                                <tr>
                                    <td width="50%">
                                        <div class="col-sm-6 col-md-6" style="text-align: center">
                                            <div class="text-bold"
                                                style="font-size: 15px; margin-top: 0px; margin-bottom: 0px;">
                                                <b>ORDEN DE SERVICIO
                                                    TÉCNICO<br>{{ $data[0]->order_service_id }}</b>
                                            </div>
                                            <!--<font size="2"><b>Nro.:  </b></font>-->
                                            <span style="font-size: 9px">
                                                @php
                                                    $today = date('d-m-Y H:i', time());
                                                @endphp
                                                {{ $today }}
                                            </span><br>
                                        </div>
                                    </td>

                                    <td width="50%">
                                        <div class="col-sm-6 col-md-6">
                                            <div style=" font-size: 10px; text-align: center;">
                                                <span class="text-bold"><u>SOLUCIONES INFORMÁTICAS EMANUEL (
                                                        S.I.E.
                                                        )</u></span><br>
                                                <span style="font-size: 8px">
                                                    Sucursal: {{ $sucursal->name }}<br>
                                                    {{ $sucursal->adress }}<br>
                                                    {{ $sucursal->telefono }} -
                                                    {{ $sucursal->celular }}</span>
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
                                                <b>FECHA:
                                                </b>{{ \Carbon\Carbon::now()->format('Y-m-d') }}&nbsp; -
                                                &nbsp;{{ \Carbon\Carbon::now()->format('H:i') }}<br>

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
                                                                @if ($item->id == $item2->id)
                                                                    {{ $item->import }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right;">A CUENTA:</td>
                                                        <td style="text-align: right;">
                                                            @foreach ($data as $item)
                                                                @if ($item->id == $item2->id)
                                                                    {{ $item->on_account }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right;">SALDO:</td>
                                                        <td style="text-align: right;">
                                                            @foreach ($data as $item)
                                                                @if ($item->id == $item2->id)
                                                                    {{ $item->saldo }}
                                                                @endif
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
                                        <b>SERVICIO: </b>{{ $loop->iteration }}&nbsp;&nbsp;<br>
                                        <b>DESCRIPCIÓN: </b>
                                        @php
                                            $x = 0;
                                        @endphp
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                @php
                                                    if ($x > 0) {
                                                        $n = '|';
                                                    } else {
                                                        $n = null;
                                                    }
                                                    $x++;
                                                @endphp
                                                {{ $n }} {{ $item->categoria->nombre }}
                                                {{ $item->marca }} {{ $item->detalle }} {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>FALLA SEGUN CLIENTE: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                {{ $item->falla_segun_cliente }} {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>DIAGNÓSTICO: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                {{ $item->diagnostico }} {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>SOLUCIÓN: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                {{ $item->solucion }} {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>FECHA ENTREGA APROX.: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                {{ \Carbon\Carbon::parse($item->fecha_estimada_entrega)->format('d/m/Y - H:i') }}
                                                {{ $n }}
                                            @endif
                                        @endforeach
                                        <br>
                                        <b>RESPONSABLE TÉCNICO: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                @foreach ($item->movservices as $mm)
                                                    @if ($mm->movs->status == 'ACTIVO')
                                                        {{ $mm->movs->usermov->name }} {{ $n }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        <!-- {{ $usuario->name }} --><br>
                                        <b>ESTADO: </b>
                                        @foreach ($datos->services as $item)
                                            @if ($item->id == $item2->id)
                                                @foreach ($item->movservices as $mm)
                                                    @if ($mm->movs->status == 'ACTIVO')
                                                        {{ $mm->movs->type }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
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
                                            <b>RESPONSABLE TÉCNICO </b><br>
                                            @foreach ($datos->services as $item)
                                                @if ($item->id == $item2->id)
                                                    @foreach ($item->movservices as $mm)
                                                        @if ($mm->movs->status == 'ACTIVO')
                                                            {{ $mm->movs->usermov->name }} {{ $n }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            <!-- {{ $usuario->name }} -->
                                        </div>
                                    </td>

                                    <td style="width: 350px"></td>

                                    <td>
                                        <div class="text-center">
                                            <b>CLIENTE</b><br>
                                            {{ $data[0]->nombreC }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div style="display: flex; font-size: 9px; width: 100%">
                            <div style="text-align:center">
                                @php
                                    $today = date('d-m-Y H:i', time());
                                @endphp
                                CCA: SIS.INF.SOLUCIONES INFORMÁTICAS EMANUEL ( S.I.E. ) | {{ $today }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>


        </section>
        </div>

        {{-- @endif --}}
    @endforeach




</body>

</html>
