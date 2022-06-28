@include('common.modalHead')
<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit"></span>
                </span>
            </div>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: TV,PORTATIL,CELULAR">
        </div>
        @error('nombre')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 mt-3">
        <div class="form-group">
            <label><h6>Estado</h6></label>
            <select wire:model.lazy="estado" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="ACTIVO">Activo</option>
                <option value="INACTIVO">Inactivo</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
@include('common.modalFooter')
