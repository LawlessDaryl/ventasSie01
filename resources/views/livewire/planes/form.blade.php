<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog" style="overflow-y: scroll;">
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
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Plataforma</h6>
                            </label>
                            <select wire:model="plataforma" class="form-control">
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

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>TIPO</h6>
                            </label>
                            <select @if ($plataforma == 'Elegir') disabled @endif wire:model.lazy="cuentaperfil"
                                class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                @if ($perfiles_si_no == 'SI')
                                    <option value="ENTERA">ENTERA</option>
                                    <option value="PERFIL">PERFIL</option>
                                @else
                                    <option value="ENTERA">ENTERA</option>
                                @endif
                            </select>
                            @error('cuentaperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                @error('accounts')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror

                <div class='row'>
                    @if ($mostrartabla == 1)
                        <div class="col-sm-12 col-md-12">
                            <div class="widget-content widget-content-area row">
                                <h6>SELECCIONE LAS CUENTAS</h6>
                                <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-hover table-sm" style="width:100%">
                                        <thead class="text-white" style="background: #3B3F5C">
                                            <tr>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Email-Nombre Usuario
                                                </th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Contraseña</th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Max. perfiles</th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Vencimiento</th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Precio</th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($cuentasLibresEnteras->count() == 0)
                                                <tr>
                                                    <td colspan="6">
                                                        <h6 class="text-center">No tienes cuentas enteras de esa
                                                            plataforma.
                                                        </h6>
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($cuentasLibresEnteras as $ap)
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
                                                        <h6 class="text-center">{{ $ap->number_profiles }}
                                                        </h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6 class="text-center">
                                                            {{ \Carbon\Carbon::parse($ap->expiration_account)->format('d/m/Y') }}
                                                        </h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6 class="text-center">{{ $ap->precioEntera }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)"
                                                            wire:click="AgregarCuenta({{ $ap->id }})"
                                                            class="btn btn-dark mtmobile" title="Seleccionar">
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
                        @if ($mostrartablaCuenta == 'SI')
                            <div class="col-sm-12 col-md-12">
                                <div class="widget-content widget-content-area row">
                                    <h6>CUENTAS SELECCIONADAS</h6>
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-hover table-sm" style="width:100%">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center" style="font-size: 80%">
                                                        Email o Nombre
                                                        Usuario
                                                    </th>
                                                    <th class="table-th text-withe text-center" style="font-size: 80%">
                                                        Contraseña</th>
                                                    <th class="table-th text-withe text-center" style="font-size: 80%">
                                                        Max. perfiles</th>
                                                    <th class="table-th text-withe text-center" style="font-size: 80%">
                                                        Vencimiento</th>
                                                    <th class="table-th text-withe text-center" style="font-size: 80%">
                                                        Precio</th>
                                                    <th class="table-th text-withe text-center" style="font-size: 80%">
                                                        Remover</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($accounts as $ap)
                                                    <tr>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->account_name }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">
                                                                {{ $ap->password_account }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">
                                                                {{ $ap->number_profiles }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">
                                                                {{ \Carbon\Carbon::parse($ap->expiration_account)->format('d/m/Y') }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">
                                                                {{ $ap->Plataforma->precioEntera }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="javascript:void(0)"
                                                                wire:click="QuitarCuenta({{ $ap->id }})"
                                                                class="btn btn-dark mtmobile" title="Remover">
                                                                <i class="fa-solid fa-x"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if ($mostrartabla == 2)
                        <div class="col-sm-12 col-md-12">
                            <div class="widget-content widget-content-area row">
                                <h6>SELECCIONE UNA CUENTA PARA SUMAR UN PERFIL</h6>
                                <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-hover table-sm" style="width:100%">
                                        <thead class="text-white" style="background: #3B3F5C">
                                            <tr>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Email-Nombre Usuario
                                                </th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    VENCIMIENTO</th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Max perf</th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Perf Ocupados</th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Espacios</th>
                                                <th class="table-th text-withe text-center" style="font-size: 80%">
                                                    Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($cuentasEnteras->count() == 0)
                                                <tr>
                                                    <td colspan="6">
                                                        <h6 class="text-center">No tienes cuentas con espacios
                                                            de esta plataforma.
                                                        </h6>
                                                    </td>
                                                </tr>
                                            @endif
                                            @foreach ($cuentasEnteras as $ap)
                                                @if ($ap->number_profiles != $ap->perfOcupados)
                                                    <tr>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                {{ $ap->account_name }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                {{ \Carbon\Carbon::parse($ap->expiration_account)->format('d/m/Y') }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                {{ $ap->number_profiles }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                {{ $ap->perfOcupados }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                {{ $ap->espacios }}</h6>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)"
                                                                wire:click="AgregarPerfil({{ $ap->id }})"
                                                                class="btn btn-dark mtmobile" title="Seleccionar">
                                                                <i class="fas fa-check"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        @error('profiles')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        @if ($mostrartablaPerfiles == 'SI')
                            <div class="col-sm-12 col-md-12">
                                <div class="widget-content widget-content-area row">
                                    <h6>PERFILES SELECCIONADOS</h6>
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-hover table-sm" style="width:100%">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Email</th>
                                                    <th class="table-th text-withe text-center">Vencimiento</th>
                                                    <th class="table-th text-withe text-center">Nombre Perfil</th>
                                                    <th class="table-th text-withe text-center">Pin</th>
                                                    <th class="table-th text-withe text-center">Precio</th>
                                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($profiles as $ap)
                                                    <tr>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                @foreach ($ap->CuentaPerfil as $item)
                                                                    @if ($item->status = 'SinAsignar')
                                                                        {{ $item->Cuenta->account_name }}
                                                                    @endif
                                                                @endforeach
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                @foreach ($ap->CuentaPerfil as $item)
                                                                    @if ($item->status = 'SinAsignar')
                                                                        {{ \Carbon\Carbon::parse($item->Cuenta->expiration_account)->format('d/m/Y') }}
                                                                    @endif
                                                                @endforeach
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                {{ $ap->nameprofile }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                {{ $ap->pin }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center" style="font-size: 100%">
                                                                @foreach ($ap->CuentaPerfil as $item)
                                                                    @if ($item->status = 'SinAsignar')
                                                                        {{ $item->Cuenta->Plataforma->precioPerfil }}
                                                                    @endif
                                                                @endforeach
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)"
                                                                wire:click="EditarPerf({{ $ap->id }})"
                                                                class="btn btn-dark mtmobile" title="EDITAR">
                                                                <i class="fa-solid fa-file-signature"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                wire:click="QuitarPerfil({{ $ap->id }})"
                                                                class="btn btn-dark mtmobile" title="Remover">
                                                                <i class="fa-solid fa-x"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        @endif
                    @endif
                </div>
                <div class="row">
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
                    <div class="col-sm-12 col-md-8">
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
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="comprobante"
                                accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label">Comprobante {{ $comprobante }}</label>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="CargarAnterior()"
                    class="btn btn-dark close-btn text-info">CARGAR
                    ANTERIOR</button>
                <button type="button" wire:click.prevent="resetUI()"
                    class="btn btn-dark close-btn text-info">LIMPIAR</button>
                <button type="button" wire:click.prevent="Store()"
                    class="btn btn-dark close-btn text-info">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
