@include('common.modalHead')
<div class="row">
    

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre del orígen</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Teléfono"
            maxlenght="25">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Saldo</label>
            <input type="text" wire:model.lazy="saldo" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('saldo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    
</div>
@include('common.modalFooter')
