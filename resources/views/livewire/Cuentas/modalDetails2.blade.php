<div wire:ignore.self id="modal-details2" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    @if ($condicional != 'vencidos')
                        <b>RENOVACION Y VENCIMIENTO DE PLANES DE CUENTA</b>
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
                                <h6>Email o Nombre-Cuenta</h6>
                                <input type="text" disabled wire:model="correoCuenta" class="form-control">
                                @error('correoCuenta')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <h6>Contraseña Cuenta</h6>
                                <input type="text" disabled wire:model="passCuenta" class="form-control">
                                @error('passCuenta')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Meses a renovar</h6>
                                </label>
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
                                <label>
                                    <h6>Tipo de pago</h6>
                                </label>
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
                                <h6>Observaciones del plan // Escriba un nuevo comentario si va a renovar o vencer</h6>
                                <input type="text" wire:model.lazy="observacionesTrans" class="form-control">
                                @error('observacionesTrans')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group text-center mt-4">
                                <a href="javascript:void(0)" @if ($meses == 0) disabled @endif
                                    class="btn btn-warning"
                                    onclick="ConfirmRenovar('{{ $correoCuenta }}','{{ $meses }}')">Renovar
                                    Cuenta</a>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group text-center mt-4">
                                <a href="javascript:void(0)" class="btn btn-warning"
                                    onclick="ConfirmVencer('{{ $correoCuenta }}')">Vencer
                                    Cuenta</a>
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
                                                        <th class="table-th text-withe text-center">Contraseña</th>
                                                        <th class="table-th text-withe text-center">Cant.Perf</th>
                                                        <th class="table-th text-withe text-center">Fecha.Exp</th>
                                                        <th class="table-th text-withe text-center">CAMBIAR</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($cuentasEnteras->count() == 0)
                                                        <tr>
                                                            <td colspan="5">
                                                                <h6 class="text-center">No tienes cuentas de esa
                                                                    plataforma para hacer el cambio</h6>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @foreach ($cuentasEnteras as $cuent)
                                                        <tr>
                                                            <td class="text-center">
                                                                <h6 class="text-center">
                                                                    {{ $cuent->Correo->content }}</h6>
                                                            </td>
                                                            <td class="text-center">
                                                                <h6 class="text-center">
                                                                    {{ $cuent->password_account }}
                                                                </h6>
                                                            </td>
                                                            <td class="text-center">
                                                                <h6 class="text-center">
                                                                    {{ $cuent->number_profiles }}
                                                                </h6>
                                                            </td>
                                                            <td class="text-center">
                                                                <h6 class="text-center">
                                                                    {{ $cuent->expiration_account }}
                                                                </h6>
                                                            </td>
                                                            <td class="text-center">
                                                                <h6 class="text-center">
                                                                    <a href="javascript:void(0)" class="btn btn-warning"
                                                                        onclick="ConfirmCambiar('{{ $cuent->id }}','{{ $cuent->Correo->content }}')">Seleccionar</a>
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                    @endforeach
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
                                <input type="text" wire:model.lazy="observacionesTrans" class="form-control">
                                @error('observacionesTrans')
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
