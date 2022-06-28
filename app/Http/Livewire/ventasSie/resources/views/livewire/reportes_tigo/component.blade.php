<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{ $componentName }}</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
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

                    <div class="col-sm-12 col-md-3">
                        <h6>Elige el tipo de Reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control">
                                <option value="0">Transacciones del Día</option>
                                <option value="1">Transacciones por Fecha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Origen</h6>
                            <select wire:model="origenfiltro" class="form-control">
                                <option value="0" selected>Todas</option>
                                <option value="Sistema">Sistema</option>
                                <option value="Telefono">Telefono</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Tipo de transacción</h6>
                            <select wire:model="tipotr" class="form-control">
                                <option value="0" selected>Todas</option>
                                <option value="Retiro">Retiro</option>
                                <option value="Abono">Abono</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <h6>Fecha desde</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <h6>Fecha hasta</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mt-4">
                        <a class=" btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteTigo/pdf' . '/' . $userId . '/' . $reportType . '/' . $origenfiltro . '/' . $tipotr . '/' . $dateFrom . '/' . $dateTo) }}">
                            Generar
                            PDF</a>
                    </div>


                    <div class="col-sm-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                                <thead class="text-white" style="background: #ee761c">
                                    <tr>
                                        <th class="table-th text-withe text-center">CEDULA</th>
                                        <th class="table-th text-withe text-center">TELEFONO</th>
                                        <th class="table-th text-withe text-center">DESTINO</th>
                                        <th class="table-th text-withe text-center">IMPORTE</th>
                                        <th class="table-th text-withe text-center">ESTADO</th>

                                        <th class="table-th text-withe text-center">ORIGEN</th>

                                        <th class="table-th text-withe text-center">MOTIVO</th>
                                        @can('Origen_Mot_Com_Index')
                                            <th class="table-th text-withe text-center">GANANCIA</th>
                                        @endcan
                                        <th class="table-th text-withe text-center">FECHA</th>
                                        <th class="table-th text-withe text-center" width="50px"></th>
                                        <th class="table-th text-withe text-center">Editar</th>
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
                                        <tr
                                            style="{{ $d->estado == 'Anulada' ? 'background-color: #d97171 !important' : '' }}">
                                            <td class="text-center" style="height: 5px;">
                                                <h6>{{ $d->cedula }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->telefono }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->codigo_transf }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ number_format($d->importe, 2) }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->estado }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->origen_nombre }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->motivo_nombre }}</h6>
                                            </td>
                                            @can('Origen_Mot_Com_Index')
                                                <td class="text-center">
                                                    <h6>{{ number_format($d->ganancia) }}</h6>
                                                </td>
                                            @endcan
                                            <td class="text-center">
                                                <h6>
                                                    {{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i') }}
                                                </h6>
                                            </td>
                                            <td class="text-center" width="50px">
                                                <button wire:click.prevent="getDetails({{ $d->id }})"
                                                    class="btn btn-dark btn-sm" title="Ver observaciones">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-align-center">
                                                        <line x1="18" y1="10" x2="6" y2="10"></line>
                                                        <line x1="21" y1="6" x2="3" y2="6"></line>
                                                        <line x1="21" y1="14" x2="3" y2="14"></line>
                                                        <line x1="18" y1="18" x2="6" y2="18"></line>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('livewire.reportes_tigo.sales-detail')
    @include('livewire.reportes_tigo.modaleditartransaccion')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('item', msg => {
            noty(msg)
        });
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
        });
    })
</script>
