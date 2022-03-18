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
                            <h6>Meses a renovar</h6>
                            <input type="number" wire:model="meses" class="form-control" placeholder="PerfilNetflix1">
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
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="Renovar()">Renovar
                                Perfil</a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="Vencer()">Vencer
                                Perfil</a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
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
                                                            <h6 class="text-center">No tienes perfiles de esa
                                                                plataforma</h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                    <tr>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $perfil->email }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $perfil->password_account }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $perfil->nombre_perfil }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $perfil->pin }}</h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $perfil->precioPerfil }}</h6>
                                                        </td>                                                        
                                                    </tr>
                                            </tbody>                                         
                                        </table>
                                        
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="CambiarAccount({{$perfil->id}})">CAMBIAR</a>
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
