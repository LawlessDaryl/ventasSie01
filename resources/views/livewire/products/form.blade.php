@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Curso Laravel">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Código</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Caracteristicas</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Codigo de barras</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Lote de produccion</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Unidad</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Marca</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Industria</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Precio de venta</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
  
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Cantidad Míninma</label>
            <input type="number" wire:model.lazy="alerts" class="form-control" placeholder="ej: 0.0">
            @error('alerts') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Categoría</label>
            <select wire:model='categoryid' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('categoryid') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Subcategoria</label>
            <select wire:model='categoryid' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('categoryid') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png,image/gif,image/jpeg">
            <label class="custom-file-label">Imagen {{ $image }}</label>
            
        </div>
    </div>

    @include('common.modalFooter')
