@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre de la cartera</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: 1000" maxlenght="25">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Descripción</label>
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: 1000"
                maxlenght="25">
            @error('descripcion') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select wire:model='tipo' class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
                <option value="Telefono">Telefono</option>
                <option value="Sistema">Sistema</option>
                <option value="Cajafisica">Caja Fisica</option>

            </select>
            @error('tipo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    @if($variable==1)
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Número de telefono</label>
            <input type="text" wire:model.lazy="telefonoNum" class="form-control" placeholder="ej: 67878455"
                maxlenght="25">
            @error('telefonoNum') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    @endif
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Caja</label>
            <select wire:model='caja_id' class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
                @foreach ($cajas as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                @endforeach
            </select>
            @error('caja_id') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

</div>
@include('common.modalFooter')
