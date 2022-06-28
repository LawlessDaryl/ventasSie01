@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-7">

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>
                    <h6>Nombre Perfil</h6>
                </label>
                <input type="text" wire:model.lazy="nameperfil" class="form-control" placeholder="ej: 125145">
                @error('nameperfil')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>
                    <h6>Pin</h6>
                </label>
                <input type="text" wire:model.lazy="pin" class="form-control" placeholder="ej: 125145">
                @error('pin')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>

    </div>
</div>


@include('common.modalFooter')
