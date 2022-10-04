<!-- Modal -->
<div wire:ignore.self class="modal fade" id="modalnuevacategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #02b1ce; color: white;">
          <h5 class="modal-title" id="exampleModalLongTitle">
            @if($this->categoria_id == null)
            Crear Categoria
            @else
            Actualizar Categoria
            @endif
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Nombre Categoria</label>
                  <input wire:model.lazy="nombrecategoria" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Ingrese nombre de la categoria">
                  @error('nombrecategoria')
                    <span class="text-danger er">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Detalle Categoria</label>
                  <textarea wire:model.lazy="detallecategoria" placeholder="Ingrese las caracteristicas de la categoria" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Tipo</label>
                  <select wire:model="tipo" class="form-control" aria-label="Default select example">
                    <option value="Elegir">Seleccione a donde irá la categoria</option>
                    <option value="INGRESO">INGRESO</option>
                    <option value="EGRESO">EGRESO</option>
                  </select>
                </div>
                @error('tipo')
                  <span class="text-danger er">{{ $message }}</span>
                @enderror
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          @if($this->categoria_id == null)
          <button wire:click="save()" type="button" class="btn btn-primary">Guardar Cambios</button>
          @else
          <button wire:click="update()" type="button" class="btn btn-primary">Actualizar Cambios</button>
          @endif
        </div>
      </div>
    </div>
</div>