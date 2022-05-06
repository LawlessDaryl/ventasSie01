<div wire:ignore.self id="modal-edit-combos" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>EDICION DE PERFILES DEL COMBO</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Nombre Cliente</h6>
                            </label>
                            <input type="text" wire:model="nombreCliente" class="form-control">
                            @error('nombreCliente')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
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

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Fecha inicio del plan</h6>
                            </label>
                            <input type="date" wire:model="start_account" class="form-control">
                            @error('start_account')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Fecha fin del plan</h6>
                            </label>
                            <input type="date" wire:model="expiration_account" class="form-control">
                            @error('expiration_account')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>{{ $plataforma1Nombre }}</h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>NOMBRE PERFIL</h6>
                            <input type="text" wire:model="perfil1COMBO" class="form-control">
                            @error('nombreCliente')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>PIN PERFIL</h6>
                            <input type="text" wire:model="PIN1COMBO" class="form-control">
                            @error('celular')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>{{ $plataforma2Nombre }}</h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>NOMBRE PERFIL</h6>
                            <input type="text" wire:model="perfil2COMBO" class="form-control">
                            @error('nombreCliente')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>PIN PERFIL</h6>
                            <input type="text" wire:model="PIN2COMBO" class="form-control">
                            @error('celular')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>{{ $plataforma3Nombre }}</h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>NOMBRE PERFIL</h6>
                            <input type="text" wire:model="perfil3COMBO" class="form-control">
                            @error('nombreCliente')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>PIN PERFIL</h6>
                            <input type="text" wire:model="PIN3COMBO" class="form-control">
                            @error('celular')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>Observaciones</h6>
                            <textarea wire:model.lazy="observations" class="form-control" name="" rows="5"></textarea>
                            @error('observations')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <span>
                                <img src="{{ asset('storage/planesComprobantes/' . $comprobante) }}"
                                    alt="No tiene comprobante" height="500" width="750">
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="comprobante"
                                accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label">Comprobante {{ $comprobante }}</label>
                        </div>
                    </div>
                </div>
                <div class="row">
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
