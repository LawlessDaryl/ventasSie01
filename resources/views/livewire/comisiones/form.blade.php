@include('common.modalHead')
<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: " maxlenght="25">
            </select>
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select wire:model.lazy="tipo" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="Cliente">Cliente</option>
                <option value="Propia">Propia</option>
            </select>
            @error('tipo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    @if ($selected_id == 0)
        @if ($tipo != 'Propia')
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Monto Afectado</label>
                    <select wire:model.lazy="monto_a" class="form-control">
                        <option value="Ninguna" disabled>Elegir</option>
                        <option value="Monto a Cobrar">Monto a Cobrar</option>
                        <option value="Monto a Registrar">Monto a Registrar</option>
                        <option value="Ambas">Ambas</option>
                    </select>
                    @error('monto_a') <span class="text-danger er">{{ $message }}</span>@enderror
                </div>
            </div>
        @endif
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Monto inicial</label>
                <input type="number" wire:model.lazy="monto_inicial" class="form-control" placeholder="ej: 100"
                    maxlenght="25">
                @error('monto_inicial') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Monto final</label>
                <input type="number" wire:model.lazy="monto_final" class="form-control" placeholder="ej: 200"
                    maxlenght="25">
                @error('monto_final') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Comisión</label>
                <input type="number" wire:model.lazy="comision" class="form-control" placeholder="ej: 8"
                    maxlenght="25">
                @error('comision') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Porcentaje</label>
                <select wire:model.lazy="porcentaje" class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    <option value="Activo">Activo</option>
                    <option value="Desactivo">Desactivo</option>
                </select>
                @error('porcentaje') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
    @endif
</div>
@include('common.modalFooter')
