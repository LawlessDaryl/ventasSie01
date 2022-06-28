<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b> Reporte ganancias streaming</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">

                    {{-- <div class="col-sm-2">
                        <h6>INGRESOS / EGRESOS</h6>
                        <div class="form-group">
                            <select wire:model="tipoIE" class="form-control">
                                <option value="TODOS">TODOS</option>
                                <option value="INGRESO">INGRESO</option>
                                <option value="EGRESO">EGRESO</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="col-sm-2">
                        <h6>TIPO DE PLAN</h6>
                        <div class="form-group">
                            <select wire:model="tipoPlan" class="form-control">
                                <option value="TODOS">TODOS</option>
                                <option value="PERFIL">PERFILES</option>
                                <option value="ENTERA">CUENTAS</option>
                                <option value="COMBO">COMBOS</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6>TIPO TRANSACCIÓN</h6>
                        <div class="form-group">
                            <select wire:model="tipoTr" class="form-control">
                                <option value="TODOS">TODOS</option>
                                <option value="COMPRA">COMPRA</option>
                                <option value="VENTA">VENTA</option>
                                <option value="RENOVACION">RENOVACION</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6>Elige el tipo de Reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control">
                                <option value="0">Todo el tiempo</option>
                                <option value="1">Por Fecha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6>Fecha desde</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6>Fecha hasta</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                class="form-control">
                        </div>
                    </div>
                    @if ($tipoPlan == 'TODOS' && $tipoTr == 'TODOS')
                        <div class="col-sm-2 mt-2">
                            <h6>Total egresos: {{ $totalEgresos }} bs.</h6>
                            <h6>Total ingresos: {{ $totalIngresos }} bs.</h6>
                            <h6>Ganancia: {{ $ganancia }} bs.</h6>
                        </div>
                    @else
                        <div class="col-sm-2 mt-2">
                            <h6>Suma de los elementos: {{ $totalCantidad }} bs.</h6>
                        </div>
                    @endif

                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-hover mt-1">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CUENTA</th>                                    
                                    <th class="table-th text-withe text-center">TIPO</th>
                                    <th class="table-th text-withe text-center">CANTIDAD</th>
                                    <th class="table-th text-withe text-center">TIPO DE PLAN</th>
                                    <th class="table-th text-withe text-center">TIPO DE TRANSACCION</th>
                                    <th class="table-th text-withe text-center">NÚMERO DE MESES</th>
                                    <th class="table-th text-withe text-center">FECHA REALIZACION</th>
                                    
                                    <th class="table-th text-withe text-center" width="50px"></th>
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

                                @foreach ($data as $p)
                                    <tr>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ $p->nombre }}
                                            </h6>
                                        </td>
                                        
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ $p->account_name }}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->tipo }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->cantidad }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->tipoPlan }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->tipoTransac }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->num_meses }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->fecha_realizacion)->format('d/m/Y') }}
                                            </h6>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item', msg => {
            noty(msg)
        });

        //eventos
        window.livewire.on('show-modal', msg => {
            $('#modalDetails').modal('show')
        });
    })
</script>
