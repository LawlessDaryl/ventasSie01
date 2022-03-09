@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="row col-sm-12 col-md-12">
            <div class="col-sm-12 col-md-6">
                <h6>Nombre *</h6>
                <div class="form-group">
                    <input type="text" wire:model="name" class="form-control" placeholder="ej: Servicios, Streaming, etc">
                    @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
                </div>
            </div>        
        
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Estado *</label>
                    <select wire:model='status' class="form-control">
                        <option value="Elegir" disabled>Elegir</option>
                        <option>ACTIVO</option>
                        <option>INACTIVO</option>
                    </select>
                    @error('status') <span class="text-danger er">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        
    </div>

    <div class="col-sm-12 col-md-12">
        <div class="col-sm-12 col-md-12">
            <h6>Descripcion</h6>
            <div class="form-group">
                <input type="text" wire:model="description" class="form-control flatpickr" placeholder="ej: Modulo del departamento ........">
                @error('description') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
</div>

    @include('common.modalFooter')
