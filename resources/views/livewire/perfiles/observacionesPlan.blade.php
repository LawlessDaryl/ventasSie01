<div wire:ignore.self id="modal-observaciones" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Datos del plan</b>
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

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Perfil</h6>
                            </label>
                            <input type="text" wire:model="nameperfil" class="form-control">
                            @error('nameperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Pin</h6>
                            </label>
                            <input type="text" wire:model="pin" class="form-control">
                            @error('pin')
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
                <button type="button" wire:click.prevent="updateObserv()"
                    class="btn btn-dark close-btn text-info">ACTUALIZAR</button>
            </div>
        </div>
    </div>
</div>
