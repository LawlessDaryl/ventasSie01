<div wire:ignore.self class="modal fade" id="theNewClient" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #b3a8a8">
          <h5 class="modal-title text-white">
            <b>Nuevo</b> | Cliente
          </h5>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body" style="background: #f0ecec">

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Fenris">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Cédula</label>
            <input type="text" wire:model.lazy="cedula" class="form-control" placeholder="12121212">
            @error('cedula') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Celular</label>
            <input type="text" wire:model.lazy="celular" class="form-control" placeholder="ej: 79564859" maxlength="8">
            @error('celular') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej: correo@correo.com">
            @error('email') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nit</label>
            <input type="text" wire:model.lazy="nit" class="form-control" placeholder="ej: 12345678">
            @error('nit') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Razón Social</label>
            <input type="text" wire:model.lazy="razon_social" class="form-control" placeholder="">
            @error('razon_social') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    
</div>

</div>
<div class="modal-footer" style="background: #f0ecec">
    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
        data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
   
        <button type="button" wire:click.prevent="StoreClient()"
            class="btn btn-dark close-btn text-info">GUARDAR</button>
   


</div>
</div>
</div>
</div>
