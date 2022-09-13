<!-- Modal -->
<div wire:ignore.self class="modal fade" id="modalnuevacategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ee761c; color: white;">
          <h5 class="modal-title" id="exampleModalLongTitle">Nueva Categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Nombre Categoria</label>
                  <input wire:model.lazy="nombrecategoria" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Ingrese nombre de la categoria">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Detalle Categoria</label>
                  <textarea wire:model.lazy="detallecategoria" placeholder="Ingrese las caracteristicas de la categoria" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button wire:click="save()" type="button" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </div>
    </div>
  </div>