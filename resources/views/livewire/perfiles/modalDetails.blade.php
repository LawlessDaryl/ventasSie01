<div wire:ignore.self id="modal-details" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    @if ($condicional != 'vencidos')
                        <b>RENOVACION Y VENCIMIENTO DE PERFILES</b>
                    @else
                        <b>OBSERVACIONES</b>
                    @endif
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($condicional != 'vencidos')
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <h6>Nombre Cliente</h6>
                                <input type="text" disabled wire:model="nombreCliente" class="form-control">
                                @error('nombreCliente')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <h6>Celular</h6>
                                <input type="text" disabled wire:model="celular" class="form-control">
                                @error('celular')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <h6>Nombre del perfil</h6>
                                <input type="text" disabled wire:model="nameperfil" class="form-control">
                                @error('nameperfil')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <h6>Pin</h6>
                                <input type="text" disabled wire:model="pin" class="form-control">
                                @error('pin')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <h6>Meses a renovar</h6>
                                <input type="number" wire:model="meses" class="form-control"
                                    placeholder="PerfilNetflix1">
                                @error('meses')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <h6>Fecha de expiración Actual</h6>
                            <div class="form-group">
                                <input type="date" wire:model="expirationActual" class="form-control" disabled>
                                @error('expirationActual')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <h6>Fecha de expiración nueva</h6>
                            <div class="form-group">
                                <input type="date" wire:model="expirationNueva" class="form-control" disabled>
                                @error('expirationNueva')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <h6>Tipo de pago</h6>
                                <select wire:model="tipopago" class="form-control">
                                    <option value="EFECTIVO" selected>EFECTIVO</option>
                                    <option value="Banco">CUENTA BANCARIA</option>
                                    <option value="TigoStreaming">TIGO MONEY</option>
                                </select>
                                @error('tipopago')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <h6>Observaciones del plan // Escriba un nuevo comentario si va a renovar, vencer o
                                    cambiar de cuenta</h6>
                                <input type="text" wire:model.lazy="observations" class="form-control">
                                @error('observations')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group text-center mt-4">
                                <a @if ($meses == 0) disabled @endif href="javascript:void(0)"
                                    class="btn btn-warning"
                                    onclick="ConfirmRenovar('{{ $nameperfil }}','{{ $meses }}')">Renovar
                                    Perfil</a>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group text-center mt-4">
                                <a href="javascript:void(0)" class="btn btn-warning"
                                    onclick="ConfirmVencer('{{ $nameperfil }}')">Vencer
                                    Perfil</a>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group text-center mt-4">
                                <a href="javascript:void(0)" class="btn btn-warning"
                                    wire:click.prevent="CambiarCuenta()">Cambiar
                                    a otra cuenta</a>
                            </div>
                        </div>

                        @if ($mostrartabla2 == 1)
                            <div class="col-sm-12 col-md-12">
                                <div class="statbox widget box box-shadow">
                                    <div class="widget-content widget-content-area row">
                                        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                            <table class="table table-hover table-sm" style="width:100%">
                                                <thead class="text-white" style="background: #3B3F5C">
                                                    <tr>
                                                        <th class="table-th text-withe text-center">Email</th>
                                                        <th class="table-th text-withe text-center">Max perfiles
                                                        </th>
                                                        <th class="table-th text-withe text-center">Fecha vencimiento
                                                        </th>
                                                        <th class="table-th text-withe text-center">Espacios</th>
                                                        <th class="table-th text-withe text-center">Seleccionar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($cuentasEnteras->count() == 0)
                                                    <tr>
                                                        <td colspan="5">
                                                            <h6 class="text-center">No tiene cuentas para hacer el cambio</h6>                                                            
                                                        </td>
                                                    </tr>
                                                @endif
                                                    @if ($cuentasEnteras)
                                                        @foreach ($cuentasEnteras as $item)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $item->account_name }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $item->number_profiles }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $item->expiration_account }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $item->cantiadadQueSePuedeCrear }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="SeleccionarCuenta('{{ $item->id }}')"
                                                                            class="btn btn-warning mtmobile"
                                                                            title="Seleccionar">
                                                                            <i class="fas fa-check"></i>
                                                                        </a>
                                                                    </h6>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5">
                                                                <h6 class="text-center">No tienes perfiles de esa
                                                                    plataforma</h6>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <h6>Observaciones de la transacción</h6>
                                <input type="text" wire:model.lazy="observations" class="form-control">
                                @error('observations')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
