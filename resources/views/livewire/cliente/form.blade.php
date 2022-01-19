@include('common.modalHead')
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
            <label>Fecha de Nacimiento</label>            
                <input type="text" wire:model="fnacim" class="form-control flatpickr" placeholder="Click para elegir">           
            @error('fnacim') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>nit</label>
            <input type="text" date-type='currency' wire:model.lazy="nit" class="form-control"
                placeholder="ej: 1515151515">
            @error('nit') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" date-type='currency' wire:model.lazy="direccion" class="form-control"
                placeholder="ej: Av. Ayacucho">
            @error('direccion') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Razón Social</label>
            <input type="text" date-type='currency' wire:model.lazy="razonsocial" class="form-control"
                placeholder="ej: S.A.">
            @error('razonsocial') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png,image/gif,image/jpeg">
            <label class="custom-file-label">Imagen {{ $image }}</label>            
        </div>
    </div>
</div>

@include('common.modalFooter')
