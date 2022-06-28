<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Plataforma</h6>
                            </label>
                            <select @if ($selected_id > 0) disabled @endif wire:model='platform_id'
                                class="form-control">
                                <option value="Elegir" disabled>Elegir</option>
                                @foreach ($plataformas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                            @error('platform_id')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Proveedor</h6>
                            </label>
                            <select wire:model='proveedor' class="form-control">
                                <option value="Elegir" disabled>Elegir</option>
                                @foreach ($proveedores as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('proveedor')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de inicio de la cuenta</h6>
                        <div class="form-group">
                            <input type="date" wire:model="start_account" class="form-control">
                            @error('start_account')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de expiración de la cuenta</h6>
                        <div class="form-group">
                            <input type="date" wire:model="expiration_account" class="form-control">
                            @error('expiration_account')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Correo</h6>
                            </label>
                            <input @if ($mostrarCorreo == 'NO') disabled @endif type="text" wire:model="email_id"
                                class="form-control">
                            @error('email_id')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Contraseña correo</h6>
                            </label>
                            <input @if ($mostrarCorreo == 'NO') disabled @endif type="text"
                                wire:model="passwordGmail" class="form-control">
                            @error('passwordGmail')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if ($BuscarCliente != 0)
                        <div class="col-sm-12 col-md-12">
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
                                                                <th class="table-th text-withe text-center">CORREO</th>
                                                                <th class="table-th text-withe">CONTRASEÑA</th>
                                                                <th class="table-th text-withe">SELECIONAR</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($datos as $d)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->content }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->pass }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="Seleccionar('{{ $d->content }}','{{ $d->pass }}')"
                                                                            class="btn btn-warning mtmobile"
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
                        </div>
                    @endif

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Número de Perfiles para la venta</h6>
                            </label>
                            <input @if ($mostrarNumPerf == 'NO') disabled @endif type="number"
                                wire:model.lazy="number_profiles" class="form-control">
                            @error('number_profiles')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Meses que compró</h6>
                            </label>
                            <input type="number" wire:model="mesesComprar" class="form-control">
                            @error('mesesComprar')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Nombre de la cuenta Plataforma</h6>
                            </label>
                            <input @if ($mostrarNombreCuenta == 'NO') disabled @endif
                                @if ($selected_id > 0) disabled @endif type="text"
                                wire:model.lazy="nombre_cuenta" class="form-control">
                            @error('nombre_cuenta')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Contraseña cuenta Plataforma</h6>
                            </label>
                            <input type="text" wire:model.lazy="password_account" class="form-control">
                            @error('password_account')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Precio Compra Cuenta</h6>
                            </label>
                            <input type="number" wire:model.lazy="price" class="form-control">
                            @error('price')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">                
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="Store()"
                        class="btn btn-warning close-btn text-info">REGISTRAR</button>
                @else
                    <button type="button" wire:click.prevent="Update()"
                        class="btn btn-warning close-btn text-info">ACTUALIZAR</button>
                @endif
            </div>
        </div>
    </div>
</div>
