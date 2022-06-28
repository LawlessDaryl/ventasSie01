<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" wire:click="CrearCombo()"
                        data-target="#theModal">Vender Combo</a>
                </ul>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" wire:click="Agregar()" data-target="#theModal">+
                        Nueva</a>
                </ul>
            </div>
            @include('common.searchbox')
            <div>

                <h6 class="card-title">
                    <b>SALDO DE TUS CARTERAS:</b> <br>
                    @foreach ($carterasCaja as $item)
                        <b>{{ $item->nombre }}: </b><b>{{ $item->monto }} Bs.</b>
                        <br>
                    @endforeach
                </h6>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="custom-radio-4"
                                            id="perfiles" value="perfiles" wire:model="condicional" checked>
                                        <span class="new-control-indicator"></span>PERFILES
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="custom-radio-4" id="cuentas"
                                            value="cuentas" wire:model="condicional">
                                        <span class="new-control-indicator"></span>CUENTAS
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="custom-radio-4" id="combos"
                                            value="combos" wire:model="condicional">
                                        <span class="new-control-indicator"></span>COMBOS
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($condicional == 'perfiles')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                                <tr>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">CLIENTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">EMAIL</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">CONTRASEÑA CUENTA
                                    </th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">VENCIMIENTO
                                        CUENTA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PERFIL</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">IMPORTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLAN FIN</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">ACCIONES</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">REALIZADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($planes as $p)
                                    <tr
                                        style="{{ $p->estado == 'ANULADO' ? 'background-color: #d97171 !important' : '' }}">
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->plataforma }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->cliente }} {{ $p->celular }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->correo }} {{ $p->passCorreo }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->password_account }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->accexp)->format('d/m/Y') }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->nameprofile }} {{ $p->pin }}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->importe }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->planinicio)->format('d/m/Y') }} </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->planfin)->format('d/m/Y') }} </h6>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)"
                                                wire:click="VerObservacionesPerfil('{{ $p->planid }}','{{ $p->IDperfil }}','{{ $p->clienteID }}')"
                                                class="btn btn-dark mtmobile" title="Observaciones">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </a>
                                            @if ($p->estado != 'ANULADO')
                                                <a href="javascript:void(0)"
                                                    onclick="ConfirmAnularPerfil('{{ $p->planid }}','{{ $p->IDplanAccount }}','{{ $p->IDaccount }}','{{ $p->IDaccountProfile }}','{{ $p->IDperfil }}')"
                                                    class="btn btn-dark mtmobile" title="Anular">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center"
                                            style="{{ $p->ready == 'NO' ? 'background-color: #d97171 !important' : 'background-color: #09ed3d !important' }}">
                                            @if ($p->ready == 'NO')
                                                <a href="javascript:void(0)" class="btn btn-dark"
                                                    onclick="ConfirmHecho('{{ $p->planid }}')">
                                                    <i class="fa-regular fa-circle-exclamation"></i>
                                                </a>
                                            @else
                                                <h6 class="text-center"><strong>Hecho</strong></h6>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $planes->links() }}
                    </div>
                </div>
            @elseif($condicional == 'cuentas')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-striped mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">EMAIL O NOMBRE-CUENTA</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">VENCIMIENTO CUENTA</th>
                                    <th class="table-th text-withe text-center">IMPORTE</th>
                                    <th class="table-th text-withe text-center">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center">PLAN FIN</th>
                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                    <th class="table-th text-withe text-center">REALIZADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($planes as $p)
                                    <tr
                                        style="{{ $p->estado == 'ANULADO' ? 'background-color: #d97171 !important' : '' }}">
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->plataforma }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->cliente }} {{ $p->celular }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->account_name }} {{ $p->passCorreo }}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->password_account }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->accexp)->format('d/m/Y') }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->importe }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->planinicio)->format('d/m/Y') }} </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->planfin)->format('d/m/Y') }} </h6>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)"
                                                wire:click="VerObservacionesCuenta('{{ $p->planid }}','{{ $p->clienteID }}')"
                                                class="btn btn-dark mtmobile" title="Observaciones">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </a>
                                            @if ($p->estado != 'ANULADO')
                                                <a href="javascript:void(0)"
                                                    onclick="ConfirmAnularEntera('{{ $p->planid }}','{{ $p->IDplanAccount }}','{{ $p->IDaccount }}')"
                                                    class="btn btn-dark mtmobile" title="Anular">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center"
                                            style="{{ $p->ready == 'NO' ? 'background-color: #d97171 !important' : 'background-color: #09ed3d !important' }}">
                                            @if ($p->ready == 'NO')
                                                <a href="javascript:void(0)" class="btn btn-dark"
                                                    onclick="ConfirmHecho('{{ $p->planid }}')">
                                                    <i class="fa-regular fa-circle-exclamation"></i>
                                                </a>
                                            @else
                                                <h6 class="text-center"><strong>Hecho</strong></h6>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $planes->links() }}
                    </div>
                </div>
            @else
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-hover mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLATAFORMAS</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">CLIENTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">EMAILS</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">CONTRASEÑAS
                                        CUENTAS</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">VENCIMIENTO
                                        CUENTAS</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PERFILES</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">IMPORTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLAN FIN</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">ACCIONES</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">REALIZADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($planes as $p)
                                    <tr
                                        style="{{ $p->status == 'ANULADO' ? 'background-color: #d97171 !important' : '' }}">
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                @if ($p->status == 'VIGENTE')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL1')
                                                            {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                            @php
                                                                $plataforma1 = $item->Cuenta->Plataforma->id;
                                                            @endphp
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL2')
                                                            {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                            @php
                                                                $plataforma2 = $item->Cuenta->Plataforma->id;
                                                            @endphp
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL3')
                                                            {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                            @php
                                                                $plataforma3 = $item->Cuenta->Plataforma->id;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @elseif($p->status == 'ANULADO')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL1')
                                                            {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                            @php
                                                                $plataforma1 = $item->Cuenta->Plataforma->id;
                                                            @endphp
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL2')
                                                            {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                            @php
                                                                $plataforma2 = $item->Cuenta->Plataforma->id;
                                                            @endphp
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL3')
                                                            {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                            @php
                                                                $plataforma3 = $item->Cuenta->Plataforma->id;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->Mov->climov->client->nombre }} <br>
                                                {{ $p->Mov->climov->client->celular }}</h6>
                                            @php
                                                $IDcliente = $p->Mov->climov->client->id;
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                @if ($p->status == 'VIGENTE')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL1')
                                                            {{ $item->Cuenta->account_name }} <br>
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL2')
                                                            {{ $item->Cuenta->account_name }} <br>
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL3')
                                                            {{ $item->Cuenta->account_name }} <br>
                                                        @endif
                                                    @endforeach
                                                @elseif($p->status == 'ANULADO')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL1')
                                                            {{ $item->Cuenta->account_name }} <br>
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL2')
                                                            {{ $item->Cuenta->account_name }} <br>
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL3')
                                                            {{ $item->Cuenta->account_name }} <br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                @if ($p->status == 'VIGENTE')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL1')
                                                            {{ $item->Cuenta->password_account }} <br>
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL2')
                                                            {{ $item->Cuenta->password_account }} <br>
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL3')
                                                            {{ $item->Cuenta->password_account }} <br>
                                                        @endif
                                                    @endforeach
                                                @elseif($p->status == 'ANULADO')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL1')
                                                            {{ $item->Cuenta->password_account }} <br>
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL2')
                                                            {{ $item->Cuenta->password_account }} <br>
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL3')
                                                            {{ $item->Cuenta->password_account }} <br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                @if ($p->status == 'VIGENTE')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL1')
                                                            @php
                                                                $planAccount1 = $item->id;
                                                                $Account1 = $item->Cuenta->id;
                                                            @endphp
                                                            {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                            <br>
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL2')
                                                            @php
                                                                $planAccount2 = $item->id;
                                                                $Account2 = $item->Cuenta->id;
                                                            @endphp
                                                            {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                            <br>
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL3')
                                                            @php
                                                                $planAccount3 = $item->id;
                                                                $Account3 = $item->Cuenta->id;
                                                            @endphp
                                                            {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @elseif($p->status == 'ANULADO')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL1')
                                                            @php
                                                                $planAccount1 = $item->id;
                                                                $Account1 = $item->Cuenta->id;
                                                            @endphp
                                                            {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                            <br>
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL2')
                                                            @php
                                                                $planAccount2 = $item->id;
                                                                $Account2 = $item->Cuenta->id;
                                                            @endphp
                                                            {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                            <br>
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL3')
                                                            @php
                                                                $planAccount3 = $item->id;
                                                                $Account3 = $item->Cuenta->id;
                                                            @endphp
                                                            {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                @if ($p->status == 'VIGENTE')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL1')
                                                            @foreach ($item->Cuenta->CuentaPerfiles as $acprof)
                                                                @if ($acprof->status == 'ACTIVO' && $acprof->COMBO == 'PERFIL1' && $acprof->plan_id == $p->id)
                                                                    {{ $acprof->Perfil->nameprofile }} <br>
                                                                    {{ $acprof->Perfil->pin }}
                                                                    @php
                                                                        $accountProfile1 = $acprof->id;
                                                                        $perfil1 = $acprof->Perfil->id;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            <br>
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL2')
                                                            @foreach ($item->Cuenta->CuentaPerfiles as $acprof)
                                                                @if ($acprof->status == 'ACTIVO' && $acprof->COMBO == 'PERFIL2' && $acprof->plan_id == $p->id)
                                                                    {{ $acprof->Perfil->nameprofile }} <br>
                                                                    {{ $acprof->Perfil->pin }}
                                                                    @php
                                                                        $accountProfile2 = $acprof->id;
                                                                        $perfil2 = $acprof->Perfil->id;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            <br>
                                                        @elseif ($item->status == 'ACTIVO' && $item->COMBO == 'PERFIL3')
                                                            @foreach ($item->Cuenta->CuentaPerfiles as $acprof)
                                                                @if ($acprof->status == 'ACTIVO' && $acprof->COMBO == 'PERFIL3' && $acprof->plan_id == $p->id)
                                                                    {{ $acprof->Perfil->nameprofile }} <br>
                                                                    {{ $acprof->Perfil->pin }}
                                                                    @php
                                                                        $accountProfile3 = $acprof->id;
                                                                        $perfil3 = $acprof->Perfil->id;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @elseif($p->status == 'ANULADO')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL1')
                                                            @foreach ($item->Cuenta->CuentaPerfiles as $acprof)
                                                                @if ($acprof->status == 'ANULADO' && $acprof->COMBO == 'PERFIL1' && $acprof->plan_id == $p->id)
                                                                    {{ $acprof->Perfil->nameprofile }} <br>
                                                                    {{ $acprof->Perfil->pin }}
                                                                    @php
                                                                        $accountProfile1 = $acprof->id;
                                                                        $perfil1 = $acprof->Perfil->id;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            <br>
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL2')
                                                            @foreach ($item->Cuenta->CuentaPerfiles as $acprof)
                                                                @if ($acprof->status == 'ANULADO' && $acprof->COMBO == 'PERFIL2' && $acprof->plan_id == $p->id)
                                                                    {{ $acprof->Perfil->nameprofile }} <br>
                                                                    {{ $acprof->Perfil->pin }}
                                                                    @php
                                                                        $accountProfile2 = $acprof->id;
                                                                        $perfil2 = $acprof->Perfil->id;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            <br>
                                                        @elseif ($item->status == 'ANULADO' && $item->COMBO == 'PERFIL3')
                                                            @foreach ($item->Cuenta->CuentaPerfiles as $acprof)
                                                                @if ($acprof->status == 'ANULADO' && $acprof->COMBO == 'PERFIL3' && $acprof->plan_id == $p->id)
                                                                    {{ $acprof->Perfil->nameprofile }} <br>
                                                                    {{ $acprof->Perfil->pin }}
                                                                    @php
                                                                        $accountProfile3 = $acprof->id;
                                                                        $perfil3 = $acprof->Perfil->id;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->importe }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->plan_start)->format('d/m/Y') }} </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->expiration_plan)->format('d/m/Y') }}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)"
                                                wire:click="VerObservacionesCombo('{{ $p->id }}','{{ $IDcliente }}','{{ $perfil1 }}','{{ $perfil2 }}','{{ $perfil3 }}','{{ $plataforma1 }}','{{ $plataforma2 }}','{{ $plataforma3 }}')"
                                                class="btn btn-dark mtmobile" title="Observaciones">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </a>
                                            @if ($p->status != 'ANULADO')
                                                <a href="javascript:void(0)"
                                                    onclick="ConfirmAnularCombo('{{ $p->id }}','{{ $planAccount1 }}','{{ $planAccount2 }}','{{ $planAccount3 }}','{{ $Account1 }}','{{ $Account2 }}','{{ $Account3 }}','{{ $accountProfile1 }}','{{ $accountProfile2 }}','{{ $accountProfile3 }}','{{ $perfil1 }}','{{ $perfil2 }}','{{ $perfil3 }}')"
                                                    class="btn btn-dark mtmobile" title="Anular">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center"
                                            style="{{ $p->ready == 'NO' ? 'background-color: #d97171 !important' : 'background-color: #09ed3d !important' }}">
                                            @if ($p->ready == 'NO')
                                                <a href="javascript:void(0)" class="btn btn-dark"
                                                    onclick="ConfirmHecho('{{ $p->id }}')">
                                                    <i class="fa-regular fa-circle-exclamation"></i>
                                                </a>
                                            @else
                                                <h6 class="text-center"><strong>Hecho</strong></h6>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $planes->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('livewire.planes.form')
    @include('livewire.planes.modalObservaciones')
    @include('livewire.planes.modalPerfil')
    @include('livewire.planes.modalCombos')

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('item-anulado', Msg => {
            noty(Msg)
        })
        window.livewire.on('item-error', Msg => {
            noty(Msg)
        })

        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })

        window.livewire.on('item-actualizado', Msg => {
            $('#Modal_Observaciones').modal('hide')
            noty(Msg)
        })
        window.livewire.on('show-modal3', Msg => {
            $('#Modal_Observaciones').modal('show')
        })

        window.livewire.on('show-modalPerf', Msg => {
            $('#Modal_perfil').modal('show')
        })
        window.livewire.on('perf-actualizado', Msg => {
            $('#Modal_perfil').modal('hide')
            noty(Msg)
        })

        window.livewire.on('show-modalCombos', Msg => {
            $('#Modal_combos').modal('show')
        })
        window.livewire.on('hide-modalCombos', Msg => {
            $('#Modal_combos').modal('hide')
            noty(Msg)
        })

    });

    function ConfirmHecho(id) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Ya realizó las acciones correspondientes y desea ponerlo en realizado?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('Realizado', id)
                swal.fire(
                    'Se cambió a realizado'
                )
            }
        })
    }

    function ConfirmAnularPerfil(plan, planAccount, account, accountProfile, Profile) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente desea Anular esta transacción?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('AnularPerfil', plan, planAccount, account, accountProfile, Profile)
                Swal.close()
            }
        })
    }

    function ConfirmAnularEntera(plan, planAccount, account) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente desea Anular esta transacción?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('AnularEntera', plan, planAccount, account)
                Swal.close()
            }
        })
    }

    function ConfirmAnularCombo(plan, planAccount1, planAccount2, planAccount3, account1, account2, account3,
        accountProfile1, accountProfile2, accountProfile3, Profile1, Profile2, Profile3) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente desea Anular esta transacción?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('AnularCombo', plan, planAccount1, planAccount2, planAccount3, account1,
                    account2, account3,
                    accountProfile1, accountProfile2, accountProfile3, Profile1, Profile2, Profile3)
                Swal.close()
            }
        })
    }
</script>
