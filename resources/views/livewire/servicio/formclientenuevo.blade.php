<div wire:ignore.self class="modal fade" id="theNewClient" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Nuevo</b> | Cliente
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label><h6>Nombre *</h6></label>
                            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Fenris">
                            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label><h6>Cédula</h6></label>
                            <input type="number" wire:model.lazy="cedula" class="form-control" placeholder="12121212" maxlength="10">
                            @error('cedula') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label><h6>Celular</h6></label>
                            <input type="number" wire:model.lazy="celular" class="form-control" 
                            placeholder="ej: 77889911" maxlength="8">
                            @error('celular') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label><h6>Teléfono</h6></label>
                            <input type="number" wire:model.lazy="telefono" class="form-control" 
                            placeholder="ej: 4556677" maxlength="8">
                            @error('telefono') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label><h6>Email</h6></label>
                            <input type="text" wire:model.lazy="email" class="form-control"
                                placeholder="ej: correo@correo.com">
                            @error('email') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label><h6>Nit</h6></label>
                            <input type="number" wire:model.lazy="nit" class="form-control" placeholder="ej: 12345678">
                            @error('nit') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label><h6>Razón Social</h6></label>
                            <input type="text" wire:model.lazy="razon_social" class="form-control" placeholder="">
                            @error('razon_social') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label><h6>Procedencia</h6></label>
                            <select wire:model='procedencia' class="form-control">
                                <option value="Nuevo" selected>Nuevo</option>
                                @foreach ($procedenciaClientes as $item)
                                    @if ($item->procedencia != 'Nuevo')
                                        <option value="{{ $item->id }}">{{ $item->procedencia }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('procedencia') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                <button type="button" wire:click.prevent="StoreClient()"
                    class="btn btn-warning close-btn text-info">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
