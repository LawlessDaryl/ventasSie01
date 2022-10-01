<div wire:ignore.self class="modal fade" id="modalcomprarepuesto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #02b1ce; color: white;">
          <h5 class="modal-title" id="exampleModalLongTitle">
            ¿Autorizar Compra de este repuesto?
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Será Comprado Por:</label>
                    <select wire:model="tipo" class="form-control" aria-label="Default select example">
                      <option value="Elegir">Seleccione Usuario</option>
                      @foreach($lista_usuarios as $u)
                      <option value="{{$u->id}}">{{ucwords(strtolower($u->name))}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Monto Dado para la Compra</label>
                    <input type="number" wire:model.lazy="detallecategoria" placeholder="Ingrese Bs" class="form-control">
                </div>
                {{-- <div class="form-group">
                <label for="exampleFormControlTextarea1">Monto Dado para la Compra</label>
                <textarea wire:model.lazy="detallecategoria" placeholder="Ingrese las caracteristicas de la categoria" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div> --}}
                <div class="form-group">
                <label for="exampleFormControlInput1">Cartera de Donde Sale el Dinero</label>
                <select wire:model="tipo" class="form-control" aria-label="Default select example">
                    <option value="Elegir">Seleccione Cartera</option>
                    @foreach($lista_carteras as $c)
                    <option value="{{$c->carteraid}}">{{ucwords(strtolower($c->nombrecartera))}}</option>
                    @endforeach
                </select>
                </div>
                @error('tipo')
                  <span class="text-danger er">{{ $message }}</span>
                @enderror
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button wire:click="save()" type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
</div>