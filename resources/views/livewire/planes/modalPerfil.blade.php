<div wire:ignore.self id="Modal_perfil" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>MODIFICAR PERFIL</b>
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
                                <h6>NOMBRE PERFIL</h6>
                            </label>
                            <input wire:model.lazy="nombrePerfil" class="form-control">
                            @error('nombrePerfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>PIN</h6>
                            </label>
                            <input wire:model.lazy="pinPerfil" class="form-control">
                            @error('pinPerfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-dark"
                        wire:click.prevent="ModificarPerfil()">Modificar</a>
                </div>
            </div>
        </div>
    </div>
</div>
