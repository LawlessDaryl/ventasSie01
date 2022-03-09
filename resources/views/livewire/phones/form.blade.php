@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">

        <div class="col-sm-12 col-md-12">
            <h6>Nombre</h6>
            <div class="form-group">
                <input type="text" wire:model="name" class="form-control" placeholder="Ej: Telefono sucursal .........">
                @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <h6>Teléfono *</h6>
            <div class="form-group">
                <input type="text" wire:model="phone" class="form-control" placeholder="Ej: 76789745">
                @error('phone') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <h6>Descripción</h6>
            <div class="form-group">
                <input type="text" wire:model="description" class="form-control" placeholder="Ej: Teléfono para.........">
                @error('description') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>      

    </div>

    <div class="col-sm-12 col-md-6">

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
                <label>Sucursal</label>
                <select wire:model='sucursal_id' class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    @foreach ($sucursals as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('sucursal_id') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>   
        
    </div>
</div>

    @include('common.modalFooter')
