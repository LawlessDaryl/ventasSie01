@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label><h6>Nombre</h6></label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Fenris">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label><h6>Teléfono</h6></label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="ej: 79564859" maxlength="8">
            @error('phone') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label><h6>Email</h6></label>
            <input type="text" wire:model.lazy="mail" class="form-control" placeholder="ej: correo@correo.com">
            @error('mail') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label><h6>Dirección</h6></label>
            <input type="text" wire:model.lazy="address" class="form-control" placeholder="ej: Cochabamba">
            @error('address') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label><h6>Estado</h6></label>
            <select wire:model.lazy="status" class="form-control">
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
            @error('status') <span class="text-danger er">{{ $message }}</span>@enderror
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
