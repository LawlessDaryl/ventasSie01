@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Nombre de la caja</h6>
            <input type="text" wire:model.lazy="nombre" class="form-control">
            @error('nombre')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Sucursal</h6>
            <select wire:model='sucursal_id' class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
                @foreach ($sucursales as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error('sucursal_id')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')
