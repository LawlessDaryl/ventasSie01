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
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>
                                <h6> <strong> Si va a renovar la cuenta puede actualizar los
                                        datos </strong></h6>
                            </label>
                        </div>
                    </div>

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

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Número de perfiles</h6>
                            </label>
                            <input type="number" wire:model.lazy="number_profiles" class="form-control" disabled>
                            @error('number_profiles')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Meses que compró</h6>
                            </label>
                            <input disabled type="number" wire:model="meses_comprados" class="form-control">
                            @error('meses_comprados')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de inicio cuenta</h6>
                        <div class="form-group">
                            <input disabled wire:model.lazy="start_account" type="date" min="" max=""
                                class="form-control" placeholder="Click para elegir">
                            @error('start_account')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de expiración cuenta</h6>
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
                            <input wire:model.lazy="start_account_new" type="date" min="" max="" class="form-control"
                                placeholder="Click para elegir">
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
                    
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Precio Compra</h6>
                            </label>
                            <input type="number" wire:model.lazy="price" class="form-control" placeholder="ej: 90.0">
                            @error('price')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Contraseña</h6>
                            </label>
                            <input type="text" wire:model.lazy="password_account" class="form-control"
                                placeholder="ej: ntlxEmanuel">
                            @error('password_account')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
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
                                <h6>Meses a renovar</h6>
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

                </div>
            </div>
        </div>
    </div>
</div>
