@include('common.modalHead')
<div class="row" style="background: #f1f1f1 !important">
<div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>CI</label>
            <input type="text" wire:model.lazy="ci" class="form-control" placeholder="ej: 16265995">
            @error('ci') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>    

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Origen Transacción</label>
                <select wire:model.lazy="origen" class="form-control">
                    <option value="Elegir" disabled selected>Elegir</option>
                    <option value="" >Sistema</option>
                    <option value="TELEFONO">Teléfono</option>
                </select>
                @error('origen') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre/Código</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: 13254184151">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Motivo</label>
                <select wire:model.lazy="motivo" class="form-control">
                    <option value="Elegir" disabled selected>Elegir</option>
                    <option value="TIGO">Servicios Tigo</option>
                    <option value="COLLECTURIA">Colecturía</option>
                    <option value="TARIFA">Tarifa</option>
                    <option value="ABONO">Abono</option>
                </select>
                @error('motivo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Teléfono Solicitante</label>
            <input type="text" date-type='solicitante' wire:model.lazy="password" class="form-control"
                placeholder="ej: 76797845">
            @error('solicitante') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-8 col-md-4">
        <div class="form-group">
            <label>Monto a Cobrar</label>
            <input type="text" date-type='monto' wire:model.lazy="password" class="form-control"
                placeholder="">
            @error('monto') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-2 col-md-1 n-chk">
        <div class="form-group">
            <label class="text-center">Comisión?</label>
            <input type="checkbox" date-type='comision' wire:model.lazy="comision" class="text-center">
            @error('comision') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Observaciones</label>
            <textarea wire:model.lazy="password" class="form-control" name="" rows="5"></textarea>            
            @error('observacion') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-8 col-md-4">
        <div class="form-group">
            <label>Monto a Registrar</label>
            <label class="form-control" disabled>{{ $this->montoRegistro }}</label>
            @error('monto') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-6">
        <div class="form-group">
            <label>Fecha</label>
            <label wire:model="fecha_transaccion" class="form-control" disabled>{{$this->hora}}</label>
            @error('fecha') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
