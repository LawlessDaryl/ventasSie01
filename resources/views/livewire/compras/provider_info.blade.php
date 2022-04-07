<div wire:ignore.self class="modal fade" id="modal_prov" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        
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
                        <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="nombre proveedor"
                        maxlenght="25">
                        @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" wire:model.lazy="apellido" class="form-control" placeholder="apellidos proveedor"
                        maxlenght="25">
                        @error('apellido') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Direccion</label>
                        <input type="text" wire:model.lazy="direccion" class="form-control" placeholder="direccion proveedor"
                        maxlenght="25">
                        @error('direccion') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="text" wire:model.lazy="correo" class="form-control" placeholder="correo proveedor"
                        maxlenght="25">
                        @error('correo') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Telefono</label>
                        <input type="text" wire:model.lazy="telefono" class="form-control" placeholder="telefono proveedor"
                        maxlenght="25">
                        @error('telefono') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-6" >
                        <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                         style="background: #3b3f5c">CANCELAR</button>
                       
                    </div>
        
                    <div class="col-lg-6">
                        <button type="button" wire:click.prevent="StoreProvider()"
                        class="btn btn-dark close-btn text-info">GUARDAR</button>
                    </div>
                </div>
            </div>
            
     
    </div>
        
</div>
