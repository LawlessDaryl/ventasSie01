<div wire:ignore.self id="modal-details" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>RENOVACION Y VENCIMIENTO DE PERFILES</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>Nombre Cliente</h6>
                            <h6 class="form-control"><strong> {{ $nombreCliente }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>Celular</h6>
                            <h6 class="form-control"><strong> {{ $celular }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>Nombre del perfil</h6>
                            <h6 class="form-control"><strong> {{ $nameperfil }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>Pin</h6>
                            <h6 class="form-control"><strong> {{ $pin }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>Plataforma</h6>
                            <h6 class="form-control"><strong> {{ $plataformaPlan }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>Meses de compra</h6>
                            <h6 class="form-control"><strong> {{ $mesesPlan }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <h6>Precio Compra</h6>
                            <h6 class="form-control"><strong> {{ $importePlan }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de inicio de su plan</h6>
                        <div class="form-group">
                            <h6 class="form-control"><strong>
                                    {{ \Carbon\Carbon::parse($inicioPlanActual)->format('d/m/Y') }}
                                </strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de expiración de su plan</h6>
                        <div class="form-group">
                            <h6 class="form-control"><strong>
                                    {{ \Carbon\Carbon::parse($expirationPlanActual)->format('d/m/Y') }}
                                </strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de inicio nueva</h6>
                        <div class="form-group">
                            <input type="date" wire:model="inicioNueva" class="form-control">
                            @error('inicioNueva')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de expiración nueva</h6>
                        <div class="form-group">
                            <h6 class="form-control"><strong>
                                    {{ \Carbon\Carbon::parse($expirationNueva)->format('d/m/Y') }}
                                </strong></h6>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Dias calculo</h6>
                            <input type="number" wire:model="diasdePlan" class="form-control">
                            @error('diasdePlan')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Meses a renovar</h6>
                            <input type="number" wire:model="meses" class="form-control">
                            @error('meses')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Tipo de pago</h6>
                            <select wire:model="tipopago" class="form-control">
                                <option value="EFECTIVO" selected>EFECTIVO</option>
                                {{-- <option value="Banco">CUENTA BANCARIA</option>
                                <option value="TigoStreaming">TIGO MONEY</option> --}}
                            </select>
                            @error('tipopago')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
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
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="comprobante"
                                accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label">Comprobante {{ $comprobante }}</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>Observaciones del plan // Escriba un nuevo comentario si va a renovar, vencer o
                                cambiar de cuenta</h6>
                            <input type="text" wire:model.lazy="observations" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center mt-4">
                            <button type="button" @if ($meses <= 0) disabled @endif
                                wire:click.prevent="Renovar()" class="btn btn-dark">Renovar
                                plan</button>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
                                onclick="ConfirmVencer('{{ $nameperfil }}')">Vencer
                                plan</a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
                                wire:click.prevent="CambiarCuenta()">Buscar
                                otra cuenta (Cambiar)</a>
                        </div>
                    </div>
                    <div class="row">
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
                                                                <h6 class="text-center">No tiene cuentas para hacer
                                                                    el cambio</h6>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if ($cuentasEnteras)
                                                        @foreach ($cuentasEnteras as $item)
                                                            @if ($item->espacios > 0)
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
                                                                            {{ $item->espacios }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-dark"
                                                                                onclick="ConfirmCambiar('{{ $item->id }}','{{ $nameperfil }}','{{ $item->account_name }}')">
                                                                                <i class="fas fa-check"></i>
                                                                            </a>
                                                                        </h6>
                                                                    </td>
                                                                </tr>
                                                            @endif
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
                </div>
            </div>
        </div>
    </div>
</div>
