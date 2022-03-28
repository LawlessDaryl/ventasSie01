<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
            </div>
            @include('common.searchbox')

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="libres"
                                        value="libres" wire:model="condicional">
                                    <span class="new-control-indicator"></span>
                                    <h6>LIBRES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                        value="ocupados" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>OCUPADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                        value="vencidos" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>VENCIDOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($condicional == 'libres')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-hover mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">GMAIL</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">PERFIL</th>
                                    <th class="table-th text-withe text-center">EXPIRACION CUENTA</th>

                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profiles as $p)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{ $p->nombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->content }} <br> {{ $p->pass }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->passAccount }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center"><strong> Nombre: </strong>{{ $p->namep }}
                                                <strong>PIN: </strong>{{ $p->pin }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->expiration }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" wire:click="Edit({{ $p->id }})"
                                                class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                onclick="Confirm('{{ $p->id }}','{{ $p->correo }}')"
                                                class="btn btn-dark" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
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
                        <table class="table table-unbordered table-hover mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">GMAIL</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">PERFIL</th>
                                    <th class="table-th text-withe text-center">EXPIRACION CUENTA</th>
                                    <th class="table-th text-withe text-center">INICIO PLAN</th>
                                    <th class="table-th text-withe text-center">EXPIRACION PLAN</th>
                                    @if ($condicional != 'vencidos')
                                        <th class="table-th text-withe text-center">RENOVAR</th>
                                        <th class="table-th text-withe text-center">EDITAR</th>
                                    @else
                                        <th class="table-th text-withe text-center">OBSERV</th>
                                    @endif
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
                                        <td>
                                            <h6 class="text-center">{{ $p->expiration }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->plan_start }}</h6>
                                        </td>
                                        <td
                                            @if ($condicional == 'ocupados') style="{{ $p->horas <= 24 ? 'background-color: #FF0000 !important' : 'background-color: #09ed3d !important' }}" @endif>
                                            <h6 class="text-center">{{ $p->expiration_plan }}</h6>
                                        </td>
                                        @if ($condicional != 'vencidos')
                                            <td class="text-center">
                                                @if ($p->estadoCuentaPerfil == 'ACTIVO')
                                                    <a href="javascript:void(0)"
                                                        wire:click="Acciones({{ $p->planid }})"
                                                        class="btn btn-dark mtmobile" title="Renovación">
                                                        <i class="fa-regular fa-calendar-check"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($p->estadoCuentaPerfil == 'ACTIVO')
                                                    <a href="javascript:void(0)" wire:click="Edit({{ $p->id }})"
                                                        class="btn btn-dark mtmobile" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @else
                                            <td class="text-center">                                                
                                                    <a href="javascript:void(0)"
                                                        wire:click="Acciones({{ $p->planid }})"
                                                        class="btn btn-dark mtmobile" title="Observaciones">
                                                        <i class="fa-solid fa-file-signature"></i>
                                                    </a>
                                            </td>
                                        @endif

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
            @endif

        </div>
    </div>
    @include('livewire.perfiles.form')
    @include('livewire.perfiles.modalDetails')
    @include('livewire.perfiles.modalCrearPerfil')


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

    function ConfirmRenovar(nameperfil, meses) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Esta seguro de renovar el perfil ' + nameperfil + ' por ' + meses + ' meses?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('Renovar')
                swal.fire(
                    'Se renovó el perfil ' + nameperfil + ' por ' + meses + ' meses.'
                )
            }
        })
    }

    function ConfirmCambiar(id, nameperfil, pin, email, password) {
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
                window.livewire.emit('CambiarAccount', id)
                swal.fire(
                    'Los datos del perfil actual se cambiaran por los del nuevo automaticamente',
                    'Se cambio de cuenta el perfil ' + nameperfil + ' de pin ' +
                    pin + ' a la cuenta ' + email + ' de contraseña ' + password
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
