<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading"> 
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige el usuario</h6>
                                <div class="form-group">
                                    <select wire:model="userId" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <h6>Elige el tipo de reporte</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Ganancias del día</option>
                                        <option value="1">Ganancias por fecha</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom" class="form-control" >
                                    {{-- <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom" class="form-control" placeholder="Click para elegir"> --}}
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2">
                                <h6>Fecha hasta</h6>
                                <div class="form-group">
                                    <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo" class="form-control">
                                    {{-- <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo" class="form-control" placeholder="Click para elegir"> --}}
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <button wire:click="$refresh" class="btn btn-warning btn-block">
                                    Consultar
                                </button>

                                <a class="btn btn-warning btn-block {{count($data) < 1 ? 'disabled' : ''}}" href="{{ url('reporteGananciaTigoM/pdf' . '/' . $userId . '/' . $reportType . '/' 
                                    . $dateFrom . '/' . $dateTo)}}">Generar PDF</a>

                                <a class="btn btn-warning btn-block {{count($data) < 1 ? 'disabled' : ''}}" href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' 
                                    . $dateFrom . '/' . $dateTo)}}" target="_blank">Exportar a Excel</a>

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">CEDULA</th>
                                        <th class="table-th text-withe text-center">IMPORTE</th>
                                        <th class="table-th text-withe text-center">ESTADO</th>
                                        <th class="table-th text-withe text-center">ORIGEN</th>
                                        <th class="table-th text-withe text-center">MOTIVO</th>
                                        <th class="table-th text-withe text-center">GANANCIA</th>
                                        
                                        <th class="table-th text-withe text-center">FECHA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) < 1) 
                                    <tr> <td colspan="9">
                                            <h5 class="text-center">Sin Resultados</h5>
                                        </td>
                                        </tr>
                                        @endif

                                        @foreach ($data as $d)
                                        <tr>
                                            <td class="text-center"><h6>{{$d->cedula}}</h6></td>
                                            <td class="text-center"><h6>{{number_format($d->importe,2)}}</h6></td>
                                            <td class="text-center"><h6>{{$d->estado}}</h6></td>
                                            <td class="text-center"><h6>{{$d->origen_nombre}}</h6></td>
                                            <td class="text-center"><h6>{{$d->motivo_nombre}}</h6></td>
                                            <td class="text-center"><h6>{{number_format($d->ganancia,2)}}</h6></td>
                                            
                                            <td class="text-center"><h6>{{$d->created_at}}</h6></td>
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

    })
</script>