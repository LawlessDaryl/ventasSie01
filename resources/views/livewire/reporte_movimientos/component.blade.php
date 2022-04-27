<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
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

                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <h6 class="form-control"><strong> TIPO: </strong></h6>
                    </div>
                </div>

                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <select wire:model="opciones" class="form-control">
                            <option value="TODAS">TODAS</option>
                            <option value="EGRESO/INGRESO">INGRESOS Y EGRESOS</option>
                            <option value="CORTE">CORTES</option>
                            <option value="TIGOMONEY">TIGO MONEY</option>
                            <option value="STREAMING">STREAMING</option>
                            <option value="SERVICIOS">SERVICIOS</option>
                        </select>
                    </div>
                </div>
            </div>



            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-4">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center" style="font-size: 80%">IMPORTE</th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">TIPO DE MOVIMIENTO
                                </th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">TIPO</th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">COMENTARIO</th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">NOMBRE CARTERA</th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">DESCRIPCION CARTERA
                                </th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">TIPO CARTERA</th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">TELEFONO</th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">CAJA</th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">USUARIO</th>
                                <th class="table-th text-withe text-center" style="font-size: 80%">FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $product)
                                <tr>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">{{ $product->import }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">
                                            {{ $product->carteramovtype }}</h6>
                                    </td>
                                    <td>
                                        <h6 class=" text-center" style="font-size: 80%">
                                            {{ $product->tipoDeMovimiento }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">{{ $product->comentario }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">{{ $product->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">{{ $product->descripcion }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">{{ $product->tipo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">{{ $product->telefonoNum }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">{{ $product->cajaNombre }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">
                                            {{ $product->usuarioNombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 80%">
                                            {{ $product->movimientoCreacion }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('livewire.products.form') --}}
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
