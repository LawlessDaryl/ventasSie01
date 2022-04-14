<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{ $componentName }}</b></h4>
            </div>

            <div class="widget-content">


                <div class="row">
                    <div class="col-sm-2">
                        <h6>Elige el usuario</h6>
                        <div class="form-group">
                            <select wire:model="userId" class="form-control">
                                <option value="">Todos</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6>Elige el estado</h6>
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

                    <div class="col-sm-2">
                        <h6>Elige el tipo de reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control">
                                <option value="0">Transacciones del día</option>
                                <option value="1">Transacciones por fecha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2 ">
                        <h6>Fecha desde</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom"
                                class="form-control" placeholder="Click para elegir">
                        </div>
                    </div>

                    <div class="col-sm-2 ">
                        <h6>Fecha hasta</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                class="form-control" placeholder="Click para elegir">
                        </div>
                    </div>

                    <div class="col-sm-2 mt-4">

                        <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteServicio/pdf' . '/' . $userId . '/' . $estado . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                            target="_blank" style='font-size:18px'>Generar PDF</a>

                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <!-- TABLA -->
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">CLIENTE</th>
                                        <th class="table-th text-withe text-center">ORDEN</th>
                                        <th class="table-th text-withe text-center">FECHA HORA RECEP.</th>
                                        <th class="table-th text-withe text-center">FECHA HORA TERM.</th>
                                        <th class="table-th text-withe text-center">FECHA HORA ENTR.</th>
                                        <th class="table-th text-withe text-center">COSTO</th>
                                        <th class="table-th text-withe text-center">UTILIDAD</th>
                                        <th class="table-th text-withe text-center">A CUENTA</th>
                                        <th class="table-th text-withe text-center">SALDO</th>

                                        <th class="table-th text-withe text-center">TIPO SERVICIO</th>
                                        <th class="table-th text-withe text-center">DETALLE</th>
                                        <th class="table-th text-withe text-center">ESTADO</th>
                                        <th class="table-th text-withe text-center">TEC. RESP.</th>

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
                                            {{-- CLIENTE --}}
                                            <td class="text-center">
                                                <h6>{{ $d->movservices[0]->movs->climov->client->nombre }}</h6>
                                            </td>
                                            {{-- NÚMERO ORDEN --}}
                                            <td class="text-center">
                                                <h6>{{ $d->order_service_id }}</h6>
                                            </td>
                                            @foreach ($d->movservices as $mv)
                                                @if ($mv->movs->type == 'PENDIENTE')
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->created_at }}</h6>
                                                    </td>
                                                    @if ($mv->movs->status == 'ACTIVO')
                                                        <td class="text-center">
                                                            <h6>Pendiente</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6>Pendiente</h6>
                                                        </td>
                                                    @endif
                                                @endif
                                                @if ($mv->movs->type == 'PROCESO')
                                                    @if ($mv->movs->status == 'ACTIVO')
                                                        <td class="text-center">
                                                            <h6>Proceso</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6>Proceso</h6>
                                                        </td>
                                                    @endif
                                                @endif
                                                @if ($mv->movs->type == 'TERMINADO')
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->created_at }}</h6>
                                                    </td>
                                                    @if ($mv->movs->status == 'ACTIVO')
                                                        <td class="text-center">
                                                            <h6>Terminado</h6>
                                                        </td>
                                                    @endif
                                                @endif

                                                @if ($mv->movs->type == 'ENTREGADO')
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->created_at }}</h6>
                                                    </td>
                                                @elseif ($mv->movs->type == 'ABANDONADO')
                                                    <td class="text-center">
                                                        <h6>Abandonado</h6>
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
                                            <td class="text-center">
                                                <h6>{{ number_format($d->costo, 2) }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ number_format($d->movservices[0]->movs->import, 2) }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ number_format($d->movservices[0]->movs->on_account, 2) }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ number_format($d->movservices[0]->movs->saldo, 2) }}</h6>
                                            </td>

                                            <td class="text-center">
                                                <h6>{{ $d->OrderServicio->type_service }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->marca }} {{ $d->categoria->nombre }}</h6>
                                            </td>
                                            @foreach ($d->movservices as $mv)
                                                @if ($mv->movs->type == 'PENDIENTE' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->usermov->name }}</h6>
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'PROCESO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->usermov->name }}</h6>
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'TERMINADO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->usermov->name }}</h6>
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'ENTREGADO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $d->movservices[2]->movs->usermov->name }}</h6>
                                                    </td>
                                                @endif
                                                @if ($mv->movs->type == 'ABANDONADO' && $mv->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->type }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $mv->movs->usermov->name }}</h6>
                                                    </td>
                                                @endif
                                            @endforeach


                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <span><b>TOTALES</b></span>
                                        </td>
                                        <td class="text-right" colspan="4">
                                            <span><strong>
                                                    
                                                ${{ number_format($data->sum('costo'), 2) }}
                    
                                                </strong></span>
                                        </td>
                                        <td class="text-right" colspan="1">
                                            <span><strong>
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
                                                    ${{ number_format($mytotal, 2) }}
                    
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
    @include('livewire.reportes_tigo.sales-detail')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofweek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            }
        })

        //eventos
        window.livewire.on('show-modal', msg => {
            $('#modalDetails').modal('show')
            noty(msg)
        });
        
    })
</script>
