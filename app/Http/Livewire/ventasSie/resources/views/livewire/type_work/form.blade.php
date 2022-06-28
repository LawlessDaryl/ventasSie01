@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>
                <h6>Nombre</h6>
            </label>
            <input type="text" wire:model.lazy="name" class="form-control"
                placeholder="ej: Mantenimiento, Reparacion, Revision" maxlenght="25">
            @error('name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>
                <h6>Estado</h6>
            </label>
            <select wire:model.lazy="status" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="ACTIVE">Activo</option>
                <option value="INACTIVE">Inactivo</option>
            </select>
            @error('status')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')
