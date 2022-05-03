<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    @if (!empty(session('sesionCaja')))
                        @can('Ver_Generar_Ingreso_Egreso_Boton')
                            <a wire:click.prevent="viewDetails()" class="btn btn-dark">
                                Generar Ingreso/Egreso en cartera
                            </a>
                        @endcan
                    @endif
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
                <div class="col-sm-12 col-md-12">
                    <h6 class="card-title">
                        <b>CARTERAS EN TU SUCURSAL:</b>
                    </h6>
                    @foreach ($carterasSucursal as $item)
                        <b>{{ $item->cajaNombre }},</b>
                        <b>{{ $item->carteraNombre }}: </b>
                        <b>${{ $item->monto }}.</b>
                        <br>
                    @endforeach
                </div>
            </div>

            @if ($opciones != 'CORTE')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-hover mt-4">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">IMPORTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">TIPO DE
                                        MOVIMIENTO
                                    </th>
                                    @if ($opciones != 'EGRESO/INGRESO')
                                        <th class="table-th text-withe text-center" style="font-size: 100%">TIPO</th>
                                    @endif
                                    <th class="table-th text-withe text-center" style="font-size: 100%">NOMBRE CARTERA
                                    </th>
                                    @if ($opciones != 'EGRESO/INGRESO')
                                        <th class="table-th text-withe text-center" style="font-size: 100%">DESCRIPCION
                                            CARTERA
                                        </th>
                                        {{-- <th class="table-th text-withe text-center" style="font-size: 100%">TIPO CARTERA
                                        </th> --}}
                                        <th class="table-th text-withe text-center" style="font-size: 100%">TELEFONO
                                        </th>
                                    @endif
                                    <th class="table-th text-withe text-center" style="font-size: 100%">CAJA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">USUARIO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $p)
                                    <tr>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">{{ $p->import }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->carteramovtype }}</h6>
                                        </td>
                                        @if ($opciones != 'EGRESO/INGRESO')
                                            <td>
                                                <h6 class=" text-center" style="font-size: 100%">
                                                    {{ $p->tipoDeMovimiento }}</h6>
                                            </td>
                                        @endif
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">{{ $p->nombre }}
                                            </h6>
                                        </td>
                                        @if ($opciones != 'EGRESO/INGRESO')
                                            <td>
                                                <h6 class="text-center" style="font-size: 100%">
                                                    {{ $p->descripcion }}
                                                </h6>
                                            </td>
                                            {{-- <td>
                                                <h6 class="text-center" style="font-size: 100%">{{ $p->tipo }}
                                                </h6>
                                            </td> --}}
                                            <td>
                                                <h6 class="text-center" style="font-size: 100%">
                                                    {{ $p->telefonoNum }}
                                                </h6>
                                            </td>
                                        @endif
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->cajaNombre }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->usuarioNombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                            </h6>
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
                        <table class="table table-unbordered table-hover mt-4">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">TIPO DE MOVIMIENTO</th>
                                    <th class="table-th text-withe text-center">TIPO</th>
                                    <th class="table-th text-withe text-center">CAJA</th>
                                    <th class="table-th text-withe text-center">USUARIO</th>
                                    <th class="table-th text-withe text-center">FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $p)
                                    <tr
                                        @if ($p->movimientotype == 'APERTURA' && $p->status == 'ACTIVO') style="background-color: #09ed3d !important" @endif>
                                        <td>
                                            <h6 class="text-center">{{ $p->movimientotype }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                {{ $p->tipoDeMovimiento }}</h6>
                                        </td>
                                        <td>
                                            <h6 class=" text-center">
                                                {{ $p->cajaNombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                {{ $p->usuarioNombre }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
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
    @include('livewire.reporte_movimientos.modalDetails')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg => {
            $('#modal-details').modal('show')
        })
        window.livewire.on('hide-modal', Msg => {
            $('#modal-details').modal('hide')
            noty(Msg)
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
