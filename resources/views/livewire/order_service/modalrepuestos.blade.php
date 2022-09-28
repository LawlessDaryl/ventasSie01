<div wire:ignore.self class="modal fade" id="modalrepuestos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Repuestos</h5>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-12 col-sm-6 col-md-12 text-center">
                    <div class="form-group">
                        <div class="input-group">
                            <div style="border: 0.3px solid #007bff" class="input-group-prepend">
                                <span class="input-group-text input-gp">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="searchproduct" placeholder="Buscar por Nombre o Código..." class="form-control">
                        </div>
                    </div>
                </div>
            </div>



            

            @if(strlen($this->searchproduct) > 0)
            <div class="table-repuesto">
                <table>
                    <thead>
                        <tr>
                            <th class="text-center">Nombre Producto</th>
                            <th class="text-center">Nombre Destino</th>
                            <th class="text-center">Disp.</th>
                            <th class="text-center">Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listaproductos as $l)
                            <tr class="tablaserviciostr">
                                <td style="font-size: 0.8rem;">
                                    {{$l->prod_name}}
                                </td>
                                <td class="text-center" style="font-size: 0.8rem;">
                                    {{$l->dest_name}}
                                </td>
                                <td class="text-center" style="font-size: 0.8rem;">
                                    {{-- {{$data->correo ? $data->correo : "No definido" }} --}}
                                    {{$l->stock >0 ? 'Disponible':'Sin Stock'}}
                                </td>
                                @if ($l->stock >0)
                                <td class="text-center">
                                    <button
                                        wire:click="InsertarSolicitud('{{ $l->pid }}')"
                                        class="btn btn-warning mtmobile btn-sm"
                                        title="Solicitar Repuesto">
                                        {{-- <i class="fas fa-check"></i> --}}
                                        Solicitar
                                    </button>
                                </td>
                                @else

                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                    wire:click="InsertarSolicitudCompra('{{ $l->pid }}')"
                                    class="btn btn-warning mtmobile btn-sm"
                                    title="Solicitar Compra Repuesto">
                                    Solicitar Compra
                                    </a>

                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4" style="width: 15px !important;">

                                    <a href="javascript:void(0)"
                                    class="btn btn-warning mtmobile btn-sm"
                                    title="Solicitar compra">
                                    Crear y solicitar el producto: {{$this->searchproduct}}
                                    </a>




                                        


                                    </button>
                                </td>
                            </tr>
                        @endforelse





                        {{-- @foreach($listaproductos as $l)
                            <tr>
                                <td>
                                    {{$l->prod_name}}
                                </td>
                                <td class="text-center">
                                    {{$l->dest_name}}
                                </td>
                                <td class="text-center">
                                    
                                </td>
                            </tr>
                        @endforeach --}}

                    </tbody>
                </table>
            </div>

            @else
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>


            @endif
            




            <br>










            @if($this->lista_solicitudes != null)
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Lista de Solicitudes</h2>
                </div>

            </div>
                <div class="table-repuesto">
                    <table>
                      <thead>
                          <tr>
                              <th class="text-center">Nombre Producto</th>
                              <th class="text-center">Cantidad</th>
                              <th class="text-center">Tipo</th>
                              <th class="text-center">Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($lista_solicitudes->sortBy("product_id") as $l)
                          <tr>
                              <td class="text-left">
                                {{$l['product_name']}}
                                  {{-- {{ ucwords(strtolower($lc->nombre)) }} --}}
                              </td>
                              <td class="text-center">
                                {{$l['quantity']}}
                              </td>
                              <td class="text-center">
                                {{$l['type']}}
                              </td>
                              <td class="text-center">



                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button wire:click.prevent="InsertarSolicitud({{$l['product_id']}})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(10, 137, 235); color:white">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <button wire:click.prevent="DecrementarSolicitud({{$l['product_id']}},'{{$l['type']}}')" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(255, 124, 1); color:white">
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
                @endif















        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button wire:click.prevent="EnviarSolicitud()" type="button" class="btn btn-primary">Crear Solicitud</button>
        </div>
      </div>
    </div>
  </div>