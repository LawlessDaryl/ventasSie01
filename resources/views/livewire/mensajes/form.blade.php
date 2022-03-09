@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-7">

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Cuenta</label>
                <select wire:model='account_id' class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    @foreach ($cuentas as $c)
                        <option value="{{ $c->id }}">{{ $c->correo }} >> {{$c->plataforma}}</option>
                    @endforeach
                </select>
                @error('account_id') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
        
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Pin</label>
                <input type="text" wire:model.lazy="pin" class="form-control" placeholder="ej: 125145">
                @error('pin') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>       

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Observaciones</label>
                <input type="text" wire:model.lazy="observations" class="form-control" placeholder="ej: cliente ">
                @error('observations') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div> 
    </div>

    <div class="col-sm-12 col-md-5">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Estado</label>
                <select wire:model='status' class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    <option>ACTIVO</option>
                    <option>INACTIVO</option>
                </select>
                @error('status') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Disponibilidad</label>
                <select wire:model='availability' class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    <option>LIBRE</option>
                    <option>OCUPADO</option>
                </select>
                @error('availability') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <h6>Fecha fin Plan</h6>
            <div class="form-group">
                <input type="text" wire:model="expiration_plan" class="form-control flatpickr" placeholder="Click para elegir">
                @error('expiration_plan') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>        
    </div>
</div>
   

@include('common.modalFooter')
