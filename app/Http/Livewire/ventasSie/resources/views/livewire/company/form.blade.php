@include('common.modalHead')
<div class="row">


    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Nombre de la empresa</h6>
            <input type="text" wire:model.lazy="name" class="form-control">
            @error('name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Dirección</h6>
            <input type="text" wire:model.lazy="adress" class="form-control">
            @error('adress')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Teléfono</h6>
            <input type="number" wire:model.lazy="phone" class="form-control">
            @error('phone')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Número de NIT</h6>
            <input type="text" wire:model.lazy="nit_id" class="form-control">
            @error('nit_id')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>


</div>
@include('common.modalFooter')
