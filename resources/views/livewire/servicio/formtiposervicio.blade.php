@include('common.modalHead')
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
@include('common.modalFooter')
