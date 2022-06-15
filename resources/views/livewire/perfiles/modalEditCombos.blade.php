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

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center mt-4">
                            <a href="javascript:void(0)" class="btn btn-warning"
                                wire:click.prevent="UpdateCombo()">Actualizar
                                datos</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
