
<div wire:ignore.self class="modal fade" id="modalcrearcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(252, 130, 42); color: white;">
            <h5 class="modal-title" id="exampleModalLongTitle">Crear Cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <div class="form-row">
                <div class="form-row" style="width: 99%; margin-right: 7px;">
                    <div class="col-md-12">
                        <label for="validationTooltip01"><b>Nombre Cliente</b></label>
                        <input wire:model.lazy="cliente_nombre" class="form-control" type="text" placeholder="Obligatorio">
                        @error('cliente_nombre')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="form-row" style="width: 48%; margin-right: 7px;">
                    <div class="col-md-12">
                        <label for="validationTooltip01"><b>Cédula</b></label>
                        <input wire:model.lazy="cliente_ci" class="form-control" type="text" placeholder="Opcional...">
                        {{-- @error('edit_categoriatrabajo')
                        <span class="text-danger er">{{ $message }}</span>
                        @enderror --}}
                    </div>
                </div>
                <div class="form-row" style="width: 48%">
                    <div class="col-md-12">
                        <label for="validationTooltipUsername"><b>Celular</b></label>
                        <input wire:model.lazy="cliente_celular" class="form-control" type="number" placeholder="Opcional...">
                        {{-- @error('edit_marca')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror --}}
                    </div>
                </div>
            </div>
            
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar Ventana</button>
                <button wire:click.prevent="crearcliente()" type="button" class="btn btn-primary" data-dismiss="modal">Crear y Usar</button>
            </div>
            <br>
        </div>
    </div>
</div>