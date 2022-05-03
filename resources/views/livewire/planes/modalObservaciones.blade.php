<div wire:ignore.self id="Modal_Observaciones" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Informacion sobre el plan</b>
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
                            <input type="text" wire:model="nombre" class="form-control">
                            @error('nombre')
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
                                <h6>Fecha inicio plan</h6>
                            </label>
                            <input type="date" wire:model="fecha_inicio" class="form-control">
                            @error('fecha_inicio')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Fecha fin plan</h6>
                            </label>
                            <input type="date" wire:model="expiration_plan" class="form-control">
                            @error('expiration_plan')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if ($condicional == 'perfiles')
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Perfil</h6>
                                </label>
                                <input type="text" wire:model="PerfilCliente" class="form-control">
                                @error('PerfilCliente')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Pin</h6>
                                </label>
                                <input type="text" wire:model="PinCliente" class="form-control">
                                @error('PinCliente')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>
                                <h6>Observaciones</h6>
                            </label>
                            <textarea wire:model.lazy="observaciones" class="form-control" name="" rows="5"></textarea>
                            @error('observaciones')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="Modificar()">Modificar</a>
                </div>
            </div>
        </div>
    </div>
</div>
