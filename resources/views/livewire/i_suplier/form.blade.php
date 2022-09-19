@include('common.modalHead')
<div class="row">
   
        <div class=" col-sm-12 col-md-6 col-lg-6 form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="nombre_prov" class="form-control" placeholder="nombre proveedor"
            maxlenght="25">
            @error('nombre_prov') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
            <label>Apellidos</label>
            <input type="text" wire:model.lazy="apellido" class="form-control" placeholder="apellidos proveedor"
            maxlenght="25">
            @error('apellido') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
        <div class=" col-sm-12 col-md-6 col-lg-6 form-group">
            <label>Direccion</label>
            <input type="text" wire:model.lazy="direccion" class="form-control" placeholder="direccion proveedor"
            maxlenght="25">
            @error('direccion') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
        <div class=" col-sm-12 col-md-6 col-lg-6 form-group">
            <label>NIT</label>
            <input type="text" wire:model.lazy="nit" class="form-control" placeholder="nit proveedor"
            maxlenght="25">
            @error('nit') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
            <label>Correo</label>
            <input type="text" wire:model.lazy="correo" class="form-control" placeholder="correo proveedor"
            maxlenght="25">
            @error('correo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 form-group">
            <label>Telefono</label>
            <input type="text" wire:model.lazy="telefono" class="form-control" placeholder="telefono proveedor"
            maxlenght="25">
            @error('telefono') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
        
        @if ($selected_id != 0)
                  
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Estado</label>
            <select wire:model='estado' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
        @endif

    
</div>
@include('common.modalFooter')