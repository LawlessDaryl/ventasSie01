<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #b3a8a8">
          <h5 class="modal-title text-white">
            <b>Nuevo</b> | Servicio
          </h5>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body" style="background: #f0ecec">


<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo de Trabajo</label>
            <select wire:model.lazy="typeworkid" class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
              
                    @foreach ($work as $wor)
                        <option value="{{ $wor->id }}" selected>{{ $wor->name}}</option>
                    @endforeach
              
            </select>
            @error('typeworkid') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Categoría Producto Servicio</label>
            <select wire:model.lazy="catprodservid" class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
              
                    @foreach ($cate as $cat)
                        <option value="{{ $cat->id }}" selected>{{ $cat->nombre}}</option>
                    @endforeach
              
            </select>
            @error('catprodservid') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Detalle</label>
            <input type="text" wire:model.lazy="detalle" class="form-control" placeholder="ej: Note 7">
            @error('detalle') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Falla segun cliente</label>
            <input type="text" wire:model.lazy="falla_segun_cliente" class="form-control" placeholder="ej: Revisión">
            @error('falla_segun_cliente') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Diagnóstico</label>
            <input type="text" wire:model.lazy="diagnostico" class="form-control" placeholder="ej: Revisión">
            @error('diagnostico') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Solución</label>
            <input type="text" wire:model.lazy="solucion" class="form-control" placeholder="ej: Revisión">
            @error('solucion') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Total</label>
            <input type="number" wire:model.lazy="saldo" class="form-control" placeholder="ej: 0.0">
            @error('saldo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>A Cuenta</label>
            <input type="number" wire:model.lazy="on_account" class="form-control" placeholder="ej: 0.0">
            @error('on_account') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Saldo</label>
            <input type="number" wire:model.lazy="import" class="form-control" placeholder="ej: 0.0">
            @error('import') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Fecha Estimada</label>
            <input type="number" wire:model.lazy="fecha_estimada_entrega" class="form-control" placeholder="">
            @error('fecha_estimada_entrega') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>


</div>
<div class="modal-footer" style="background: #f0ecec">
    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
        data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
    @if ($selected_id < 1)
        <button type="button" wire:click.prevent="Store()"
            class="btn btn-dark close-btn text-info">GUARDAR</button>
    @else
        <button type="button" wire:click.prevent="Update()"
            class="btn btn-dark close-btn text-info">ACTUALIZAR</button>
    @endif


</div>
</div>
</div>
</div>
