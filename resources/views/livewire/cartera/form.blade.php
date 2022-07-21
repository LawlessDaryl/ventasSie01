@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Nombre de la cartera</h6>
            <input type="text" wire:model.lazy="nombre" class="form-control">
            @error('nombre')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Descripción</h6>
            <input type="text" wire:model.lazy="descripcion" class="form-control">
            @error('descripcion')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Tipo</h6>
            <select wire:model='tipo' class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
                <option value="Telefono">Telefono</option>
                <option value="Sistema">Sistema</option>
                <option value="CajaFisica">Caja Fisica</option>
                <option value="Banco">Banco</option>
            </select>
            @error('tipo')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    @if ($variable == 1)
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <h6>Número de telefono</h6>
                <input type="number" wire:model.lazy="telefonoNum" class="form-control">
                @error('telefonoNum')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endif
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Caja</h6>
            <select wire:model='caja_id' class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
                @foreach ($cajas as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                @endforeach
            </select>
            @error('caja_id')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>
@include('common.modalFooter')
