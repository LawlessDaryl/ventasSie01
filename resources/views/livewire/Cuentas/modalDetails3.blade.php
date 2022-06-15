<div wire:ignore.self id="modal-details3" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>RENOVACION Y VENCIMIENTO DE CUENTAS</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-warning" wire:click="mostrarRenovar()">Ver datos
                                Cuenta</a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-warning" wire:click="VencerCuenta()">Vencer
                                Cuenta</a>
                        </div>
                    </div>
                    @if ($mostrarRenovar == 1)
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Email o Nombre-Cuenta</h6>
                                </label>
                                <input type="text" wire:model="email_id" class="form-control" disabled>
                                @error('email_id')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Número de Perfiles</h6>
                                </label>
                                <input type="number" wire:model.lazy="number_profiles" class="form-control">
                                @error('number_profiles')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Precio Compra Cuenta</h6>
                                </label>
                                <input type="number" wire:model.lazy="price" class="form-control"
                                    placeholder="ej: 90.0">
                                @error('price')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Contraseña cuenta Plataforma</h6>
                                </label>
                                <input type="text" wire:model.lazy="password_account" class="form-control"
                                    placeholder="ej: ntlxEmanuel">
                                @error('password_account')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h6>Fecha de inicio Cuenta</h6>
                            <div class="form-group">
                                <input disabled wire:model.lazy="start_account" type="date" min="" max=""
                                    class="form-control" placeholder="Click para elegir">
                                @error('start_account')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <h6>Fecha de expiración Cuenta</h6>
                            <div class="form-group">
                                <input disabled wire:model="expiration_account" type="date" min="" max=""
                                    class="form-control" placeholder="Click para elegir">
                                @error('expiration_account')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <h6>Fecha de inicio Nueva</h6>
                            <div class="form-group">
                                <input wire:model.lazy="start_account_new" type="date" min="" max=""
                                    class="form-control" placeholder="Click para elegir">
                                @error('start_account_new')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <h6>Fecha de expiración Nueva</h6>
                            <div class="form-group">
                                <input disabled wire:model="expiration_account_new" type="date" min="" max=""
                                    class="form-control" placeholder="Click para elegir">
                                @error('expiration_account_new')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Meses comprados</h6>
                                </label>
                                <input disabled type="number" wire:model="meses_comprados" class="form-control">
                                @error('meses_comprados')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Meses a renovar // Si va renovar la cuenta actualice los datos de la cuenta</h6>
                                </label>
                                <input type="number" wire:model="meseRenovarProv" class="form-control">
                                @error('meseRenovarProv')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="form-group text-center mt-4">
                                <a href="javascript:void(0)" class="btn btn-warning" wire:click="RenovarCuenta()">Renovar
                                    Cuenta</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
