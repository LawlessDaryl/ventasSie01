<div wire:ignore.self class="modal fade" id="theType" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Cambiar</b> | Tipo de Servicio
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Tipo de Servicio</label>
                            <select wire:model.lazy="type_service" class="form-control">
                                <option value="Elegir" disabled>Elegir</option>
                                <option value="NORMAL">NORMAL</option>
                                <option value="DOMICILIO">A DOMICILIO</option>
                            </select>
                            @error('type_service') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="ChangeTypeService()"
                        class="btn btn-warning close-btn text-info">GUARDAR</button>
                @else
                    <button type="button" wire:click.prevent="Update()"
                        class="btn btn-warning close-btn text-info">ACTUALIZAR</button>
                @endif
            </div>
        </div>
    </div>
</div>
