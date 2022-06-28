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
                                <option value="0">Todos</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6>Perfiles / Cuentas</h6>
                        <div class="form-group">
                            <select wire:model="Perf_Cuenta" class="form-control">
                                <option value="0">Perfiles</option>
                                <option value="1">Cuentas</option>
                                <option value="2">Combos</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6>Vigentes / Vencidos</h6>
                        <div class="form-group">
                            <select wire:model="Vencid_Vigent" class="form-control">
                                <option value="0">Vigente</option>
                                <option value="1">Vencido</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6>Elige el tipo de Reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control">
                                <option value="0">Del Día</option>
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

                    {{-- <div class="col-sm-2 mt-4">
                        <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteStreaming/pdf' .'/' .$userId .'/' .$Perf_Cuenta .'/' .$Vencid_Vigent .'/' .$reportType .'/' .$dateFrom .'/' .$dateTo) }}">Generar
                            PDF</a>
                    </div> --}}

                </div>
                <div class="row">
                    @if ($Perf_Cuenta == 0)
                        <div class="table-responsive">
                            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                                <thead class="text-white" style="background: #ee761c">
                                    <tr>
                                        <th class="table-th text-withe text-center">Nº</th>
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
                                                <h6 class="text-center">{{ $loop->iteration }}</h6>
                                            </td>
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
                                                    {{ \Carbon\Carbon::parse($p->planinicio)->format('d/m/Y') }}
                                                </h6>
                                            </td>
                                            <td class="text-center">
                                                <h6 class="text-center">
                                                    {{ \Carbon\Carbon::parse($p->planfin)->format('d/m/Y') }} </h6>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif ($Perf_Cuenta == 1)
                        <div class="table-responsive">
                            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                                <thead class="text-white" style="background: #ee761c">
                                    <tr>
                                        <th class="table-th text-withe text-center">Nº</th>
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
                                                <h6 class="text-center">{{ $loop->iteration }}</h6>
                                            </td>
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
                                                    {{ \Carbon\Carbon::parse($p->planinicio)->format('d/m/Y') }}
                                                </h6>
                                            </td>
                                            <td class="text-center">
                                                <h6 class="text-center">
                                                    {{ \Carbon\Carbon::parse($p->planfin)->format('d/m/Y') }} </h6>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @elseif ($Perf_Cuenta == 2)
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                            <th class="table-th text-withe text-center">
                                                PLATAFORMAS</th>
                                            <th class="table-th text-withe text-center">CLIENTE
                                            </th>
                                            <th class="table-th text-withe text-center">EMAILS
                                            </th>
                                            <th class="table-th text-withe text-center">
                                                CONTRASEÑAS
                                                CUENTAS</th>
                                            <th class="table-th text-withe text-center">
                                                VENCIMIENTO
                                                CUENTAS</th>
                                            <th class="table-th text-withe text-center">PERFILES
                                            </th>
                                            <th class="table-th text-withe text-center">IMPORT
                                            </th>
                                            <th class="table-th text-withe text-center">PLAN
                                                INICIO</th>
                                            <th class="table-th text-withe text-center">PLAN FIN
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $p)
                                            <tr>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        @if ($Vencid_Vigent == 0)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'ACTIVO')
                                                                    {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                                @endif
                                                            @endforeach
                                                        @elseif($Vencid_Vigent == 1)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'VENCIDO')
                                                                    {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">{{ $p->Mov->climov->client->nombre }}
                                                        <br>
                                                        {{ $p->Mov->climov->client->celular }}
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        @if ($Vencid_Vigent == 0)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'ACTIVO')
                                                                    {{ $item->Cuenta->account_name }}
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @elseif($Vencid_Vigent == 1)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'VENCIDO')
                                                                    {{ $item->Cuenta->account_name }}
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        @if ($Vencid_Vigent == 0)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'ACTIVO')
                                                                    {{ $item->Cuenta->password_account }}
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @elseif($Vencid_Vigent == 1)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'VENCIDO')
                                                                    {{ $item->Cuenta->password_account }}
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        @if ($Vencid_Vigent == 0)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'ACTIVO')
                                                                    <h6>
                                                                        {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                                    </h6>
                                                                @endif
                                                            @endforeach
                                                        @elseif($Vencid_Vigent == 1)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'VENCIDO')
                                                                    <h6>
                                                                        {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                                    </h6>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        @if ($Vencid_Vigent == 0)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'ACTIVO')
                                                                    @foreach ($item->Cuenta->CuentaPerfiles as $acprof)
                                                                        @if ($acprof->status == 'ACTIVO' && $acprof->plan_id == $p->id)
                                                                            {{ $acprof->Perfil->nameprofile }} <br>
                                                                            {{ $acprof->Perfil->pin }}
                                                                        @endif
                                                                    @endforeach
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @elseif($Vencid_Vigent == 1)
                                                            @foreach ($p->PlanAccounts as $item)
                                                                @if ($item->status == 'VENCIDO')
                                                                    @foreach ($item->Cuenta->CuentaPerfiles as $acprof)
                                                                        @if ($acprof->status == 'VENCIDO' && $acprof->plan_id == $p->id)
                                                                            {{ $acprof->Perfil->nameprofile }} <br>
                                                                            {{ $acprof->Perfil->pin }}
                                                                        @endif
                                                                    @endforeach
                                                                    <br>
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        {{ $p->importe }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        {{ \Carbon\Carbon::parse($p->plan_start)->format('d/m/Y') }}
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6 class="text-center">
                                                        {{ \Carbon\Carbon::parse($p->expiration_plan)->format('d/m/Y') }}
                                                    </h6>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @include('livewire.reportes_streaming.str_details')
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
