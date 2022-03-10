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
                                            <h6 class="text-center">{{ $p->expiration_plan }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $p->observations }}</h6>
                                        </td>
                                        <td class="text-center">
                                            
                                            <a href="javascript:void(0)" wire:click="Acciones({{ $p->id }})"
                                                class="btn btn-dark mtmobile" title="Renovación">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                    <path style="fill:#E9EBEF;" d="M256,499.2C121.899,499.2,12.8,390.101,12.8,256S121.899,12.8,256,12.8S499.2,121.899,499.2,256  S390.101,499.2,256,499.2z"/>
                                                    <g>
                                                        <path style="fill:#573A32;" d="M256,0C114.62,0,0,114.62,0,256s114.62,256,256,256c141.389,0,256-114.62,256-256S397.389,0,256,0z    M256,486.4C128.956,486.4,25.6,383.044,25.6,256S128.956,25.6,256,25.6S486.4,128.956,486.4,256S383.044,486.4,256,486.4z"/>
                                                        <path style="fill:#573A32;" d="M371.2,243.2H268.8v-128c0-7.074-5.726-12.8-12.8-12.8c-7.074,0-12.8,5.726-12.8,12.8V256   c0,7.074,5.726,12.8,12.8,12.8h115.2c7.074,0,12.8-5.726,12.8-12.8C384,248.926,378.274,243.2,371.2,243.2z"/>
                                                        <rect x="243.2" y="51.2" style="fill:#573A32;" width="25.6" height="25.6"/>
                                                        <rect x="243.2" y="435.2" style="fill:#573A32;" width="25.6" height="25.6"/>
                                                        <rect x="51.2" y="243.2" style="fill:#573A32;" width="25.6" height="25.6"/>
                                                        <rect x="435.2" y="243.2" style="fill:#573A32;" width="25.6" height="25.6"/>
                                                    </g>                                                    
                                                    </svg>
                                            </a>
                                            
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
