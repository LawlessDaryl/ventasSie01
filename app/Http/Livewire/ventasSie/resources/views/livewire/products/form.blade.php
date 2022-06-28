@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-lg-7 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej:Celular Samsung Galaxy A01">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
  
    <div class="col-sm-12 col-lg-5 col-md-4">
        <div class="form-group">
            <label>Codigo</label>
            <div class="input-group-prepend mb-3">
                <input type="text" wire:model.lazy="codigo" class="form-control col-lg-7" placeholder="ej: 012020222">
                <a href="javascript:void(0)" wire:click="GenerateCode()" class="btn btn-dark p-0 m-1 col-lg-4" title="Generar Codigo">
                    <i> Generar Codigo</i>
                </a>
            </div>
            @error('codigo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Caracteristicas</label>
            <input type="text" wire:model.lazy="caracteristicas" class="form-control" placeholder="ej: Producto nuevo">
            @error('caracteristicas') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Garantia(en dias)</label>
            <input type="text" wire:model.lazy="garantia" class="form-control" placeholder="introducir dias">
            @error('garantia') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Numero de Lote</label>
            <input type="text" wire:model.lazy="lote" class="form-control" placeholder="ej: L001">
            @error('lote') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Unidad</label>
            <input type="text" list="un" name="un" wire:model.lazy="unidad" class="form-control" placeholder="ej: unidad de medida">
            <datalist id="un">
                @foreach($unidades as $unidad)
                <option value="{{ $unidad->nombre }}" selected>{{ $unidad->nombre }}</option>
                @endforeach
            </datalist>
            @error('unidad') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Marca</label>
            <input type="text" list="marc" name="marca" wire:model.lazy="marca" class="form-control" placeholder="ej: marca">
            <datalist id="marc">
                @foreach($marcas as $unidad)
                <option value="{{ $unidad->nombre }}" selected>{{ $unidad->nombre }}</option>
                @endforeach
            </datalist>
            @error('marca') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Pais de Procedencia</label>
            <input type="text" wire:model.lazy="industria" class="form-control" placeholder="ej: 012020222">
            @error('industria') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Costo</label>
            <input type="text" wire:model.lazy="costo" class="form-control" placeholder="ej: 12">
            @error('costo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
  
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Precio de venta</label>
            <input type="text" wire:model.lazy="precio_venta" class="form-control" placeholder="ej: 012020222">
            @error('precio_venta') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-lg-4 col-md-4">
        <div class="form-group">
            <label>Categoría</label>
            <div class="input-group-prepend mb-3">
                <select wire:model='selected_id2' class="form-control">
                    <option value=null selected disabled>Elegir</option>
                    @foreach ($categories as $Key => $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <span class="input-group-text input-gp">
                    <a href="javascript:void(0)" data-toggle="modal"
                        data-target="#modalCategory" class="fas fa-plus text-white"></a>
                </span>


            </div>
            @error('selected_id2') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>       
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Subcategoría</label>
            <select wire:model='categoryid' class="form-control">
                <option value= null selected disabled>Elegir</option>
                @foreach ($subcat as $Key => $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('categoryid') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Cantidad Minima</label>
                <input type="text" wire:model.lazy="cantidad_minima" class="form-control" placeholder="ej:123">
            @error('cantidad_minima') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    @if ($selected_id)
        
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Estado</label>
            <select wire:model='estado' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
        
    @endif

   

    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png,image/gif,image/jpeg">
            <label class="custom-file-label">Imagen{{ $image }}</label>
            
        </div>
    </div>
    

</div>
    @include('common.modalFooter')
    @include('livewire.products.modalcategory')

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('cat-added', msg => {
                $('#modalCategory').modal('hide'),
                noty(msg)
            });
            
        });
    
      
    </script>
    