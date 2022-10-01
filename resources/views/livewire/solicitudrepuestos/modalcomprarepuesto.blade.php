<div wire:ignore.self class="modal fade" id="modalcomprarepuesto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #007bff; color: white;">
          <h5 class="modal-title" id="exampleModalLongTitle">
            ¿Autorizar Compra de repuestos?
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span style="color: white;" aria-hidden="true">&times;</span>
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



                <div class="row">

                  <div class="col-12">
                    <div class="table-repuesto">
                      <table>
                        <thead>
                            <tr>
                              <th class="text-center">Nombre Producto</th>
                              <th class="text-center">Precio</th>
                              <th class="text-center">Cantidad</th>
                              <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista_productos->sortBy("product_name") as $l)
                            <tr>
                              <td class="text-left">
                                {{$l['product_name']}}
                              </td>
                              <td class="text-left">
                                {{$l['price']}} Bs
                              </td>
                              <td class="text-center">
                              {{$l['quantity']}}
                              </td>
                              <td class="text-center">
                              {{$l['price'] * $l['quantity']}} Bs
                              </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>














                  <div class="col-12 text-center">
                    <h2>Precio Estimado</h2>
                    <h2><b>{{$this->total_bs}} Bs</b></h2>
                  </div>


                </div>



            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button wire:click="iniciar_compra()" type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
</div>