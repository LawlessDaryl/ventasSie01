@section('css')
<style>
    .tablaservicios {
        width: 100%;
        min-width: 1100px;
        min-height: 140px;
    }
    .tablaservicios thead {
        background-color: #1572e8;
        color: white;
    }
    .tablaservicios th, td {
        border: 0.5px solid #1571e894;
        padding-top: 3px;
        padding-bottom: 3px;
        padding-left: 3px;
        padding-right: 4px;
    }
    .tablaserviciostr:hover {
        background-color: rgba(0, 195, 255, 0.336);
    }
    .detalleservicios{
        border: 1px solid #1572e8;
        border-radius: 10px;
        background-color: #ffffff00;
        /* border-top: 4px; */
        padding: 5px;
    }

    
    /*Estilos para el Boton Pendiente en la Tabla*/
    .pendienteestilos {
        text-decoration: none !important; 
        background-color: rgb(161, 0, 224);
        color: white;
        border-color: rgb(161, 0, 224);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(161, 0, 224);
        display: inline-block;
    }

    /*Estilos para el Boton Proceso en la Tabla*/
    .procesoestilos {
        text-decoration: none !important; 
        background-color: rgb(100, 100, 100);
        color: white; 
        border-color: rgb(100, 100, 100);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 12px;
        padding-right: 12px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(100, 100, 100);
        display: inline-block;
    }

    /*Estilos para el Boton Terminado en la Tabla*/
    .terminadoestilos {
        text-decoration: none !important; 
        background-color: rgb(224, 146, 0);
        color: white;
        border-color: rgb(224, 146, 0);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(224, 146, 0);
        display: inline-block;
    }

    /*Estilos para el Boton Entregado en la Tabla*/
    .entregadoestilos {
        text-decoration: none !important; 
        background-color: rgb(22, 192, 0);
        color: white !important; 
        cursor: default;
        border:none;
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(22, 192, 0);
        display: inline-block;
    }


    /* Estilos para la Tabla - Ventana Modal Asignar Técnico  Responsable*/
    .table-wrapper {
        width: 100%;/* Anchura de ejemplo */
        height: 350px; /* Altura de ejemplo */
        overflow: auto;
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
    }
        














    #preloader_3{
    position:relative;
}
#preloader_3:before{
    width:20px;
    height:20px;
    border-radius:20px;
    background:blue;
    content:'';
    position:absolute;
    background:#9b59b6;
    animation: preloader_3_before 1.5s infinite ease-in-out;
}
 
#preloader_3:after{
    width:20px;
    height:20px;
    border-radius:20px;
    background:blue;
    content:'';
    position:absolute;
    background:#2ecc71;
    left:22px;
    animation: preloader_3_after 1.5s infinite ease-in-out;
}
 
