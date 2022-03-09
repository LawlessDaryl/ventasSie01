<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading"> 
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige el tipo 'Perfiles' 'Cuentas'</h6>
                                <div class="form-group">
                                    <select wire:model="condicional" class="form-control">
                                        <option value="0">Perfiles</option>
                                        <option value="1">Cuentas</option>
                                    </select>
                                </div>
                            </div>

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
                                <h6>Elige el tipo de Reporte</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Transacciones del Día</option>
                                        <option value="1">Transacciones por Fecha</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    {{-- <input @if ($reportType == 0) disabled @endif type="text" wire:model="dateFrom" class="form-control flatpickr" placeholder="Click para elegir"> --}}
                                
                                    <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom" class="form-control">
                                    

                                </div>
                            </div>
                            
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha hasta</h6>
                                <div class="form-group">
                                    {{-- <input @if ($reportType == 0) disabled @endif type="text" wire:model="dateTo" class="form-control flatpickr" placeholder="Click para elegir"> --}}
                                
                                    <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo" class="form-control">
                                
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Consultar
                                </button>

                                {{-- <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : ''}} {{$dateFrom < 2000-01-01 ? 'disabled' : ''}} {{$dateTo < 2000-01-01 ? 'disabled' : ''}}" href="{{ url('reporteTigo/pdf' . '/' . $userId . '/' . $reportType . '/' 
                                    . $dateFrom . '/' . $dateTo)}}">Generar PDF</a>

                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : ''}}" href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' 
                                    . $dateFrom . '/' . $dateTo)}}" target="_blank">Exportar a Excel</a> --}}

                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : ''}}" href="{{ url('reporteTigo/pdf' . '/' . $userId . '/' . $reportType . '/' 
                                    . $dateFrom . '/' . $dateTo)}}">Generar PDF</a>

                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : ''}}" href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' 
                                    . $dateFrom . '/' . $dateTo)}}" target="_blank">Exportar a Excel</a>




                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-10">
                        <!-- TABLA -->
                        @if($condicional==0)
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">CELULAR</th>
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">VENCIMIENTO CUENTA</th>
                                    <th class="table-th text-withe text-center">NOMBRE PERFIL</th>
                                    <th class="table-th text-withe text-center">PIN</th>
                                    <th class="table-th text-withe text-center">IMPORTE</th>
                                    <th class="table-th text-withe text-center">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center">PLAN FIN</th>                                    
                                        <th class="table-th text-withe text-center" width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) < 1)
                                    <tr>
                                        <td colspan="9">
                                            <h5 class="text-center">Sin Resultados</h5>
                                        </td>
                                    </tr>
                                    @endif


                                    {{-- @if($dateFrom > 2000-01-01 && $dateTo > 2000-01-01) --}}
                                    
                                        @foreach ($data as $p)
                                            <tr>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->plataforma }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->cliente }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->celular }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->correo }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->password_account }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->accexp }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->nameprofile }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->pin }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->importe }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        {{ \Carbon\Carbon::parse($p->planinicio)->format('d:m:Y') }} </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        {{ \Carbon\Carbon::parse($p->planfin)->format('d:m:Y') }} </h6>
                                                </td>
                                                <td class="text-center" width="50px">
                                                    <button wire:click.prevent="getDetails({{$p->id}})" class="btn btn-dark btn-sm">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    {{-- @endif --}}



                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">CELULAR</th>
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">VENCIMIENTO CUENTA</th>
                                    <th class="table-th text-withe text-center">IMPORTE</th>
                                    <th class="table-th text-withe text-center">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center">PLAN FIN</th>                                                               
                                        <th class="table-th text-withe text-center" width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) < 1)
                                    <tr>
                                        <td colspan="9">
                                            <h5 class="text-center">Sin Resultados</h5>
                                        </td>
                                    </tr>
                                    @endif


                                    {{-- @if($dateFrom > 2000-01-01 && $dateTo > 2000-01-01) --}}
                                    
                                        @foreach ($data as $p)
                                            <tr>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->plataforma }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->cliente }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->celular }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->correo }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->password_account }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->accexp }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->importe }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        {{ \Carbon\Carbon::parse($p->planinicio)->format('d:m:Y') }} </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        {{ \Carbon\Carbon::parse($p->planfin)->format('d:m:Y') }} </h6>
                                                </td>
                                                <td class="text-center" width="50px">
                                                    <button wire:click.prevent="getDetails({{$p->id}})" class="btn btn-dark btn-sm">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    {{-- @endif --}}



                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- @include('livewire.reportes_tigo.sales-detail') --}}
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