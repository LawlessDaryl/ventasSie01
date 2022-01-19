@include('common.modalHead')
<div class="row">


    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre de la caja</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: 1000" maxlenght="25">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select wire:model='estado' class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>                
                    <option value="Abierto">Abierto</option>
                    <option value="Cerrado">Cerrado</option>
                    <option value="Inactivo">Inactivo</option>                
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Sucursal</label>
            <select wire:model='sucursal_id' class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
                @foreach ($sucursales as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error('sucursal_id') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

</div>
@include('common.modalFooter')
