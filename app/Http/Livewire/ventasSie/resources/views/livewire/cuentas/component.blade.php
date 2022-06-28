<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" wire:click="Agregar()">Agregar</a>
                </ul>
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
                @if ($condicional == 'cuentas')
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <h6 class="form-control"><strong>TIPO: </strong></h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <select wire:model="EnterasDivididas" class="form-control">
                                <option value="TODOS">TODOS</option>
                                <option value="ENTERA">ENTERAS</option>
                                <option value="DIVIDIDA">DIVIDIDAS</option>
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <h6 class="form-control"><strong>PLATAFORMA: </strong></h6>
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
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="libres"
                                        value="cuentas" wire:model="condicional">
                                    <span class="new-control-indicator"></span>
                                    <h6>CUENTAS ENTERAS Y DIVIDIDAS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                        value="ocupados" wire:model="condicional">
                                    <span class="new-control-indicator"></span>
                                    <h6>PLANES CUENTAS ENTERAS OCUPADAS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                        value="vencidos" wire:model="condicional">
                                    <span class="new-control-indicator"></span>
                                    <h6>PLANES VENCIDOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id=""
                                        value="inhabilitadas" wire:model="condicional">
                                    <span class="new-control-indicator"></span>
                                    <h6>CUENTAS NO RENOVADAS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($condicional == 'cuentas' || $condicional == 'inhabilitadas')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA Y PROVEEDOR</th>
                                    <th class="table-th text-withe text-center">GMAIL O NOMBRE-USUARIO</th>
                                    <th class="table-th text-withe text-center">PASS CUENTA</th>
                                    <th class="table-th text-withe text-center">EXPIRACIÓN CUENTA</th>
                                    <th class="table-th text-withe text-center">TIPO</th>
                                    <th class="table-th text-withe text-center">MAX. PERF</th>
                                    @if ($condicional == 'cuentas')
                                        <th class="table-th text-withe text-center">PERF. LIBRES</th>
                                        <th class="table-th text-withe text-center">PERF. OCUPADOS</th>
                                        <th class="table-th text-withe text-center">ACCIONES</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cuentas as $acounts)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->nombre }} <br>
                                                {{ $acounts->name }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->account_name }} <br>
                                                {{ $acounts->pass }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->password_account }}</h6>
                                        </td>
                                        @if ($acounts->dias > 5)
                                            <td class="text-center" style="background-color: #09ed3d !important">
                                                <a href="javascript:void(0)"
                                                    wire:click="mostrarRenovar({{ $acounts->IDaccount }})"
                                                    class="btn btn-primary" title="Renovar">
                                                    {{ \Carbon\Carbon::parse($acounts->expiration_account)->format('d/m/Y') }}
                                                </a>
                                            </td>
                                        @elseif($acounts->dias >= 0 && $acounts->dias <= 5)
                                            <td class="text-center" style="background-color: #f1dc08 !important">
                                                <a href="javascript:void(0)"
                                                    wire:click="mostrarRenovar({{ $acounts->IDaccount }})"
                                                    class="btn btn-primary" title="Renovar">
                                                    {{ \Carbon\Carbon::parse($acounts->expiration_account)->format('d/m/Y') }}
                                                </a>
                                            </td>
                                        @else
                                            <td class="text-center" style="background-color: #FF0000 !important">
                                                <a href="javascript:void(0)"
                                                    wire:click="mostrarRenovar({{ $acounts->IDaccount }})"
                                                    class="btn btn-primary" title="Renovar">
                                                    {{ \Carbon\Carbon::parse($acounts->expiration_account)->format('d/m/Y') }}
                                                </a>
                                            </td>
                                        @endif
                                        <td>
                                            <h6 class="text-center">{{ $acounts->whole_account }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->number_profiles }}</h6>
                                        </td>
                                        @if ($condicional == 'cuentas')
                                            <td>
                                                <h6 class="text-center">{{ $acounts->perfLibres }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $acounts->perfOcupados }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)"
                                                    wire:click="VerPerfiles({{ $acounts->IDaccount }})"
                                                    class="btn btn-warning" title="Ver Perfiles">
                                                    <i class="fa-solid fa-user-gear"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    wire:click="Edit({{ $acounts->IDaccount }})"
                                                    class="btn btn-warning" title="Editar Cuenta">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if ($acounts->dias <= 3)
                                                    <a href="javascript:void(0)"
                                                        onclick="ConfirmarInhabilitar('{{ $acounts->IDaccount }}','{{ $acounts->perfOcupados }}')"
                                                        class="btn btn-warning" title="Inhabilitar">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $cuentas->links() }}
                    </div>
                </div>
            @else
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA Y PROVEEDOR</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">GMAIL O NOMBRE-USUARIO</th>
                                    <th class="table-th text-withe text-center">PASS CUENTA</th>
                                    <th class="table-th text-withe text-center">EXPIRACIÓN CUENTA</th>
                                    <th class="table-th text-withe text-center">MAX PERF</th>
                                    <th class="table-th text-withe text-center">INICIO PLAN</th>
                                    <th class="table-th text-withe text-center">EXPIRACIÓN PLAN</th>
                                    <th class="table-th text-withe text-center">RENOVACION</th>
                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                    <th class="table-th text-withe text-center">REALIZADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cuentas as $acounts)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->nombre }} <br>
                                                {{ $acounts->name }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                <strong> N:
                                                </strong>{{ $acounts->clienteNombre }} <strong>TELF: </strong>
                                                {{ $acounts->clienteCelular }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->account_name }} <br>
                                                {{ $acounts->pass }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->password_account }}</h6>
                                        </td>
                                        <td class="text-center"
                                            @if ($condicional == 'ocupados') @if ($acounts->dias > 5)
                                            style="background-color: #09ed3d !important"
                                            @elseif($acounts->dias >= 0 && $acounts->dias <= 5)
                                            style="background-color: #f1dc08 !important"
                                            @else
                                            style="background-color: #FF0000 !important" @endif
                                            @endif>
                                            @if ($condicional == 'ocupados')
                                                <a href="javascript:void(0)"
                                                    wire:click="mostrarRenovar({{ $acounts->IDaccount }})"
                                                    class="btn btn-primary" title="Renovar">
                                                    {{ \Carbon\Carbon::parse($acounts->expiration_account)->format('d/m/Y') }}
                                                </a>
                                            @else
                                                <h6>{{ \Carbon\Carbon::parse($acounts->expiration_account)->format('d/m/Y') }}
                                                </h6>
                                            @endif
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->number_profiles }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($acounts->plan_start)->format('d/m/Y') }}
                                            </h6>
                                        </td>
                                        <td @if ($condicional == 'ocupados') @if ($acounts->horas > 72)
                                            style="background-color: #09ed3d !important"
                                            @elseif($acounts->horas >= 0 && $acounts->horas <= 72)
                                            style="background-color: #f1dc08 !important"
                                            @else
                                            style="background-color: #FF0000 !important" @endif
                                            @endif>
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($acounts->expiration_plan)->format('d/m/Y') }}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            @if ($acounts->plan_status == 'VIGENTE')
                                                <a href="javascript:void(0)"
                                                    wire:click="Acciones('{{ $acounts->planid }}','{{ $acounts->IDplanAccount }}','{{ $acounts->IDaccount }}','{{ $acounts->IDplatf }}','{{ $acounts->clienteID }}')"
                                                    class="btn btn-warning" title="Renovación">
                                                    <i class="fa fas fa-file-signature"></i>
                                                </a>
                                            @endif
                                        
                                    
                                            <a href="javascript:void(0)" wire:click="Edit({{ $acounts->IDaccount }})"
                                                class="btn btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                wire:click="EditObservaciones('{{ $acounts->planid }}','{{ $acounts->clienteID }}')"
                                                class="btn btn-warning" title="Observaciones">
                                                <i class="fa fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td
                                            style="{{ $acounts->done == 'NO' ? 'background-color: #d97171 !important' : 'background-color: #09ed3d !important' }}">
                                            @if ($acounts->done == 'NO')
                                                <a href="javascript:void(0)" class="btn btn-warning"
                                                    onclick="ConfirmHecho('{{ $acounts->planid }}')">
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
                        {{ $cuentas->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('livewire.cuentas.form')
    @include('livewire.cuentas.modalPerfiles')
    @include('livewire.cuentas.detailsPlan')
    @include('livewire.cuentas.modalRenovarProveedor')
    @include('livewire.cuentas.observacionesPlan')

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

        window.livewire.on('details-show', msg => {
            $('#modal-details').modal('show')
        });
        window.livewire.on('perfil-up', msg => {
            $('#modal-details').modal('hide')
            noty(msg)
        });
        window.livewire.on('modal-hide', msg => {
            $('#modal-details').modal('hide')
        });

        window.livewire.on('details2-show', msg => {
            $('#modal-details2').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#modal-details2').modal('hide')
        });
        window.livewire.on('cuenta-renovado-vencida', msg => {
            $('#modal-details2').modal('hide')
            noty(msg)
        });
        window.livewire.on('details3-show', msg => {
            $('#modal-details3').modal('show')
        });
        window.livewire.on('modal-hide3', msg => {
            $('#modal-details3').modal('hide')
            noty(msg)
        });

        window.livewire.on('item-accion', msg => {
            $('#modal-details2').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-error', msg => {
            noty(msg)
        });
        /* window.livewire.on('cuenta-renovado-vencida', msg => {
            $('#modal-details2').modal('hide')
            noty(msg)
        }); */
        window.livewire.on('modal-observaciones-show', msg => {
            $('#modal-observaciones').modal('show')
        });
        window.livewire.on('modal-observaciones-hide', msg => {
            $('#modal-observaciones').modal('hide')
            noty(msg)
        });

    });

    function ConfirmVencer(cuenta) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Esta seguro de vencer la cuenta ' + cuenta + ' ?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('Vencer')
                swal.fire(
                    'Se venció la cuenta ' + cuenta,
                    'La cuenta a pasado a vencida.'
                )
            }
        })
    }


    function ConfirmCambiar(id, correo) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Esta seguro de cambiar a la cuenta ' + correo + ' ?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('CambiarAccount', id)
            }
        })
    }

    function ConfirmHecho(id) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Ya realizó las acciones correspondientes para la cuenta y desea ponerlo en realizado?',
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

    function ConfirmarInhabilitar(id, ocupados) {
        if (ocupados > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede inhabilitar la cuenta porque tiene , ' + ocupados + ' perfil/es ocupado/s.'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmar inhabilitar la cuenta?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('InhabilitarCuenta', id)
                Swal.close()
            }
        })
    }
</script>
