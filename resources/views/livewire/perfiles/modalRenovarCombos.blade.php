<div wire:ignore.self id="modal-acciones-combo" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>RENOVACION Y VENCIMIENTO DE PERFILES DE COMBO</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>{{ $plataforma1Nombre }}</h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>NOMBRE PERFIL</h6>
                            <input type="text" wire:model="perfil1COMBO" class="form-control">

                            @error('nombreCliente')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>PIN PERFIL</h6>
                            <input type="text" wire:model="PIN1COMBO" class="form-control">
                            @error('celular')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Expiracion cuenta {{ $plataforma1Nombre }}</label>
                            <h6 class="form-control"><strong>
                                    {{ \Carbon\Carbon::parse($expiracionCuenta1)->format('d/m/Y') }}</strong>
                            </h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
                                wire:click.prevent="cambiarCuentaPlat1()">Cambiar de cuenta perfil plataforma 1</a>
                        </div>
                    </div>

                    @if ($mostrarTablaCambiar1 == 'SI')
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
                                                @if ($cuentasConEspaciosP1->count() == 0)
                                                    <tr>
                                                        <td colspan="5">
                                                            <h6 class="text-center">No tiene cuentas para hacer el
                                                                cambio</h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($cuentasConEspaciosP1)
                                                    @foreach ($cuentasConEspaciosP1 as $item)
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
                                                                    {{ \Carbon\Carbon::parse($item->expiration_account)->format('d/m/Y') }}
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
                                                                        wire:click="SeleccionarCuenta1('{{ $item->id }}')"
                                                                        class="btn btn-dark mtmobile"
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

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>{{ $plataforma2Nombre }}</h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>NOMBRE PERFIL</h6>
                            <input type="text" wire:model="perfil2COMBO" class="form-control">
                            @error('nombreCliente')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>PIN PERFIL</h6>
                            <input type="text" wire:model="PIN2COMBO" class="form-control">
                            @error('celular')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Expiracion cuenta {{ $plataforma2Nombre }}</label>
                            <h6 class="form-control"><strong>
                                    {{ \Carbon\Carbon::parse($expiracionCuenta2)->format('d/m/Y') }}</strong>
                            </h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
                                wire:click.prevent="cambiarCuentaPlat2()">Cambiar de cuenta perfil plataforma 2</a>
                        </div>
                    </div>

                    @if ($mostrarTablaCambiar2 == 'SI')
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
                                                @if ($cuentasConEspaciosP2->count() == 0)
                                                    <tr>
                                                        <td colspan="5">
                                                            <h6 class="text-center">No tiene cuentas para hacer el
                                                                cambio</h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($cuentasConEspaciosP2)
                                                    @foreach ($cuentasConEspaciosP2 as $item)
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
                                                                    {{ \Carbon\Carbon::parse($item->expiration_account)->format('d/m/Y') }}
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
                                                                        wire:click="SeleccionarCuenta2('{{ $item->id }}')"
                                                                        class="btn btn-dark mtmobile"
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

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>{{ $plataforma3Nombre }}</h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>NOMBRE PERFIL</h6>
                            <input type="text" wire:model="perfil3COMBO" class="form-control">
                            @error('nombreCliente')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>PIN PERFIL</h6>
                            <input type="text" wire:model="PIN3COMBO" class="form-control">
                            @error('celular')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Expiracion cuenta {{ $plataforma3Nombre }}</label>
                            <h6 class="form-control"><strong>
                                    {{ \Carbon\Carbon::parse($expiracionCuenta3)->format('d/m/Y') }}</strong>
                            </h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
                                wire:click.prevent="cambiarCuentaPlat3()">Cambiar de cuenta perfil plataforma 3</a>
                        </div>
                    </div>

                    @if ($mostrarTablaCambiar3 == 'SI')
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
                                                @if ($cuentasConEspaciosP3->count() == 0)
                                                    <tr>
                                                        <td colspan="5">
                                                            <h6 class="text-center">No tiene cuentas para hacer el
                                                                cambio</h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($cuentasConEspaciosP3)
                                                    @foreach ($cuentasConEspaciosP3 as $item)
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
                                                                    {{ \Carbon\Carbon::parse($item->expiration_account)->format('d/m/Y') }}
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
                                                                        wire:click="SeleccionarCuenta3('{{ $item->id }}')"
                                                                        class="btn btn-dark mtmobile"
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

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>Importe</h6>
                            </label>
                            <input wire:model.lazy="importe" class="form-control" type="number">
                            @error('importe')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-8">
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
                            <a href="javascript:void(0)" class="btn btn-dark"
                                wire:click.prevent="RenovarCombo()">Renovar combo</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
                                wire:click.prevent="VencerCombo()">Vencer combo</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
                                wire:click.prevent="UpdateCombo()">Actualizar
                                datos</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
