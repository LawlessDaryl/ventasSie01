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
                                    <span class="new-control-indicator"></span>LIBRES
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
                                    <span class="new-control-indicator"></span>OCUPADOS
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
                                    <span class="new-control-indicator"></span>VENCIDOS
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
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA EMAIL</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">NOMBRE PERFIL</th>
                                    <th class="table-th text-withe text-center">PIN</th>
                                    <th class="table-th text-withe text-center">EXPIRACION CUENTA</th>
                                    <th class="table-th text-withe text-center">OBSERV</th>
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
                                            <h6 class="text-center">{{ $p->content }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->pass }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->passAccount }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->namep }}</h6>
                                        </td>
                                        <td>
                                            <h6 class=" text-center">{{ $p->pin }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->expiration }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->observations }}</h6>
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
                                    <th class="table-th text-withe">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA EMAIL</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">NOMBRE PERFIL</th>
                                    <th class="table-th text-withe text-center">PIN</th>
                                    <th class="table-th text-withe text-center">EXPIRACION CUENTA</th>
                                    <th class="table-th text-withe text-center">INICIO PLAN</th>
                                    <th class="table-th text-withe text-center">EXPIRACION PLAN</th>
                                    <th class="table-th text-withe text-center">OBSERV</th>
                                    <th class="table-th text-withe text-center">RENOVAR</th>
                                    <th class="table-th text-withe text-center">EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profiles as $p)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{ $p->nombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->content }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->pass }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->passAccount }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->namep }}</h6>
                                        </td>
                                        <td>
                                            <h6 class=" text-center">{{ $p->pin }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->expiration }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->plan_start }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->expiration_plan }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->observations }}</h6>
                                        </td>
                                        <td class="text-center">
                                            @if($p->estadoCuentaPerfil=='ACTIVO')
                                            <a href="javascript:void(0)" wire:click="Acciones({{ $p->planid}})"
                                                class="btn btn-dark mtmobile" title="Renovación">
                                                <i class="fa-regular fa-calendar-check"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" wire:click="Edit({{ $p->id }})"
                                                class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
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

    function Confirm(id, name) {
        /* if (cuentas > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la cuenta, ' + name + ' porque tiene ' +
                    cuentas + ' perfiles relacionadas'
            })
            return;
        } */
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
