@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-7">

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Nombre Perfil</h6></label>
                <input type="text" wire:model.lazy="nameperfil" class="form-control" placeholder="ej: 125145">
                @error('nameperfil') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Pin</h6></label>
                <input type="text" wire:model.lazy="pin" class="form-control" placeholder="ej: 125145">
                @error('pin') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Observaciones</h6></label>
                <input type="text" wire:model.lazy="observations" class="form-control" placeholder="ej: cliente ">
                @error('observations') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    {{-- <div class="col-sm-12 col-md-5">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Estado</label>
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
                <label><h6>Disponibilidad</label>
                <select wire:model='availability' class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    <option>LIBRE</option>
                    <option>OCUPADO</option>
                </select>
                @error('availability') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

    </div> --}}
</div>


@include('common.modalFooter')
