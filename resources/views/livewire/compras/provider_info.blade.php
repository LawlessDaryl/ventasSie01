<div wire:ignore.self class="modal fade" id="modal_prov" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" >

            <div class="modal-header" style="background: #414141">
            <h5 class="modal-title text-white">
                <b>Crear Proveedor</b>
            </h5>
            <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
         <div class="modal-body" style="background: #f0ecec">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-12">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" wire:model.lazy="nombre_prov" class="form-control" placeholder="nombres proveedor"
                        >
                        @error('nombre_prov') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" wire:model.lazy="apellido_prov" class="form-control" placeholder="apellidos proveedor"
                       >
                        @error('apellido_prov') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Direccion</label>
                        <input type="text" wire:model.lazy="direccion_prov" class="form-control" placeholder="direccion proveedor"
                        >
                        @error('direccion_prov') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="text" wire:model.lazy="correo_prov" class="form-control" placeholder="correo proveedor"
                        >
                        @error('correo_prov') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Telefono</label>
                        <input type="text" wire:model.lazy="telefono_prov" class="form-control" placeholder="telefono proveedor"
                        >
                        @error('telefono_prov') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-6" >
                        <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                         style="background: #3b3f5c">CANCELAR</button>
                       
                    </div>
        
                    <div class="col-lg-6">
                        <button type="button" wire:click.prevent="addProvider()"
                        class="btn btn-dark close-btn text-info">GUARDAR</button>
                    </div>
                </div>
            </div>
            
     
    </div>
        </div>
        
</div>
