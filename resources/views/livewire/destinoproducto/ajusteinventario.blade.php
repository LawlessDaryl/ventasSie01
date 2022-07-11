<div wire:ignore.self class="modal fade" id="ajustesinv" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ajuste de Inventarios</h5>
               
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-8">
                        <div class="form-group">
                            <label>
                                <h6> <b>Producto</b> </h6>
                            </label>
                           <h6>{{$productoajuste}}</h6>
                        </div>
                       
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>
                                <h6> <b>Existencia Anterior:</b> </h6>
                            </label>
                            <h6>{{$productstock}}</h6>
                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>
                                <h6> <b>Agregar stock:</b> </h6>
                            </label>
                            <input wire:model="cantidad" class="form-control">
                            
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>
                                <h6> <b>Mobiliario:</b> </h6>
                            </label>
                            <select wire:model='mobiliario' class="form-control">
                                @if ($mobs)
                                <option value=null disabled selected>Elegir Mobiliario</option>
                                @foreach ($mobs as $data)
                                <option value="{{ $data->id }}">{{ $data->tipo}}-{{$data->codigo}}</option>
                              @endforeach
                                @endif
                             
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                          <table>
                            <thead>
                                <tr>
                                    <th class="table-th text-withe text-center"></th>
                                    <th class="table-th text-withe text-center"></th>                              
                                 
                                </tr>
                            </thead>
                              <tbody>
                                @if ($mop_prod)
                                    
                               
                                
                                    @foreach ($mop_prod as $item)
                                  <tr>
                                    <td wire:key="item-{{ $item->id }}">

                                        {{$item->locations->tipo}} {{$item->locations->codigo}}
                                    </td>
                                 
                            
                               
                                  </tr>

                                       
                                    
                                    @endforeach
                              
                               
                                
                                 @else
                                 <td>
                                    Sin mobiliarios
                                </td>
                                @endif
                              </tbody>
                          </table>
                            
                        </div>
                    </div>
                    
                </div>

                </div>
                <div class="row justify-content-center">

                    <div class="col-lg-4">
                        <div class="form-group">
                          
                            <button type="button" wire:click="guardarajuste()"
                            class="btn btn-danger fas fa-save text-center"> Guardar</button>
                        </div>
    
                        
                    </div>
                </div>
            </div>
  
        </div>
    </div>
</div>

