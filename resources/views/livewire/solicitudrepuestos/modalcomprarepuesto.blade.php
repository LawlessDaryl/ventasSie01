<div wire:ignore.self class="modal fade" id="modalcomprarepuesto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #02b1ce; color: white;">
          <h5 class="modal-title" id="exampleModalLongTitle">
            ¿Autorizar Compra de Repuestos?
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span style="color: white;" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">




          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">

                  <div class="col-6 col-sm-4">

                    <label for="exampleFormControlInput1"><b>Será Comprado Por:</b></label>
                    <select wire:model="usuario_id" class="form-control" aria-label="Default select example">
                      <option value="Elegir">Seleccione Usuario</option>
                      @foreach($lista_usuarios as $u)
                      <option value="{{$u->id}}">{{ucwords(strtolower($u->name))}}</option>
                      @endforeach
                    </select>
                    @error('usuario_id')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror

                  </div>

                  <div class="col-6 col-sm-4">

                    <label for="exampleFormControlTextarea1"><b>Monto Bs Compra</b></label>
                    <input type="number" wire:model.lazy="monto_bs_compra" placeholder="Ingrese Bs para la compra..." class="form-control">
                    @error('monto_bs_compra')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror

                  </div>
                  
                  <div class="col-6 col-sm-4">

                    <label for="exampleFormControlInput1"><b>Cartera</b></label>
                    <select wire:model="cartera_id" class="form-control" aria-label="Default select example">
                        <option value="Elegir">Lista de Carteras en su Caja</option>
                        @foreach($lista_carteras as $c)
                        <option value="{{$c->idcartera}}">{{ucwords(strtolower($c->nombrecartera))}}</option>
                        @endforeach
                    </select>
                    @error('cartera_id')
                      <span class="text-danger er">{{ $message }}</span>
                    @enderror

                  </div>


                </div>
              </div>
            </div>

            <br>


            <div class="row">
              <div class="table-1">
                <table>
                  <thead>
                      <tr class="text-center">
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($lista_productos->sortBy("product_name") as $l)
                      <tr>
                        <td class="text-left">
                          {{$l['product_name']}}
                        </td>
                        <td class="text-center">
                        {{$l['quantity']}}
                        </td>
                        <td class="text-right">
                          {{ number_format($l['price'], 2)}}
                        </td>
                        <td class="text-right">
                          {{ number_format($l['price'] * $l['quantity'], 2)}}
                        </td>
                        <td>
                          <div class="btn-group" role="group" aria-label="Basic example">
                            <button wire:click.prevent="InsertarSolicitud({{$l['product_id']}})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(10, 137, 235); color:white">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                            <button wire:click.prevent="DecrementarSolicitud({{$l['product_id']}})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(255, 124, 1); color:white">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <button wire:click.prevent="EliminarSolicitud({{$l['product_id']}})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(230, 0, 0); color:white">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>



              <div class="col-12 text-center">
                <h2>Precio Total Estimado</h2>
                <h2><b>{{$this->total_bs}} Bs</b></h2>
              </div>



            </div>





          </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button wire:click="iniciar_compra()" type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
</div>