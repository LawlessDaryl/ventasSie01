<div>
    <div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary" style="background: #414141">
              <h5 class="modal-title text-white">
                    Datos del Repuesto
              </h5>
              <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
    
<div class="row">
    <div class="col-sm-12 col-lg-7 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej:Celular Samsung Galaxy A01">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
  
    <div class="col-sm-12 col-lg-5 col-md-4">
        <div class="form-group row">
            <label class="col-lg-12">Codigo</label>
           
                <input type="text" wire:model.lazy="codigo" class="form-control col-lg-6" placeholder="ej: 20202225">
                <a href="javascript:void(0)" wire:click="GenerateCode()" class="btn btn-info m-0 p-l-0 p-r-0 col-lg-6" title="Generar Codigo">
                   <i class="fas fa-barcode"></i> Generar Codigo
                </a>
        
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
            <label>Unidad de Medida</label>
            <div class="input-group-prepend mb-3">
                <select wire:model.lazy='unidad' class="form-control">
                    <option value=null selected disabled>Elegir</option>
                    @foreach($unidades as $unidad)
                    <option value="{{ $unidad->nombre }}" selected>{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
                
                    <a href="javascript:void(0)" class="btn btn-dark pl-2 pr-2" data-toggle="modal" title="Agregar Unidad"
                        data-target="#modalUnidad"> <i class="fas fa-plus text-white"></i>
                    </a>
            </div>
            @error('unidad') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Marca</label>
            <div class="input-group-prepend mb-3">
                <select wire:model.lazy='marca' class="form-control">
                    <option value=null selected disabled>Elegir</option>
                    @foreach($marcas as $unidad)
                    <option value="{{ $unidad->nombre }}" selected>{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
                
                    <a href="javascript:void(0)" class="btn btn-dark pl-2 pr-2" data-toggle="modal" title="Agregar Marca"
                        data-target="#modalMarca"> <i class="fas fa-plus text-white"></i> </a>
            </div>
            @error('marca') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Industria</label>
            <input type="text" wire:model.lazy="industria" class="form-control" placeholder="ej: China">
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
            <input type="text" wire:model.lazy="precio_venta" class="form-control" placeholder="ej: 24">
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
                
                    <a href="javascript:void(0)" class="btn btn-dark pl-2 pr-2" data-toggle="modal" title="Agregar categoria"
                        data-target="#modalCategory"> <i class="fas fa-plus text-white"></i> </a>
            </div>
            @error('selected_id2') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>       
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Subcategoría</label>
            <div class="input-group-prepend mb-3">

                <select wire:model='categoryid' class="form-control">
                    <option value= null selected disabled>Elegir</option>
                    @foreach ($subcat as $Key => $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @if ($selected_id2 != null)
                    
                <a href="javascript:void(0)" class="btn btn-dark pl-2 pr-2" data-toggle="modal" title="Agregar subcategoria"
                data-target="#modalSubcategory"> <i class="fas fa-plus text-white"></i> </a>
                @endif
            </div>
            @error('categoryid') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Cantidad Minima</label>
                <input type="text" wire:model.lazy="cantidad_minima" class="form-control" placeholder="ej: 5">
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

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Control Lote</label>
            <select wire:model='cont_lote' class="form-control">
                <option value="null" disabled>Elegir</option>
                <option value="MANUAL">Seleccion Manual</option>
                <option value="AUTOMATICO">FIFO automatico</option>
            </select>
            @error('cont_lote') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <label> <b> Subir Imagen</b></label>
        <div class="form-group custom-file mt-4 p-1">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png,image/gif,image/jpeg">
            <label class="custom-file-label">Imagen{{ $image }}</label>
            
        </div>
    </div>
    

</div>
    @include('common.modalFooter')
    @include('livewire.products.modalcategory')
    @include('livewire.products.modalunidad')
    @include('livewire.products.modalmarca')
    @include('livewire.products.modalsubcategory')
</div>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('cat-added', msg => {
                $('#modalCategory').modal('hide'),
                noty(msg)
            });
            window.livewire.on('marca-added', msg => {
                $('#modalMarca').modal('hide'),
                noty(msg)
            });
            window.livewire.on('unidad-added', msg => {
                $('#modalUnidad').modal('hide'),
                noty(msg)
            });
            window.livewire.on('subcat-added', msg => {
                $('#modalSubcategory').modal('hide'),
                noty(msg)
            });
            
        });
    
      
    </script>
    