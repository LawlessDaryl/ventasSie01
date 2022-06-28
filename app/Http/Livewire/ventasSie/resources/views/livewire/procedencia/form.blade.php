@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <h6>Procedencia</h6>
            <input type="text" wire:model.lazy="procedencia" class="form-control" placeholder="ej: Curso Laravel">
            @error('procedencia')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <h6>Estado</h6>
            <select wire:model='estado' class="form-control">
                <option value="Elegir" selected disabled>Elegir</option>
                <option value="Activo">Activo</option>
                <option value="Desactivado">Desactivado</option>

            </select>
            @error('estado')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')
