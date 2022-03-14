<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click="Agregar()">Agregar</a>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="libres"
                                        value="cuentas" wire:model="condicional">
                                    <span class="new-control-indicator"></span>CUENTAS ENTERAS Y DIVIDIDAS
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
                                    <span class="new-control-indicator"></span>CUENTAS ENTERAS OCUPADAS
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
            @if ($condicional == 'cuentas')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-hover mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe">PLATAFORMA</th>
                                    <th class="table-th text-withe">PROVEEDOR</th>
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA</th>
                                    <th class="table-th text-withe text-center">EXPIRA</th>
                                    <th class="table-th text-withe text-center">TIPO</th>
                                    <th class="table-th text-withe text-center">MAX PERF</th>
                                    <th class="table-th text-withe text-center">PERF LIBRES</th>
                                    <th class="table-th text-withe text-center">PERF ACTIVOS</th>
                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cuentas as $acounts)
                                    <tr>
                                        <td>
                                            <h6>{{ $acounts->nombre }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $acounts->name }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->content }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->pass }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->expiration_account }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->whole_account }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->number_profiles }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->perfLibres }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->perfActivos }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" wire:click="Crear({{ $acounts->id }})"
                                                class="btn btn-dark mtmobile" title="Crear Perfil">
                                                <i class="fa-regular fa-square-plus"></i>
                                            </a>
                                            <a href="javascript:void(0)" wire:click="Edit({{ $acounts->id }})"
                                                class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            @else
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-hover mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe">PLATAFORMA</th>
                                    <th class="table-th text-withe">PROVEEDOR</th>
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA</th>
                                    <th class="table-th text-withe text-center">EXPIRA</th>
                                    <th class="table-th text-withe text-center">TIPO</th>
                                    <th class="table-th text-withe text-center">MAX PERF</th>
                                    <th class="table-th text-withe text-center">INICIO PLAN</th>
                                    <th class="table-th text-withe text-center">EXPIRACION PLAN</th>
                                    <th class="table-th text-withe text-center">RENOVAR</th>
                                    <th class="table-th text-withe text-center">EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cuentas as $acounts)
                                    <tr>
                                        <td>
                                            <h6>{{ $acounts->nombre }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $acounts->name }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->content }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->pass }}</h6>
                                        </td>
                                        
                                        <td>
                                            <h6 class="text-center">{{ $acounts->expiration_account }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->whole_account }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->number_profiles }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->plan_start }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $acounts->expiration_plan }}</h6>
                                        </td>
                                       
                                        <td class="text-center">
                                            @if($acounts->plan_status=='VIGENTE')
                                            <a href="javascript:void(0)"
                                                wire:click="Acciones({{ $acounts->planid }})"
                                                class="btn btn-dark mtmobile" title="Renovación">
                                                <i class="fa-regular fa-calendar-check"></i>
                                            </a>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a href="javascript:void(0)" wire:click="Edit({{ $acounts->id }})"
                                                class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
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
    @include('livewire.cuentas.form')
    @include('livewire.cuentas.modalDetails')
    @include('livewire.cuentas.modalDetails2')

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

    /* function Confirm(id, name) {
        
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la cuenta ' + '"' + name + '"',
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
    } */

    function Confirmar(id, name) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la cuenta ' + '"' + name + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('borrarPerfil', id)
                Swal.close()
            }
        })
    }
</script>
