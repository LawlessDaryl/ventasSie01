@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Plataforma</h6></label>
                <select wire:model='platform_id' class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    @foreach ($plataformas as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
                @error('platform_id')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Proveedor</h6></label>
                <select wire:model='proveedor' class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    @foreach ($proveedores as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                @error('proveedor')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <h6>Fecha de expiración</h6>
            <div class="form-group">
                <input type="text" wire:model="expiration_account" class="form-control flatpickr"
                    placeholder="Click para elegir">
                @error('expiration_account')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @if ($condicional != 'ocupados')
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <label><h6>Estado</h6></label>
                    <select wire:model='estado' class="form-control">
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                    </select>
                    @error('status')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endif


    </div>

    <div class="col-sm-12 col-md-6">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Correo</h6></label>
                <select wire:model='email_id' class="form-control">
                    <option value="Elegir" disabled>Elegir</option>
                    @foreach ($correos as $c)
                        <option value="{{ $c->id }}">{{ $c->content }}</option>
                    @endforeach
                </select>
                @error('email_id')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Número de Perfiles</h6></label>
                <input type="number" wire:model.lazy="number_profiles" class="form-control" placeholder="ej: 0.0">
                @error('number_profiles')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Precio Compra Cuenta</h6></label>
                <input type="number" wire:model.lazy="price" class="form-control" placeholder="ej: 90.0">
                @error('price')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label><h6>Contraseña cuenta Plataforma</h6></label>
                <input type="text" wire:model.lazy="password_account" class="form-control"
                    placeholder="ej: ntlxEmanuel">
                @error('password_account')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

    </div>
</div>

@include('common.modalFooter')
