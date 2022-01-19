@include('common.modalHead')
<div class="row">
    

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre de la empresa</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" wire:model.lazy="adress" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('adress') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" wire:model.lazy="telefono" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('telefono') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Celular</label>
            <input type="text" wire:model.lazy="celular" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('celular') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Número de NIT</label>
            <input type="text" wire:model.lazy="nit_id" class="form-control" placeholder="ej: 1000"
            maxlenght="25">
            @error('nit_id') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Empresa</label>
            <select wire:model='company_id' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($empresas as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error('company_id') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    
    
</div>
@include('common.modalFooter')
