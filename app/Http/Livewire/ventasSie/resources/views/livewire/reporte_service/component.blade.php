<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center" style="font-size: 110%"><b>{{ $componentName }}</b></h4>
            </div>

            <div class="widget-content">


                <div class="row">
                    <div class="col-sm-2">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Elige el usuario</h6>
                        <div class="form-group">
                            <select wire:model="userId" class="form-control" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                <option value="">Todos</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Elige el estado</h6>
                        <div class="form-group">
                            <select wire:model="estado" class="form-control" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                <option value="Todos">Todos</option>
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="PROCESO">Proceso</option>
                                <option value="TERMINADO">Terminado</option>
                                <option value="ENTREGADO">Entregado</option>
                                <option value="ABANDONADO">Abandonado</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Elige la sucursal</h6>
                        <div class="form-group">
                            <select wire:model="sucursal" class="form-control" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                <option value="0">Todos</option>
                                @foreach ($sucursales as $suc)
                                    <option value="{{ $suc->id }}">{{ $suc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-1.6">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Elige el tipo de reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                <option value="0">Servicios del día</option>
                                <option value="1">Servicios por fecha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-1.2 ml-3">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Fecha desde</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom"
                                class="form-control" placeholder="Click para elegir" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                        </div>
                    </div>

                    <div class="col-sm-1.2 ml-3">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Fecha hasta</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                class="form-control" placeholder="Click para elegir" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                        </div>
                    </div>

                    <div class="col-sm-2 mt-3">

                        <a class="btn btn-warning btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteServicio/pdf' . '/' . $userId . '/' . $estado . '/' . $sucursal . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                            target="_blank" style='font-size:15px'>Generar PDF</a>

                    </div>

                </div>

                <div class="row">
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
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <!-- TABLA -->
                        <div class="table-responsive">
                            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                                <thead class="text-white" style="background: #ee761c">
                                    <tr>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">#</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">CLIENTE</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">ORDEN</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">FECHA HORA
                                            REC.</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">FECHA HORA
                                            TERM.</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">FECHA HORA
                                            ENTR.</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">COSTO</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">IMPORTE</th>
                                        {{-- <th class="table-th text-withe text-center" style="font-size: 90%">A CUENTA</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">SALDO</th>

                                        <th class="table-th text-withe text-center" style="font-size: 90%">TIPO SERVICIO</th> --}}
                                        <th class="table-th text-withe text-center" style="font-size: 90%">UTILIDAD</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">DETALLE</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">ESTADO</th>
                                        <th class="table-th text-withe text-center" style="font-size: 90%">TEC. RESP.
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
                                        <tr>
                                            {{-- # --}}
                                            <td width="2%">
                                                <h6 class="text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ $loop->iteration }}</h6>
                                            </td>
                                            {{-- CLIENTE --}}
                                            <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ $d->movservices[0]->movs->climov->client->nombre }}</h6>
                                            </td>
                                            {{-- NÚMERO ORDEN --}}
                                            <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $d->order_service_id }}</h6>
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
                                            <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ number_format($d->costo, 2) }}</h6>
                                            </td>
                                            {{-- TOTAL --}}
                                            <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ number_format($d->movservices[0]->movs->import, 2) }}</h6>
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
                                            <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ number_format($d->utilidad, 2) }}</h6>
                                            </td>

                                            {{-- DETALLE --}}
                                            <td class="text-center">
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $d->marca }}
                                                    {{ $d->categoria->nombre }} {{ $d->detalle }}</h6>
                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Falla:</b> {{ $d->falla_segun_cliente }}</h6>

                                            </td>
                                            {{-- ESTADO Y TECNICO RESPONSABLE --}}
                                            @foreach ($d->movservices as $mv)
                                                @if ($mv->movs->type == 'PENDIENTE' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6 class="badge bg-danger text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                            {{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $mv->movs->usermov->name }}
                                                        </h6>
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'PROCESO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6 class="badge bg-secondary text-center"
                                                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $mv->movs->usermov->name }}
                                                        </h6>
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'TERMINADO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6 class="badge bg-warning text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                            {{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $mv->movs->usermov->name }}
                                                        </h6>
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'ENTREGADO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6 class="badge bg-success text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                            {{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                            {{ $d->movservices[2]->movs->usermov->name }}</h6>
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
                                    <tr>
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
