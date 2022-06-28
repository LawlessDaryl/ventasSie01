@include('common.modalHead')
<div class="row">
    
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select wire:model='type' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option>BILLETE</option>
                <option>MONEDA</option>
                <option>OTRO</option>
            </select>
            @error('type') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Value</label>
            <input type="number" wire:model.lazy="value" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('value') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png,image/gif,image/jpeg">
            <label class="custom-file-label">Imagen {{ $image }}</label>

        </div>
    </div>
</div>
@include('common.modalFooter')
