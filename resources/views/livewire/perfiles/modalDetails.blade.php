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
                            <label>Meses a renovar</label>
                            <input type="number" wire:model="meses" class="form-control"
                                placeholder="PerfilNetflix1">
                            @error('meses')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de expiración Actual</h6>
                        <div class="form-group">
                            <input type="date" wire:model="expirationActual" class="form-control">
                            @error('expirationActual')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <h6>Fecha de expiración nueva</h6>
                        <div class="form-group">
                            <input type="date" wire:model="expirationNueva" class="form-control">
                            @error('expirationNueva')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Tipo de pago</label>
                            <select wire:model="tipopago" class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                <option value="EFECTIVO">EFECTIVO</option>
                                <option value="Banco">CUENTA BANCARIA</option>
                                <option value="TigoStreaming">TIGO MONEY</option>
                            </select>
                            @error('tipopago')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark" 
                            wire:click.prevent="Renovar()">Renovar Perfil</a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-dark"
                                wire:click.prevent="Vencer()">Vencer Perfil</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
