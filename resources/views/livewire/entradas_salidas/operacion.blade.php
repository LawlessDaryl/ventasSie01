@section('css')


{{-- Estilos para la tabla Movimiento Diario --}}
<style>


.tablaservicios {
        width: 100%;
       
    }
    .tablaservicios thead {
        background-color: #3b3034;
        color: white;
    }
    .tablaservicios th, td {
        border: 0.5px solid #4d3e43;
        padding: 4px;
    }
    .tablaservicios tr:hover {
        background-color: rgba(230, 227, 89, 0.336);
    }
</style>
@endsection

<div wire:ignore.self class="modal fade" id="operacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Entrada/Salida de Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-8">
                        <div class="form-group">
                            <strong style="color: rgb(74, 74, 74)">Seleccione un tipo de proceso:</strong>
                            <select wire:model='tipo_proceso' class="form-control">
                                <option value="Entrada" selected>Entrada</option>
                                <option value="Salida">Salida</option>
                              
                                
                            </select>
                            @error('tipo_proceso')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror                                          
                        </div>
                        <div class="form-group">
                            <strong style="color: rgb(74, 74, 74)">Seleccione la locacions:</strong>
                            <select wire:model='destinosucursal' class="form-control">
                                <option value="Elegir">Elegir</option>
                                @foreach ($destinosp as $item)
                                <option value="{{$item->id}}">{{$item->sucursal}}-{{$item->destino}}</option>
                                @endforeach
                            </select>
                            @error('destino')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror                                          
                        </div>
                        <div class="form-group">
                            <strong style="color: rgb(74, 74, 74)">Seleccione el concepto:</strong>
                            <select wire:model='concepto' class="form-control">
                                <option value="obsequio" selected>Ingreso/Salida de productos</option>
                                <option value="ajuste" selected>Ingreso/Salida por ajuste de inventarios</option>
                                <option value="Inventario Inicial">Inventario Inicial</option>
                              
                                
                            </select>
                            @error('concepto')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror                                        
                        </div>
                        <div class="form-group">
                            <strong style="color: rgb(74, 74, 74)">Agregue una observacion:</strong>
                            <input type="text" class="form-control" wire:model='observacion'>
                           
                            @error('observacion')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror                                        
                        </div>
                    </div>
                   
                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="d-flex row ml-2">
                                <h6>Producto</h6>
                            </label>
                            @if ($result)
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <a class="input-group-text input-gp btn btn-dark" wire:click="deleteItem()">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                                <input type="text" wire:model="result" placeholder="Buscar" class="form-control">
                            </div>
                            @else
                            <input wire:model="searchproduct" class="form-control">
                            @endif
                            
                        </div>
                        @if ($buscarproducto != 0)
                        <div class="col-sm-12 col-md-12">
                            <div class="vertical-scrollable">
                                <div class="row layout-spacing">
                                    <div class="col-md-12 ">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area row">
                                                <div
                                                    class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                    <table class="table table-hover table-sm" style="width:100%">
                                                        <thead class="text-white" style="background: #3B3F5C">
                                                            <tr>
                                                                <th class="table-th text-withe text-center">Producto</th>
                                                                <th class="table-th text-withe">Accion</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($sm as $d)
                                                                <tr>
                                                              
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->nombre }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="Seleccionar('{{ $d->id }}')"
                                                                            class="btn btn-warning mtmobile"
                                                                            title="Seleccionar">
                                                                            <i class="fas fa-check"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>

                    <div class="col-lg-2 ml-1 p-0">
                        <div class="form-group">
                            <label>
                                <h6>Cantidad</h6>
                            </label>
                            <input wire:model="cantidad" class="form-control">
                            
                        </div>
                    </div>
                    @if ($tipo_proceso == 'Entrada')
                        
                    <div class="col-lg-2 ml-1 p-0">
                        <div class="form-group">
                            <label>
                                <h6>Costo/Valor</h6>
                            </label>
                            <input wire:model="costo" class="form-control">
                            
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-1 ml-1 p-0">
                        <div class="form-group">
                            <label>
                                <h6>Agregar</h6>
                            </label>
                            <button type="button" wire:click="addProduct({{$selected}})"
                            class="btn btn-warning fas fa-arrow-down"></button>
                        </div>

                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        @if (count($col)>0)
                            
                         <div class="table-responsive">
                            <table  class="tablaservicios">
                                <thead>
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">PRODUCTO</th>                              
                                        <th class="table-th text-withe text-center">COSTO</th>                              
                                        <th class="table-th text-withe text-center">CANTIDAD</th>
                                        <th class="table-th text-withe text-center">Acc.</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($col as $key=>$value)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            <h6>{{$value['product-name']}}</h6>
                                        </td>
                                        <td>
                                            <h6>{{$value['costo']}}</h6>
                                        </td>
                                        <td>
                                            <h6>{{$value['cantidad']}}</h6>
                                        </td>
                                        <td>
                                            <i class=" btn btn-sm fas fa-trash" wire:click="eliminaritem({{$value['product_id']}} )"></i>
                                        </td>
                                    </tr>
                                 
                                  
                                   @endforeach
                                </tbody>
                             </table>
                            </div> 
                            
                       
                        @endif
                    </div>
                </div>
            </div>
  
        </div>
    </div>
</div>