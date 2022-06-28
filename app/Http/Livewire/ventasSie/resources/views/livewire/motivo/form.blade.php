@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Nombre del motivo</h6>
            <input type="text" wire:model.lazy="nombre" class="form-control" maxlenght="25">
            @error('nombre')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Tipo</h6>
            <select wire:model.lazy="tipo" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="Retiro">Retiro</option>
                <option value="Abono">Abono</option>
            </select>
            @error('tipo')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')
