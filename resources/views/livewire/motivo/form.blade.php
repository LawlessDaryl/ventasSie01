@include('common.modalHead')
<div class="row">
    

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre del motivo</label>
            <input type="text" wire:model.lazy="nombre_motivo" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('nombre_motivo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select wire:model.lazy="tipo" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="Retiro">Retiro</option>
                <option value="Abono">Abono</option>
            </select>
            @error('tipo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    
</div>
@include('common.modalFooter')
