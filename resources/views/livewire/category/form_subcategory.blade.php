<div wire:ignore.self class="modal fade" id="theModal_s" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white">
         
              <b>{{$componentSub}}</b> | {{$selected_id > 0 ? 'EDITAR':'CREAR'}}
          </h5>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body">

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            
             <label> Nombre </label>
            
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Impresoras">
        </div>
        @error('name')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    
</div>
<div class="row">

  
<div class="col-lg-12">
    <div class="form-group">
      
           
                <label>Descripcion</label>
            
        
        <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: breve descripcion de la subcategoria">
    </div>
    @error('descripcion')<span class="text-danger er">{{ $message }}</span> @enderror
</div>
</div>

</div>
<div class="modal-footer">
    <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning"
        data-dismiss="modal" style="background: #3b3f5c">Cancelar</button>
    @if ($selected_id < 1)
        <button type="button" wire:click.prevent="Store_Subcategoria()"
        class="btn btn-warning">Guardar</button>
    @else
        <button type="button" wire:click.prevent="Update()"
        class="btn btn-warning">Actualizar</button>
    @endif


</div>
</div>
</div>
</div>

