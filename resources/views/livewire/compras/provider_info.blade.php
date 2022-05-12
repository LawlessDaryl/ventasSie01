<div wire:ignore.self class="modal fade" id="modal_prov" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >

            <div class="modal-header" style="background: #ffffff">
            <h5 class="modal-title text-dark">
                <b>Crear Proveedor</b>
            </h5>
            <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
         <div class="modal-body" style="background: #ffffff">
            <div class="row">
              
                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                        <label class="text-dark" >Nombre</label>
                        <input type="text" wire:model.lazy="nombre_prov" class="form-control">
                        @error('nombre_prov') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                
              

                    <div class=" col-lg-6 col-md-6 col-12 form-group">
                        <label class="text-dark" >Apellidos</label>
                        <input type="text" wire:model.lazy="apellido_prov" class="form-control">
                        @error('apellido') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                
                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                        <label class="text-dark" >Direccion</label>
                        <input type="text" wire:model.lazy="direccion_prov" class="form-control" >
                        @error('direccion') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                        <label class="text-dark" >Correo</label>
                        <input type="text" wire:model.lazy="correo_prov" class="form-control" >
                        @error('correo') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                        <label class="text-dark" >Telefono</label>
                        <input type="text" wire:model.lazy="telefono_prov" class="form-control" >
                        @error('telefono') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-6" >
                        <button type="button" wire:click.prevent="resetProv()" class="btn btn-dark close-btn text-info"
                         data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                       
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
