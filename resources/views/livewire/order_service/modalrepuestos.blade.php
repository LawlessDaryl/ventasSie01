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
            <div class="table-wrapper form-group">
                <table class="tablaservicios" style="min-width: 400px;">
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
                            <tr>
                                <td>
                                    {{$l->prod_name}}
                                </td>
                                <td class="text-center">
                                    {{$l->dest_name}}
                                </td>
                                <td class="text-center">
                                    {{-- {{$data->correo ? $data->correo : "No definido" }} --}}
                                    {{$l->stock >0 ? 'Disponible':'Sin Stock'}}
                                </td>
                                @if ($l->stock >0)
                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                        wire:click="Seleccionar('{{ $d->pid }}')"
                                        class="btn btn-warning mtmobile"
                                        title="Seleccionar">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </td>
                                @else

                                <td class="text-center">
                                     
                                    <a href="javascript:void(0)"
                                    wire:click="SolicitarCompra('{{ $d->pid }}')"
                                    class="btn btn-warning mtmobile"
                                    title="Solicitar compra">
                                    Solicitar Compra
                                </a>

                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4" style="width: 15px !important;">
                                    <button class="botoneditarterminado">
                                        Crear y solicitar el producto: {{$this->searchproduct}}
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
            <br>
            <br>


            @endif
            

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </div>
    </div>
  </div>