<div wire:ignore.self class="modal fade" id="modalCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #414141">
          <h5 class="modal-title text-white">
              <b>Crear Categoria</b>
          </h5>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body" style="background: #f0ecec">

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
             <label> Nombre </label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Impresoras">
        </div>
        @error('name')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label>Descripcion</label>
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: breve descripcion">
        </div>
        @error('descripcion')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
</div>
</div>
        <div class="modal-footer" style="background: #f0ecec">
            <button type="button" wire:click.prevent="resetCategory()" class="btn btn-dark close-btn text-info"
                data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
         
                <button type="button" wire:click.prevent="StoreCategory()"
                    class="btn btn-dark close-btn text-info">GUARDAR</button>
            </div>
        </div>
   </div>
</div>
