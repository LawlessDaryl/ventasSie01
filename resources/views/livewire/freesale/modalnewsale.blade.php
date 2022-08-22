<div class="modal fade" id="newsale" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Nueva Venta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-row">
                  <div class="col">
                    <h5><b>Nombre</b></h5>
                    <input type="text" class="form-control" placeholder="Nombre Cliente">
                  </div>
                  <div class="col">
                    <h5><b>Telefono</b></h5>
                    <input type="number" class="form-control" placeholder="Teléfono o Celular">
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col">
                    <h5><b>ID</b></h5>
                    <input type="text" class="form-control" placeholder="Id">
                  </div>
                  <div class="col">
                    <h5><b>Alias</b></h5>
                    <input type="text" class="form-control" placeholder="Alias">
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col">
                    <h5><b>Plan</b></h5>
                    <select wire:model="freeplan_id" class="form-control">
                        @foreach($listplans as $item)
                        <option value="{{$item->id}}">{{$item->nameplan}} - {{$item->cost}} Bs</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <h5><b>Criptomonedas</b></h5>
                    <input type="text" class="form-control" placeholder="Criptomonedas...">
                  </div>
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar todo</button>
          <button type="button" class="btn btn-primary">Guardar Venta</button>
        </div>
      </div>
    </div>
  </div>