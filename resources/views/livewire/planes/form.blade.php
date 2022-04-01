<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | VENDER
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>

            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>Plataforma</h6>
                            </label>
                            <select wire:model.lazy="plataforma" class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>

                                @foreach ($platforms as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                            @error('plataforma')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>TIPO</h6>
                            </label>
                            <select wire:model.lazy="cuentaperfil" class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                <option value="ENTERA">ENTERA</option>
                                <option value="PERFIL">PERFIL</option>
                            </select>
                            @error('cuentaperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>Cantidad</h6>
                            </label>
                            <input type="number" wire:model.lazy="cantidaperf" class="form-control">
                            @error('cantidaperf')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                            @if ($profiles)
                                @if ($cantidaperf > $profiles->count())
                                    <span class="text-danger er">No tiene esa cantidad de perfiles</span>
                                @endif
                            @elseif ($accounts)
                                @if ($cantidaperf > $accounts->count())
                                    <span class="text-danger er">No tiene esa cantidad de cuentas</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Telefono Cliente</h6>
                                </label>
                                <input type="text" wire:model="celular" class="form-control"
                                    placeholder="ej: 67786522">
                                @error('celular')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @if ($BuscarCliente != 0)
                            <div class="vertical-scrollable">
                                <div class="row layout-spacing">
                                    <div class="col-md-12 ">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area row">
                                                <div
                                                    class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                    <table class="table table-hover table-sm" style="width:100%">
                                                        <thead class="text-white" style="background: #3B3F5C">
                                                            <tr>
                                                                <th class="table-th text-withe text-center">CELULAR</th>
                                                                <th class="table-th text-withe">NOMBRE</th>
                                                                <th class="table-th text-withe">SELECIONAR</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($datos as $d)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->celular }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->nombre }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="Seleccionar('{{ $d->celular }}','{{ $d->nombre }}')"
                                                                            class="btn btn-dark mtmobile"
                                                                            title="Seleccionar">
                                                                            <i class="fas fa-check"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Nombre Cliente</h6>
                            </label>
                            <input type="text" wire:model="nombre" class="form-control" placeholder="ej: Juan Perez">
                            @error('nombre')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
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

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>Meses para el plan</h6>
                            </label>
                            <input type="number" wire:model="meses" class="form-control" placeholder="PerfilNetflix1">
                            @error('meses')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <h6>Fecha de inicio del plan</h6>
                        <div class="form-group">
                            <input type="date" wire:model="fecha_inicio" class="form-control">
                            @error('fecha_inicio')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <h6>Fecha de expiración del plan</h6>
                        <div class="form-group">
                            <input  type="date" wire:model="expiration_plan" class="form-control">
                            @error('expiration_plan')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-8">
                        <div class="form-group">
                            <label>
                                <h6>Observaciones</h6>
                            </label>
                            <input wire:model.lazy="observaciones" class="form-control" name="" rows="5">
                            @error('observaciones')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                @error('accounts')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
                @error('profiles')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror

                <div class='row'>
                    @if ($mostrartabla == 1)
                        <div class="col-sm-12 col-md-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area row">
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-hover table-sm" style="width:100%">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Email o Nombre Usuario
                                                    </th>
                                                    <th class="table-th text-withe text-center">Contraseña</th>
                                                    <th class="table-th text-withe text-center">Precio</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($accounts->count() == 0)
                                                    <tr>
                                                        <td colspan="2">
                                                            <h6 class="text-center">No tienes cuentas enteras de esa
                                                                plataforma
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @foreach ($accounts as $ap)
                                                    <tr>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->account_name }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->password_account }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->precioEntera }}</h6>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <tfoot>
                                            <tr>
                                                <td colspan="1" class="text-left">
                                                    <span><b>TOTAL: </b></span>
                                                </td>
                                                <td class="text-right " colspan="2">
                                                    <span><strong>
                                                            Bs.
                                                            {{ number_format($accounts->sum('precioEntera'), 2) * $meses }}
                                                        </strong></span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($mostrartabla == 2)
                        <div class="col-sm-12 col-md-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area row">
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-hover table-sm" style="width:100%">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Email</th>
                                                    <th class="table-th text-withe text-center">Contraseña</th>
                                                    <th class="table-th text-withe text-center">Nombre Perfil</th>
                                                    <th class="table-th text-withe text-center">Pin</th>
                                                    <th class="table-th text-withe text-center">Precio</th>
                                                    <th class="table-th text-withe text-center">EDITAR</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($profiles->count() == 0)
                                                    <tr>
                                                        <td colspan="5">
                                                            <h6 class="text-center">No tienes perfiles creados de
                                                                esa
                                                                plataforma</h6>
                                                            @if (count($this->cuentasEnteras) > 0)
                                                                <h6 class="text-center">Pero tienes una o mas
                                                                    cuentas
                                                                    con espacios de perfiles
                                                                </h6>
                                                                <h6 class="text-center">
                                                                    <a wire:click="VerCuentas()"
                                                                        class="btn btn-warning btn-lg active"
                                                                        role="button" aria-pressed="true">VER CUENTAS Y
                                                                        CREAR PERFIL</a>
                                                                </h6>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                @foreach ($profiles as $ap)
                                                    <tr>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->email }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->password_account }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->nombre_perfil }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->pin }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->precioPerfil }}</h6>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)"
                                                                wire:click="EditarPerf({{ $ap->id }})"
                                                                class="btn btn-dark mtmobile" title="EDITAR">
                                                                <i class="fa-solid fa-file-signature"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="1" class="text-left">
                                                        <span><b>TOTAL: </b></span>
                                                    </td>
                                                    <td class="text-right " colspan="4">
                                                        <span><strong>
                                                                Bs.
                                                                {{ number_format($profiles->sum('precioPerfil'), 2) * $meses }}
                                                            </strong></span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()"
                    class="btn btn-dark close-btn text-info">LIMPIAR</button>
                <button type="button" wire:click.prevent="Store()"
                    class="btn btn-dark close-btn text-info">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
