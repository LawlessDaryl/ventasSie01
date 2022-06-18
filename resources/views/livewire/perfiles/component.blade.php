<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-gp">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                    </div>
                </div>
                @if ($condicional == 'ocupados' || $condicional == 'vencidos')
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <h6 class="form-control"><strong> PLATAFORMA: </strong></h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <select wire:model="PlataformaFiltro" class="form-control">
                                <option value="TODAS">TODAS</option>
                                @foreach ($plataformas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                        value="ocupados" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>PLANES PERFILES OCUPADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="vencidos"
                                        value="vencidos" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>PLANES PERFILES VENCIDOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="combos"
                                        value="combos" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>COMBOS VIGENTES DE PERFILES </h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="combos"
                                        value="combosVencidos" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>COMBO VENCIDOS DE PERFILES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($condicional == 'ocupados' || $condicional == 'vencidos')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">GMAIL</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">PERFIL</th>
                                    <th class="table-th text-withe text-center">EXPIRACION CUENTA</th>
                                    <th class="table-th text-withe text-center">INICIO PLAN</th>
                                    <th class="table-th text-withe text-center">EXPIRACION PLAN</th>
                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                    <th class="table-th text-withe text-center">REALIZADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profiles as $p)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{ $p->nombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center"><strong> N: </strong>{{ $p->clienteNombre }}
                                                <strong>TELF: </strong> {{ $p->clienteCelular }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->content }} <br> {{ $p->pass }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->passAccount }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center"><strong> N: </strong>{{ $p->namep }}
                                                <strong>PIN: </strong>{{ $p->pin }}
                                            </h6>
                                        </td>
                                        <td @if ($condicional == 'ocupados') @if ($p->horasCuenta > 72)
                                            style="background-color: #09ed3d !important"
                                            @elseif($p->horasCuenta >= 0 && $p->horasCuenta <= 72)
                                            style="background-color: #f1dc08 !important"
                                            @else
                                            style="background-color: #FF0000 !important" @endif
                                            @endif>
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->expiration)->format('d/m/Y') }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->plan_start)->format('d/m/Y') }}
                                            </h6>
                                        </td>
                                        <td @if ($condicional == 'ocupados') @if ($p->horasPlan > 72)
                                            style="background-color: #09ed3d !important"
                                            @elseif($p->horasPlan >= 0 && $p->horasPlan <= 72)
                                            style="background-color: #f1dc08 !important"
                                            @else
                                            style="background-color: #FF0000 !important" @endif
                                            @endif>
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->expiration_plan)->format('d/m/Y') }}
                                            </h6>
                                        </td>

                                        <td class="text-center">
                                            @if ($p->estadoCuentaPerfil == 'ACTIVO')
                                                <a href="javascript:void(0)"
                                                    wire:click="Acciones('{{ $p->IDperfil }}','{{ $p->IDaccountProfile }}','{{ $p->IDaccount }}','{{ $p->IDplanAccount }}','{{ $p->planid }}','{{ $p->clienteID }}','{{ $p->IDplatf }}')"
                                                    class="btn btn-dark mtmobile" title="Renovación">
                                                    <i class="fa-regular fa-calendar-check"></i>
                                                </a>
                                            @endif
                                            <a href="javascript:void(0)"
                                                wire:click="EditObservaciones('{{ $p->planid }}','{{ $p->IDperfil }}','{{ $p->clienteID }}')"
                                                class="btn btn-dark mtmobile" title="Observaciones">
                                                <i class="fa-solid fa-align-left"></i>
                                            </a>
                                        </td>

                                        <td
                                            style="{{ $p->done == 'NO' ? 'background-color: #d97171 !important' : 'background-color: #09ed3d !important' }}">
                                            @if ($p->done == 'NO')
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
                        {{ $profiles->links() }}
                    </div>
                </div>
            @else
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                                <tr>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLATAFORMAS</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">CLIENTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">EMAILS</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">CONTRASEÑAS
                                        CUENTAS</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">VENCIMIENTO
                                        CUENTAS</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PERFILES</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">IMPORT</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">PLAN FIN</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">ACCIONES</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">REALIZADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profiles as $p)
                                    <tr>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                @if ($condicional == 'combos')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO')
                                                            {{ $item->Cuenta->Plataforma->nombre }} <br>
                                                        @endif
                                                    @endforeach
                                                @elseif($condicional == 'combosVencidos')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'VENCIDO')
                                                            {{ $item->Cuenta->Plataforma->nombre }} <br>
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
                                                @if ($condicional == 'combos')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO')
                                                            {{ $item->Cuenta->account_name }}
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @elseif($condicional == 'combosVencidos')
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
                                                @if ($condicional == 'combos')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO')
                                                            {{ $item->Cuenta->password_account }}
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @elseif($condicional == 'combosVencidos')
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
                                                @if ($condicional == 'combos')
                                                    @foreach ($p->PlanAccounts as $item)
                                                        @if ($item->status == 'ACTIVO')
                                                            @php
                                                                $date1 = new DateTime($item->Cuenta->expiration_account);
                                                                $date2 = new DateTime('now');
                                                                $diff = $date2->diff($date1);
                                                                if ($diff->invert != 1) {
                                                                    $horasCuenta = $diff->days * 24 + $diff->h;
                                                                } else {
                                                                    $horasCuenta = '-1';
                                                                }
                                                            @endphp
                                                            <h6
                                                                @if ($horasCuenta > 120) style="background-color: #09ed3d !important"
                                                            @elseif($horasCuenta >= 0 && $horasCuenta <= 120)
                                                            style="background-color: #f1dc08 !important"
                                                            @else
                                                            style="background-color: #FF0000 !important" @endif>
                                                                {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                            </h6>
                                                        @endif
                                                    @endforeach
                                                @elseif($condicional == 'combosVencidos')
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
                                                @if ($condicional == 'combos')
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
                                                @elseif($condicional == 'combosVencidos')
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
                                            <h6 class="text-center">{{ $p->importe }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->plan_start)->format('d/m/Y') }} </h6>
                                        </td>
                                        <td class="text-center"
                                            @if ($condicional == 'combos') @if ($p->horasPlan > 72) style="background-color: #09ed3d !important"
                                                                @elseif($p->horasPlan >= 0 && $p->horasPlan <= 72)
                                                                style="background-color: #f1dc08 !important"
                                                                @else
                                                                style="background-color: #FF0000 !important" @endif
                                            @endif>
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->expiration_plan)->format('d/m/Y') }}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            @if ($condicional == 'combos')
                                                <a href="javascript:void(0)"
                                                    wire:click="AccionesCombo('{{ $p->id }}','{{ $IDcliente }}')"
                                                    class="btn btn-dark mtmobile" title="Renovación">
                                                    <i class="fa-regular fa-calendar-check"></i>
                                                </a>
                                            @endif
                                            <a href="javascript:void(0)"
                                                wire:click="EditCombo('{{ $p->id }}',{{ $p->Mov->climov->client->id }})"
                                                class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>

                                        <td class="text-center"
                                            style="{{ $p->done == 'NO' ? 'background-color: #d97171 !important' : 'background-color: #09ed3d !important' }}">
                                            @if ($p->done == 'NO')
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
                        {{ $profiles->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
    @include('livewire.perfiles.form')
    @include('livewire.perfiles.detailsPlan')
    @include('livewire.perfiles.modalEditCombos')
    @include('livewire.perfiles.modalRenovarCombos')
    @include('livewire.perfiles.observacionesPlan')

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide'),
                noty(msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });
        window.livewire.on('details-show', msg => {
            $('#modal-details').modal('show')
        });
        window.livewire.on('item-accion', msg => {
            $('#modal-details').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-error', msg => {
            noty(msg)
        });
        window.livewire.on('modal-hide', msg => {
            $('#modal-details').modal('hide')
        });

        window.livewire.on('show-crearPerfil', Msg => {
            $('#Modal_crear_perfil').modal('show')
        })
        window.livewire.on('crearperfil-cerrar', Msg => {
            $('#Modal_crear_perfil').modal('hide')
            noty(Msg)
        })

        window.livewire.on('modal-show-edit-combo', msg => {
            $('#modal-edit-combos').modal('show')
        });
        window.livewire.on('combo-updated', msg => {
            $('#modal-edit-combos').modal('hide')
            noty(msg)
        });

        window.livewire.on('modal-acciones-combo', msg => {
            $('#modal-acciones-combo').modal('show')
        });
        window.livewire.on('acciones-combo-hide', msg => {
            $('#modal-acciones-combo').modal('hide')
            noty(msg)
        });
        window.livewire.on('modal-observaciones-show', msg => {
            $('#modal-observaciones').modal('show')
        });
        window.livewire.on('modal-observaciones-hide', msg => {
            $('#modal-observaciones').modal('hide')
            noty(msg)
        });

    });

    function ConfirmVencer(nameperfil) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Esta seguro de vencer el perfil ' + nameperfil + ' ?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('Vencer')
                swal.fire(
                    'Se venció el perfil ' + nameperfil,
                    'El perfil a pasado a vencido.'
                )
            }
        })
    }

    function ConfirmCambiar(id, nameperfil, email) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Esta seguro de cambiar el perfil ' + nameperfil + ' a la cuenta ' + email + ' ?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('SeleccionarCuenta', id)
                swal.fire(
                    'Los datos del perfil actual se cambiaran por los del nuevo automaticamente',
                    'Se cambio de cuenta el perfil ' + nameperfil + ' de pin a la cuenta ' +
                    email
                )
            }
        })
    }

    function ConfirmHecho(id) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Ya realizó las acciones correspondientes para este perfil y desea ponerlo en realizado?',
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

    function ConfirmRenovarCombo(nombreCliente) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar RENOVAR el combo del cliente ' + '"' + nombreCliente + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('RenovarCombo')
                Swal.close()
            }
        })
    }

    function ConfirmVencerCombo(nombreCliente) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar VENCER el combo del cliente ' + '"' + nombreCliente + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('VencerCombo')
                Swal.close()
            }
        })
    }

    function CambiardeCuentaPerf1(id, plataforma, cuenta) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar cambiar el perfil de la plataforma ' + plataforma + ' a la cuenta ' + cuenta +
                '?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('SeleccionarCuenta1', id)
                Swal.close()
            }
        })
    }

    function CambiardeCuentaPerf2(id, plataforma, cuenta) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar cambiar el perfil de la plataforma ' + plataforma + ' a la cuenta ' + cuenta +
                '?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('SeleccionarCuenta2', id)
                Swal.close()
            }
        })
    }

    function CambiardeCuentaPerf3(id, plataforma, cuenta) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar cambiar el perfil de la plataforma ' + plataforma + ' a la cuenta ' + cuenta +
                '?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('SeleccionarCuenta3', id)
                Swal.close()
            }
        })
    }

    function Confirm(id, name) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el perfil ' + '"' + name + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>
