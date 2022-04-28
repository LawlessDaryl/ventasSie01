<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{ $componentName }}</b></h4>
            </div>

            <div class="widget-content">


                <div class="row">
                    
                    <div class="col-sm-3">
                        <h6>Elige el tipo de reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control">
                                <option value="0">Transacciones del día</option>
                                <option value="1">Transacciones por fecha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <h6>Elige la caja</h6>
                        <div class="form-group">
                            <select wire:model="caja" class="form-control" style="font-size: 90%">
                                <option value="Todos">Todos</option>
                                @foreach ($cajas as $cajSu)
                                    <option value="{{ $cajSu->id }}">{{ $cajSu->nombre }}</option>
                                @endforeach
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
                        
                        {{-- <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteServicEntreg/pdf' . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo . '/' . $sucursal . '/' . $sumaEfectivo . '/' . $sumaBanco . '/' . $caja) }}"
                            target="_blank" style='font-size:18px'>Generar PDF</a> --}}
                        
                        <a class="btn btn-dark"
                            href="{{ url('reporteServicEntreg/pdf' . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo . '/' . $sucursal . '/' . $sumaEfectivo . '/' . $sumaBanco . '/' . $caja) }}"
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
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">FECHA</th>
                                        <th class="table-th text-withe text-center">CLIENTE</th>
                                        <th class="table-th text-withe text-center">ORDEN</th>
                                       
                                        
                                        <th class="table-th text-withe text-center">DETALLE</th>
                                        <th class="table-th text-withe text-center">COSTO</th>
                                        <th class="table-th text-withe text-center">IMPORTE</th>
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
                                                <h6 class="table-th text-withe text-center" style="font-size: 100%">{{ $loop->iteration }}</h6>
                                            </td>
                                            {{-- FECHA --}}
                                            @foreach($d->movservices as $movser)
                                                @if($movser->movs->type=='ENTREGADO' && $movser->movs->status == 'ACTIVO')
                                                    <td class="text-center">
                                                        <h6>{{ \Carbon\Carbon::parse($movser->movs->created_at)->format('d/m/Y') }}</h6>
                                                    </td>
                                                @endif
                                            @endforeach
                                            {{-- CLIENTE --}}
                                            <td class="text-center">
                                                <h6>{{ $d->movservices[0]->movs->climov->client->nombre }}</h6>
                                            </td>
                                            {{-- NÚMERO DE ORDEN --}}
                                            <td class="text-center">
                                                <h6>{{ $d->order_service_id }}</h6>
                                            </td>
                                            
                                            {{-- DETALLE --}}
                                            <td class="text-center">
                                                <h6>{{ $d->categoria->nombre }} {{ $d->marca }} {{ $d->detalle }}</h6>
                                            </td>
                                            {{-- COSTO --}}
                                            <td class="text-center">
                                                <h6>{{ number_format($d->costo, 2) }}</h6>
                                            </td>
                                            {{-- IMPORTE --}}
                                            <td class="text-center">
                                                <h6>{{ number_format($d->movservices[0]->movs->import, 2) }}</h6>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($caja != 'Todos')
                                        @if(count($movbancarios) > 1)
                                        <tr>
                                            <td colspan="9">
                                                <h5 class="text-center">Servicios entregados y pagados por banco</h5>
                                            </td>
                                        </tr>
                                        @endif
                                    @foreach ($movbancarios as $d)
                                        <tr>
                                            {{-- # --}}
                                            <td width="2%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 100%">{{ $loop->iteration+$contador }}</h6>
                                            </td>
                                            {{-- FECHA --}}
                                            {{-- @foreach($d->movservices as $movser) --}}
                                                {{-- @if($d->type=='ENTREGADO' && $d->status == 'ACTIVO') --}}
                                                    <td class="text-center">
                                                        <h6>{{ \Carbon\Carbon::parse($d->creacion_Mov)->format('d/m/Y') }}</h6>
                                                    </td>
                                                {{-- @endif --}}
                                            {{-- @endforeach --}}
                                            {{-- CLIENTE --}}
                                            <td class="text-center">
                                                <h6>{{ $d->nomCli }}</h6>
                                            </td>
                                            {{-- NÚMERO DE ORDEN --}}
                                            <td class="text-center">
                                                <h6>{{ $d->orderId }}</h6>
                                            </td>
                                            
                                            {{-- DETALLE --}}
                                            <td class="text-center">
                                                <h6>{{ $d->nomCat }} {{ $d->marca }} {{ $d->detalle }}</h6>
                                            </td>
                                            {{-- COSTO --}}
                                            <td class="text-center">
                                                <h6>{{ number_format($d->costo, 2) }}</h6>
                                            </td>
                                            {{-- IMPORTE --}}
                                            <td class="text-center">
                                                <h6>{{ number_format($d->import, 2) }}</h6>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    
                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <span><b>EFECTIVO</b></span>
                                        </td>
                                        <td class="text-right" colspan="5">
                                            <span>
                                                
                                                {{$sumaEfectivo}}

                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <span><b>TRANSFERENCIA BANCARIA /T.DEBITO</b></span>
                                        </td>
                                        <td class="text-right" colspan="5">
                                            <span>
                                                
                                                {{$sumaBanco}}

                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <span><b>TOTALES</b></span>
                                        </td>
                                        <td class="text-right" colspan="4">
                                            <span><strong>
                                                @if($caja != 'Todos')
                                                    ${{$sumaCosto + $sumaCostoEfectivo}}
                                                @else
                                                    ${{ number_format($data->sum('costo'), 2) }}
                                                @endif
                                                
                    
                                                </strong></span>
                                        </td>
                                        <td class="text-right" colspan="0">
                                            <span><strong>
                                                    @php
                                                        $mytotal = 0;                                     
                                                    @endphp
                                                    @foreach ($data as $d)
                                                        @foreach ($d->movservices as $mv)
                                                            @if ($mv->movs->status == 'ACTIVO')
                                                                @php
                                                                $mytotal = $sumaBanco + $sumaEfectivo;
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
