@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Nombre del orígen</h6>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Teléfono" maxlenght="25">
            @error('nombre')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')
