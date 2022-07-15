<div wire:ignore.self class="modal fade" id="ajustesinv" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ajuste de Inventarios</h5>
               
            </div>
            <div class="modal-body">
                    <div class="row">
                        <ul class="row justify-content-end">
                    
                            <button class="btn btn-sm btn-dark m-1" wire:click='vaciarProducto()'> Vaciar Stock </button>
                            
                           
                           
                        </ul>
                    </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered">
                            <thead>
                                 <tr>
                                    <th>Producto</th>
                                    <th>Existencia Actual</th>
                                    <th>Mobiliario Asignado</th>
               
                                </tr>
                            </thead>
                                <tbody>
                     <tr>
                <td class="text-center p-0 m-0" style="font-size: 0.6rem">
                    {{$productoajuste}}
                </td>
                <td class="text-center">
                    {{$productstock}}
                </td>
                <td class="text-center" style="font-size: 0.6rem">
                    @if ($mop_prod)
                    @foreach ($mop_prod as $item)
                    <div class="btn-group">
                        <span class="text-center pt-2">{{$item->locations->tipo}} {{$item->locations->codigo}}</span>
                       <i class=" btn btn-sm fas fa-trash" wire:click="eliminarmob({{$item->id}} )"></i>
                    </div>
                    @endforeach
                         @else
                         <label>

                        Sin mobiliarios
                        </label>
                
                        @endif
                        </td>
              
                         </tr>
                        </tbody>
                        </table>
                        </div>
                        </div>            

                <div class="row  m-2">
                    <div class="col-lg-9">
                     

                        <label class="text">Agregar stock:</label>
                        <div class="input-group">
                            <input type="text" class="form-control"  wire:model="cantidad"  aria-label="Recipient's username with two button addons">
                            <button class="btn btn-outline-dark"  wire:click='incrementar()' type="button">Incrementar</button>
                         
                          </div>


                        

                    </div>
          
            </div>
            <div class="row m-2">

                <div class="col-lg-12">

                    <label class="text">Asignar Mobiliario:</label>

                        <div class="input-group">
                            <select class="form-select" wire:model='mobiliario' id="inputGroupSelect04" aria-label="Example select with button addon">
                                @if ($mobs)
                          <option value=null disabled selected>Elegir Mobiliario</option>
                          @foreach ($mobs as $data)
                          <option value="{{ $data->id }}">{{ $data->tipo}}-{{$data->codigo}}</option>
                        @endforeach
                          @endif
                            </select>
                            <button class="btn btn-outline-secondary ml-0 mr-0" wire:click='asignmob()' type="button">Asignar Mob.</button>
                          </div>
                    
                    </div>

                </div>
                

                </div>
                <div class="row justify-content-center p-1">

                     
                        <div class="col-lg-4">
                                <button type="button" wire:click="resetajuste()"
                                class="btn btn-success text-center"> Cerrar </button>
                        </div>
                    
                </div>
            </div>
  
        </div>
    </div>


