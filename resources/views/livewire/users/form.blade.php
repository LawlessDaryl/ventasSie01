@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <h6>Nombre</h6>
            <input type="text" wire:model.lazy="name" class="form-control">
            @error('name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <h6>Teléfono</h6>
            <input type="text" wire:model.lazy="phone" class="form-control" maxlength="8">
            @error('phone')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Email</h6>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej: correo@correo.com">
            @error('email')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            @if ($selected_id == 0)
                <h6>Contraseña</h6>
            @else
                <h6>Nueva contraseña (opcional)</h6>
            @endif
            <input type="password" date-type='currency' wire:model.lazy="password" class="form-control">
            @error('password')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Asignar rol</h6>
            <select wire:model='profile' class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('profile')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    @if ($selected_id == 0)
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <h6>Sucursal</h6>
                <select wire:model='sucursal_id' class="form-control">
                    <option value="Elegir" disabled selected>Elegir</option>
                    @foreach ($sucursales as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('sucursal_id')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endif
    <div class="col-sm-12 col-md-12">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png,image/gif,image/jpeg">
            <label class="custom-file-label">Imagen {{ $image }}</label>
        </div>
    </div>
</div>

@include('common.modalFooter')
