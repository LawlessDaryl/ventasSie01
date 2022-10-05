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
                            <div style="border: 0.3px solid #02b1ce" class="input-group-prepend">
                                <span class="input-group-text input-gp">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="searchproduct" placeholder="Buscar por Nombre o Código..." class="form-control">
                        </div>
                    </div>
                </div>
            </div>


<h2>{{$searchproduct}}</h2>
<h2>{{$listacompra}}</h2>
            

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

                            @if ($listaproductos->isNotEmpty())
                            @foreach ($listaproductos as $l)
                                                        
                            <tr class="tablaserviciostr">
                                <td class="text-center">
                                    {{$l->nombreproducto}}
                                </td>
                                <td class="text-center">
                                    {{$l->nombredestino}}
                                </td>
                                <td class="text-center">
                                    {{$l->stock > 0 ? 'Disponible':'Sin Stock'}}
                                </td>
                             
                                <td class="text-center">
                                    <button
                                        wire:click="InsertarSolicitud({{ $l->pid }}, '{{ $l->did }}')"
                                        class="btn btn-warning mtmobile btn-sm"
                                        title="Solicitar Repuesto">
                                        Solicitar
                                    </button>
                                </td>
                              
                            </tr>
                            @endforeach

                                
                            @endif

                            @if ($listacompra->isNotEmpty())
                            @foreach ($listacompra as $list)
                                                            
                            <tr>

                                <td class="text-center" wire:key="foo">
                                    {{$list}}
                                </td>
                                {{-- <td class="text-center" colspan="3" wire:key="dds">
                                    <button wire:key="nm"
                                    wire:click="InsertarSolicitudCompra({{ $list->id }})"
                                    class="btn btn-warning mtmobile btn-sm"
                                    title="Solicitar Repuesto">
                                    Solicitar Compra
                                </button>
                                </td> --}}
                            </tr>
                        
                        @endforeach
                            @endif

                            @if ($listaproductos->isEmpty() and $listacompra->isEmpty())
                            <tr>
                                <td class="text-center" colspan="4" style="width: 15px !important;">
                                    <button class="btn btn-warning mtmobile btn-sm" title="Solicitar Compra" wire:click="addProducts()">
                                        Crear y solicitar el producto: {{$this->searchproduct}}
                                    </button>
                                </td>
                            </tr>
                            @endif










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
                            <th class="text-center">Producto</th>
                            <th class="text-center">Destino</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($lista_solicitudes->sortBy("orderP") as $l)
                          <tr>
                            <td class="text-left">
                              {{$l['product_name']}}
                            </td>
                            <td class="text-left">
                              {{$l['destiny_name']}}
                            </td>
                            <td class="text-center">
                            {{$l['quantity']}}
                            </td>
                            <td class="text-center">
                            {{$l['type']}}
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button wire:click.prevent="InsertarSolicitud({{$l['product_id']}},'{{$l['destiny_id']}}')" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(10, 137, 235); color:white">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <button wire:click.prevent="DecrementarSolicitud({{$l['product_id']}},'{{$l['destiny_id']}}','{{$l['type']}}')" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(255, 124, 1); color:white">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <button wire:click.prevent="EliminarSolicitud({{$l['product_id']}},'{{$l['destiny_id']}}')" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(230, 0, 0); color:white">
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