@keyframes preloader_3_before {
    0% {transform: translateX(0px) rotate(0deg)}
    50% {transform: translateX(50px) scale(1.2) rotate(260deg); background:#2ecc71;border-radius:0px;}
      100% {transform: translateX(0px) rotate(0deg)}
}
@keyframes preloader_3_after {
    0% {transform: translateX(0px)}
    50% {transform: translateX(-50px) scale(1.2) rotate(-260deg);background:#9b59b6;border-radius:0px;}
    100% {transform: translateX(0px)}
}





    

</style>
@endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center" style="font-size: 110%"><b>{{ $componentName }}</b></h4>
            </div>

            <div class="widget-content">


                <div class="row">
                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <h6>Elige Usuario</h6>
                        <div class="form-group">
                            <select wire:model="userId" class="form-control">
                                <option value="">Todos</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <h6>Elige Estado</h6>
                        <div class="form-group">
                            <select wire:model="estado" class="form-control">
                                <option value="Todos">Todos</option>
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="PROCESO">Proceso</option>
                                <option value="TERMINADO">Terminado</option>
                                <option value="ENTREGADO">Entregado</option>
                                <option value="ABANDONADO">Abandonado</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <h6>Sucursal</h6>
                        <div class="form-group">
                            <select wire:model="sucursal" class="form-control">
                                <option value="0">Todos</option>
                                @foreach ($sucursales as $suc)
                                    <option value="{{ $suc->id }}">{{ $suc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <h6>Tipo de Reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control">
                                <option value="0">Servicios del día</option>
                                <option value="1">Servicios por fecha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-1 text-center">
                        <h6>Fecha Desde</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom"
                                class="form-control" placeholder="Click para elegir">
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-1 text-center">
                        <h6>Fecha Hasta</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                class="form-control" placeholder="Click para elegir">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <a class="btn btn-primary {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteServicio/pdf' . '/' . $userId . '/' . $estado . '/' . $sucursal . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                            target="_blank" style='font-size:15px'>Generar PDF</a>
                    </div>

                </div>

                {{-- <div class="row">
                    <div class="col-12 col-sm-6 col-md-10 text-center"></div>
                    <div class="col-12 col-sm-6 col-md-2 text-center">
                        <a class="btn btn-primary {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteServicio/pdf' . '/' . $userId . '/' . $estado . '/' . $sucursal . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                            target="_blank" style='font-size:15px'>Generar PDF</a>
                    </div>
                </div> --}}

                {{-- <div class="row">
                    <div class="col-lg-3">
                        <label>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">TÉCNICO: {{ $tecnico }}</h6>
                        </label><br />
                    </div>
                    <div class="col-lg-3">
                        <label>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">ESTADO: {{ $estadovista }}</h6>
                        </label><br />
                    </div>
                    <div class="col-lg-3">
                        <label>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">FECHA DESDE:
                                {{ \Carbon\Carbon::parse($fechadesde)->format('d/m/Y') }}</h6>
                        </label><br />
                    </div>
                    <div class="col-lg-3">
                        <label>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">FECHA HASTA:
                                {{ \Carbon\Carbon::parse($fechahasta)->format('d/m/Y') }}</h6>
                        </label><br />
                    </div>
                </div> --}}
                <center><div id="preloader_3" wire:loading></div></center>
                <br>

                <div class="">
                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="tablaservicios">
                                <thead>
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">CODIGO</th>
                                        <th class="table-th text-withe text-center">CLIENTE</th>
                                        <th class="table-th text-withe text-center">FECHA HORA
                                            REC.</th>
                                        <th class="table-th text-withe text-center">FECHA HORA
                                            TERM.</th>
                                        <th class="table-th text-withe text-center">FECHA HORA
                                            ENTR.</th>
                                        <th class="table-th text-withe text-center">COSTO</th>
                                        <th class="table-th text-withe text-center">IMPORTE</th>
                                        {{-- <th class="table-th text-withe text-center" style="font-size: 90%">A CUENTA</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">SALDO</th>

                                        <th class="table-th text-withe text-center" style="font-size: 90%">TIPO SERVICIO</th> --}}
                                        <th class="table-th text-withe text-center">UTILIDAD</th>
                                        <th class="table-th text-withe text-center">DETALLE</th>
                                        <th class="table-th text-withe text-center">ESTADO</th>
                                        <th class="table-th text-withe text-center">TEC. RESP.
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) < 1)
                                        <tr>
                                            <td colspan="9">
                                                <h5 class="text-center">Sin Resultados</h5>
                                            </td>
                                        </tr>
                                    @endif

                                    @foreach ($data as $d)
                                        <tr class="tablaserviciostr">
                                            {{-- # --}}
                                            <td width="2%">
                                                <h6 class="text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ $loop->iteration }}</h6>
                                            </td>
                                            {{-- NÚMERO ORDEN --}}
                                            <td class="text-center">
                                                <span class="stamp stamp" style="background-color: #1572e8">
                                                    {{$d->order_service_id}}
                                                </span>
                                            </td>
                                            {{-- CLIENTE --}}
                                            <td>
                                                {{ ucwords(strtolower($d->movservices[0]->movs->climov->client->nombre)) }}
                                            </td>
                                            {{-- FECHA --}}
                                            @foreach ($d->movservices as $mv)
                                                @if ($mv->movs->type == 'PENDIENTE')
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                            {{ \Carbon\Carbon::parse($mv->movs->created_at)->format('d/m/Y') }}
                                                        </h6>
                                                    </td>
                                                    @if ($mv->movs->status == 'ACTIVO')
                                                        <td class="text-center">
                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Pendiente</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Pendiente</h6>
                                                        </td>
                                                    @endif
                                                @endif
                                                @if ($mv->movs->type == 'PROCESO')
                                                    @if ($mv->movs->status == 'ACTIVO')
                                                        <td class="text-center">
                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Proceso</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Proceso</h6>
                                                        </td>
                                                    @endif
                                                @endif
                                                @if ($mv->movs->type == 'TERMINADO')
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                            {{ \Carbon\Carbon::parse($mv->movs->created_at)->format('d/m/Y') }}
                                                        </h6>
                                                    </td>
                                                    @if ($mv->movs->status == 'ACTIVO')
                                                        <td class="text-center">
                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Terminado</h6>
                                                        </td>
                                                    @endif
                                                @endif

                                                @if ($mv->movs->type == 'ENTREGADO')
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                            {{ \Carbon\Carbon::parse($mv->movs->created_at)->format('d/m/Y') }}
                                                        </h6>
                                                    </td>
                                                @elseif ($mv->movs->type == 'ABANDONADO')
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Abandonado</h6>
                                                    </td>
                                                @endif

                                                {{-- @if ($mv->movs->type == 'ABANDONADO')
                                                    @if ($mv->movs->status == 'ACTIVO')
                                                        <td class="text-center">
                                                            <h6>Abandonado</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6>Abandonado</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6>Abandonado</h6>
                                                        </td>
                                                    @endif
                                                @endif --}}
                                            @endforeach
                                            {{-- COSTO --}}
                                            <td class="text-right">
                                                {{ number_format($d->costo, 2) }}
                                            </td>
                                            {{-- TOTAL --}}
                                            <td class="text-right">
                                                    @if($d->movservices[0]->movs->status == 'ACTIVO')
                                                    {{ number_format($d->movservices[0]->movs->import, 2) }}
                                                    @else
                                                        @if($d->movservices[1]->movs->status == 'ACTIVO')
                                                        {{ number_format($d->movservices[1]->movs->import, 2) }}
                                                        @else
                                                            @if($d->movservices[2]->movs->status == 'ACTIVO')
                                                            {{ number_format($d->movservices[2]->movs->import, 2) }}
                                                            @else
                                                                @if($d->movservices[3]->movs->status == 'ACTIVO')
                                                                {{ number_format($d->movservices[3]->movs->import, 2) }}
                                                                @else
                                                                {{ number_format($d->movservices[3]->movs->import, 2) }}a
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                            </td>
                                            {{-- A CUENTA --}}
                                            {{-- <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ number_format($d->movservices[0]->movs->on_account, 2) }}</h6>
                                            </td> --}}
                                            {{-- SALDO --}}
                                            {{-- <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ number_format($d->movservices[0]->movs->saldo, 2) }}</h6>
                                            </td> --}}
                                            {{-- TIPO SERVICIO --}}
                                            {{-- <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $d->OrderServicio->type_service }}</h6>
                                            </td> --}}

                                            {{-- UTILIDAD --}}
                                            <td class="text-right">
                                                {{ number_format($d->utilidad, 2) }}
                                            </td>

                                            {{-- DETALLE --}}
                                            <td class="text-center">
                                                  {{ ucwords(strtolower($d->marca)) }}
                                                    {{ ucwords(strtolower($d->categoria->nombre)) }} {{ ucwords(strtolower($d->detalle)) }}
                                                <b>Falla:</b> {{ ucwords(strtolower($d->falla_segun_cliente)) }}</h6>

                                            </td>
                                            {{-- ESTADO Y TECNICO RESPONSABLE --}}
                                            @foreach ($d->movservices as $mv)
                                                @if ($mv->movs->type == 'PENDIENTE' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <div class="pendienteestilos">
                                                            {{ $mv->movs->type }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ ucwords(strtolower($mv->movs->usermov->name)) }}
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'PROCESO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <div class="procesoestilos">
                                                            {{ $mv->movs->type }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ ucwords(strtolower($mv->movs->usermov->name)) }}
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'TERMINADO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <div class="terminadoestilos">
                                                            {{ $mv->movs->type }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ ucwords(strtolower($mv->movs->usermov->name)) }}
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'ENTREGADO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <div class="entregadoestilos">
                                                            {{ $mv->movs->type }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ ucwords(strtolower($d->movservices[2]->movs->usermov->name)) }}
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'ABANDONADO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $mv->movs->usermov->name }}
                                                        </h6>
                                                    </td>
                                                @endif
                                            @endforeach


                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="tablaserviciostr">
                                        <td colspan="2" class="text-left">
                                            <span style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>TOTALES</b></span>
                                        </td>
                                        <td class="text-right" colspan="5">
                                            <span style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><strong>
                                                    @if (($estado == 'ENTREGADO' && $userId != 0) || ($estado == 'Todos' && $userId != 0))
                                                        {{ $costoEntregado }}
                                                    @else
                                                        {{ number_format($data->sum('costo'), 2) }}
                                                    @endif
                                                </strong></span>
                                        </td>
                                        <td class="text-right" colspan="1">
                                            <span style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><strong>
                                                    @php
                                                        $mytotal = 0;
                                                    @endphp
                                                    @foreach ($data as $d)
                                                        @foreach ($d->movservices as $mv)
                                                            @if ($mv->movs->status == 'ACTIVO')
                                                                @php
                                                                    $mytotal += $mv->movs->import;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                    {{ number_format($mytotal, 2) }}

                                                </strong></span>
                                        </td>
                                        <td class="text-right" colspan="0">
                                            <span style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><strong>
                                                    {{ number_format($sumaUtilidad, 2) }}
                                                </strong></span>
                                        </td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        //eventos
        window.livewire.on('show-modal', msg => {
            $('#modalDetails').modal('show')
            noty(msg)
        });

    })
</script>
