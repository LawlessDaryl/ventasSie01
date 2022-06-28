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
    
</div>
@include('common.modalFooter')