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
            <input type="number" wire:model.lazy="telefono" class="form-control">
            @error('telefono')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Celular</h6>
            <input type="number" wire:model.lazy="celular" class="form-control">
            @error('celular')
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
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Empresa</h6>
            <select wire:model='company_id' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($empresas as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error('company_id')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>


</div>
@include('common.modalFooter')
