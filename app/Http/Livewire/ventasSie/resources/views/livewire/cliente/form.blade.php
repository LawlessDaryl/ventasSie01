@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Nombre</h6>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Fenris">
            @error('nombre')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Cédula</h6>
            <input type="text" wire:model.lazy="cedula" class="form-control" placeholder="12121212">
            @error('cedula')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Celular</h6>
            <input type="text" wire:model.lazy="celular" class="form-control" placeholder="ej: 79564859"
                maxlength="8">
            @error('celular')
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
            <h6>Fecha de Nacimiento</h6>
            <input type="date" wire:model="fnacim" class="form-control" placeholder="Click para elegir">
            @error('fnacim')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Dirección</h6>
            <input type="text" date-type='currency' wire:model.lazy="direccion" class="form-control"
                placeholder="ej: Av. Ayacucho">
            @error('direccion')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <h6>nit</h6>
            <input type="text" date-type='currency' wire:model.lazy="nit" class="form-control"
                placeholder="ej: 1515151515">
            @error('nit')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <h6>Razón Social</h6>
            <input type="text" date-type='currency' wire:model.lazy="razonsocial" class="form-control"
                placeholder="ej: S.A.">
            @error('razonsocial')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <h6>Procedencia</h6>
            <select wire:model='procedencia' class="form-control">
                <option value="Nuevo" selected>Nuevo</option>
                @foreach ($procedenciaClientes as $item)
                    @if ($item->procedencia != 'Nuevo')
                        <option value="{{ $item->id }}">{{ $item->procedencia }}</option>
                    @endif
                @endforeach
            </select>
            @error('procedencia')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png,image/gif,image/jpeg">
            <h6 class="custom-file-label">Imagen {{ $image }}</h6>
        </div>
    </div>
</div>

@include('common.modalFooter')
