<div wire:ignore.self class="modal fade" id="ajustesinv" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Operaciones en Inventarios</h5>
                <div class="d-flex justify-content-end">
                
                <button type="button" wire:click="resetajuste()" class="btn btn-success text-center"> Cerrar </button>
               </div>
               
            </div>
            <div class="modal-body">

  {{-- --------area de pruebas------- --}}
<div class="m-2">
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
</div>
  <div class="m-2">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-link active show" wire:click="$set('toogle', '1')" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab">Ajuste de Inventarios</a>
          <a class="nav-link" wire:click="$set('toogle', '2')" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab">Entradas y Salida de Productos</a>
          <a class="nav-link" wire:click="$set('toogle', '3')" id="nav-mobiliario-tab" data-toggle="tab" href="#nav-mobiliario" role="tab">Asignar Mobiliario</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade {{$active1}}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


            <div class="m-2">
                <ul class="row justify-content-start">
                    <button class="btn btn-sm btn-dark" wire:click='vaciarProducto()'>Vaciar Stock </button>  
                </ul>
            </div>
      

        <div class="row  m-2">
            <div class="col-lg-9">
             
                <label class="text">Agregar stock:</label>
                <div class="input-group">
                    <input type="text" class="form-control"  wire:model="cantidad"  aria-label="Recipient's username with two button addons">
                    <button class="btn btn-outline-dark"  wire:click='incrementar()' type="button">Inc.</button>
                    <button class="btn btn-outline-success"  wire:click='disminuir()' type="button">Dism.</button>
                 
                  </div>
              </div>
  
         </div>
    </div>
        <div class="tab-pane fade {{$active2}}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row  m-2">
                    <div class="col-lg-9">
                     
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="inputGroupSelect01">Tipo Operacion</label>
                            </div>
                            <select class="custom-select" wire:model="opcion_operacion" id="inputGroupSelect01">
                              <option selected>Elegir un tipo de operacion</option>
                              <option value="Entrada">Entrada de Producto</option>
                              <option value="Salida">Salida de Producto</option>
                           
                            </select>
                          </div>

                          <div class="row">
                              <div class="col-lg-4 form-group">
                                <label class="text mb-1">Asignar Cantidad:</label>
                                <input type="text" class="form-control"  wire:model="cant_operacion"  aria-label="Recipient's username with two button addons">
                             
                              </div>
                              <div class="col-lg-8 form-group">
                                      <label for="exampleFormControlTextarea1">Agregue una Observacion:</label>
                                      <input class="form-control" wire:model="obs_operacion" id="exampleFormControlTextarea1">
                              </div>
                              <div class="col-lg-3 form-group">
                                    <button class="btn btn-dark"  wire:click='operacionInventario()' >Guardar Registro</button>
                              </div>

                            
                          </div>
                      
                        
                        


                        

                    </div>
          
            </div>

        </div>
        <div class="tab-pane fade {{$active3}}" id="nav-mobiliario" role="tabpanel" aria-labelledby="nav-mobiliario-tab">
                        
        <div class="row m-2">

            <div class="col-lg-12">

                <label class="text mb-1"> Mobiliarios:</label>

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

       
      </div>
</div>
  {{-- ------------------------------ --}}
           
                

                </div>
          
            </div>
  
        </div>
    </div>


