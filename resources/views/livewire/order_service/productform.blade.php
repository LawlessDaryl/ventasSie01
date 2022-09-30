<div>
    <div wire:ignore.self class="modal fade" id="modalProduct" tabindex="-1" role="dialog">
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
    <div class="col-sm-12 col-lg-5 col-md-8">
        <div class="form-group">
            <label>Nombre del Repuesto</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="ej:Celular Samsung Galaxy A01">
            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
            <label>Agregar Caracteristicas</label>
            <input type="text" wire:model.lazy="caracteristicas" class="form-control" placeholder="ej: Producto nuevo">
            @error('caracteristicas') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4 col-lg-3">
        <div class="form-group">
            <label>Precio Aprox. del Rep.</label>
            <input type="text" wire:model.lazy="precio_venta2" class="form-control" placeholder="ej: 150">
            @error('precio_venta2') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>  
    </div>
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="row justify-content-center">

        <button class="btn btn-lg btn-success" wire:click="$toggle('show_more')">Mostrar Mas</button>
    </div>
  </div>

    @if ($show_more === true)
        
    {{-- <div class="col-sm-12 col-lg-5 col-md-4">
        <div class="form-group">
            <label class="col-lg-12">Agregar un codigo de repuesto</label>
            <div class="input-group-prepend mb-3">
                <input type="text" wire:model.lazy="codigo" class="form-control" placeholder="ej: 20202225">
                <a href="javascript:void(0)" wire:click="GenerateCode()" class="btn btn-info text-center" title="Generar Codigo">
                   <i class="fas fa-barcode"></i>
                </a>
                </div>
        
            @error('codigo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div> --}}

   


    <div class="col-sm-12 col-md-4 col-lg-5 ">
        <div class="form-group">
            <label>Unidad de Medida</label>
            <div class="input-group-prepend mb-3">
                @if (isset($unidades))
                <select wire:model.lazy='unidad' class="form-control">
                    <option value=null selected disabled>Elegir</option>
                    @foreach($unidades as $unidad)
                    <option value="{{ $unidad->nombre }}" selected>{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
                @endif
            </div>
            @error('unidad') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-5">
        <div class="form-group">
            <label>Marca</label>
            <div class="input-group-prepend mb-3">
                @if (isset($marcasp))
                    
                <select wire:model.lazy='marca2' class="form-control">
                    <option value=null selected disabled>Elegir</option>
                    @foreach($marcasp as $unidad)
                    <option value="{{ $unidad->nombre }}" selected>{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
                @endif
       
            </div>
            @error('marca') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-5">
        <div class="form-group">
            <label>Industria</label>
            <input type="text" wire:model.lazy="industria" class="form-control" placeholder="ej: China">
            @error('industria') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
  
    @endif


</div>

</div>
<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    <button type="button" class="btn btn-success" wire:click="guardarProducto()">Guardar Datos</button>
   
</div>
</div>
</div>
</div>
</div>

    