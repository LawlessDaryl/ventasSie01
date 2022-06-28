<div wire:ignore.self id="Modal_combos" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>VENTA DE PERFILES POR COMBO</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>PLATAFORMA 1</h6>
                            </label>
                            <select wire:model.lazy="plataforma1" class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                @foreach ($platforms1 as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cuentaperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>PLATAFORMA 2</h6>
                            </label>
                            <select @if ($plataforma1 == 'Elegir') disabled @endif wire:model.lazy="plataforma2"
                                class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                @foreach ($platforms2 as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cuentaperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>PLATAFORMA 3</h6>
                            </label>
                            <select @if ($plataforma2 == 'Elegir') disabled @endif wire:model.lazy="plataforma3"
                                class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                @foreach ($platforms3 as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cuentaperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>
                                <h6>CUENTAS PLATAFORMA 1</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Nombre perfil plataforma 1</h6>
                            </label>
                            <input type="text" wire:model="perfilNombre1" class="form-control"
                                placeholder="Seleccione una cuenta">
                            @error('perfilNombre1')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Pin perfil plataforma 1</h6>
                            </label>
                            <input type="text" wire:model="perfilPin1" class="form-control"
                                placeholder="Seleccione una cuenta">
                            @error('perfilPin1')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @error('perfil1id')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                    @if ($plataforma1 != 'Elegir')
                        <div class="col-sm-12 col-md-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area row">
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-hover table-sm" style="width:100%">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Email o Nombre Usuario
                                                    </th>
                                                    <th class="table-th text-withe text-center">Vencimiento</th>
                                                    <th class="table-th text-withe text-center">Max Perfiles</th>
                                                    <th class="table-th text-withe text-center">Espacios</th>
                                                    <th class="table-th text-withe text-center">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($cuentasp1)
                                                    @if ($cuentasp1->count() == 0)
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6 class="text-center">No tiene cuentas con espacios
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @foreach ($cuentasp1 as $ap)
                                                        @if ($ap->espacios > 0)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $ap->account_name }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ \Carbon\Carbon::parse($ap->expiration_account)->format('d/m/Y') }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $ap->number_profiles }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">{{ $ap->espacios }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)"
                                                                        wire:click="PrimerPerfil({{ $ap->id }})"
                                                                        class="btn btn-dark mtmobile">
                                                                        <i class="fas fa-check"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
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
                            <label>
                                <h6></h6>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>
                                <h6>CUENTAS PLATAFORMA 2</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Nombre perfil plataforma 2</h6>
                            </label>
                            <input type="text" wire:model="perfilNombre2" class="form-control"
                                placeholder="Seleccione una cuenta">
                            @error('perfilNombre2')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Pin perfil plataforma 2</h6>
                            </label>
                            <input type="text" wire:model="perfilPin2" class="form-control"
                                placeholder="Seleccione una cuenta">
                            @error('perfilPin2')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @error('perfil2id')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                    @if ($plataforma2 != 'Elegir')
                        <div class="col-sm-12 col-md-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area row">
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-hover table-sm" style="width:100%">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Email o Nombre Usuario
                                                    </th>
                                                    <th class="table-th text-withe text-center">Vencimiento</th>
                                                    <th class="table-th text-withe text-center">Max Perfiles</th>
                                                    <th class="table-th text-withe text-center">Espacios</th>
                                                    <th class="table-th text-withe text-center">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($cuentasp2)
                                                    @if ($cuentasp2->count() == 0)
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6 class="text-center">No tiene cuentas con espacios
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @foreach ($cuentasp2 as $c2)
                                                        @if ($c2->espacios > 0)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $c2->account_name }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ \Carbon\Carbon::parse($c2->expiration_account)->format('d/m/Y') }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $c2->number_profiles }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">{{ $c2->espacios }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)"
                                                                        wire:click="SegundoPerfil({{ $c2->id }})"
                                                                        class="btn btn-dark mtmobile">
                                                                        <i class="fas fa-check"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
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
                            <label>
                                <h6></h6>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>
                                <h6>CUENTAS PLATAFORMA 3</h6>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Nombre perfil plataforma 3</h6>
                            </label>
                            <input type="text" wire:model="perfilNombre3" class="form-control"
                                placeholder="Seleccione una cuenta">
                            @error('perfilNombre3')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Pin perfil plataforma 3</h6>
                            </label>
                            <input type="text" wire:model="perfilPin3" class="form-control"
                                placeholder="Seleccione una cuenta">
                            @error('perfilPin3')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @error('perfil3id')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                    @if ($plataforma3 != 'Elegir')
                        <div class="col-sm-12 col-md-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area row">
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-hover table-sm" style="width:100%">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Email o Nombre Usuario
                                                    </th>
                                                    <th class="table-th text-withe text-center">Vencimiento</th>
                                                    <th class="table-th text-withe text-center">Max Perfiles</th>
                                                    <th class="table-th text-withe text-center">Espacios</th>
                                                    <th class="table-th text-withe text-center">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($cuentasp3)
                                                    @if ($cuentasp3->count() == 0)
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6 class="text-center">No tiene cuentas con
                                                                    espacios
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @foreach ($cuentasp3 as $c3)
                                                        @if ($c3->espacios > 0)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $c3->account_name }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ \Carbon\Carbon::parse($c3->expiration_account)->format('d/m/Y') }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">
                                                                        {{ $c3->number_profiles }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">{{ $c3->espacios }}
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)"
                                                                        wire:click="TercerPerfil({{ $c3->id }})"
                                                                        class="btn btn-dark mtmobile">
                                                                        <i class="fas fa-check"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
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
                            <label>
                                <h6></h6>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Dias calculo</h6>
                            </label>
                            <input type="number" wire:model="diasdePlan" class="form-control">
                            @error('diasdePlan')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Meses para el plan</h6>
                            </label>
                            <input type="number" wire:model="meses" class="form-control">
                            @error('meses')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <h6>Fecha de inicio</h6>
                        <div class="form-group">
                            <input type="date" wire:model="fecha_inicio" class="form-control">
                            @error('fecha_inicio')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <h6>Fecha de expiración</h6>
                        <div class="form-group">
                            <input type="date" wire:model="expiration_plan" class="form-control">
                            @error('expiration_plan')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-5">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Telefono Cliente</h6>
                                </label>
                                <input type="number" wire:model="celular" class="form-control">
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
                                                                <th class="table-th text-withe text-center">CELULAR
                                                                </th>
                                                                <th class="table-th text-withe">NOMBRE</th>
                                                                <th class="table-th text-withe">ELEGIR</th>
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

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>Nombre Cliente</h6>
                            </label>
                            <input type="text" wire:model="nombre" class="form-control">
                            @error('nombre')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Tipo de pago</h6>
                            </label>
                            <select wire:model="tipopago" class="form-control">
                                <option value="EFECTIVO" selected>EFECTIVO</option>
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
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>
                                <h6>Observaciones</h6>
                            </label>
                            <input wire:model.lazy="observaciones" class="form-control">
                            @error('observaciones')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="comprobante"
                                accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label">Comprobante {{ $comprobante }}</label>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <button type="button" wire:click.prevent="venderCombo()"
                                class="btn btn-dark close-btn text-info">VENDER</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
