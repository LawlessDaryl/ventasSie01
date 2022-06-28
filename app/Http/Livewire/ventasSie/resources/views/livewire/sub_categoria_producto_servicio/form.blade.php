@include('common.modalHead')
<div class="row">
    
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label><h6>Categoría equipo servicio</h6></label>
            <select wire:model.lazy="categoryid" class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
              
                    @foreach ($cate as $cat)
                        <option value="{{ $cat->id }}" selected>{{ $cat->nombre}}</option>
                    @endforeach
              
            </select>
            @error('categoryid') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-5">
        <div class="form-group">
            <label><h6>Nombre</h6></label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: LG,Samsung,..."
            maxlenght="25">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    {{-- <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label><h6>Precio</h6></label>
            <input type="text" wire:model.lazy="price" class="form-control" placeholder="ej: 30"
            maxlenght="25">
            @error('price') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div> --}}

    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label><h6>Estado</h6></label>
            <select wire:model.lazy="status" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="ACTIVE">Activo</option>
                <option value="INACTIVE">Inactivo</option>
            </select>
            @error('status') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
        
    
</div>
@include('common.modalFooter')
