
<div wire:ignore.self class="modal fade" id="detallerepuestos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                  <center>Detalle de Repuestos utilizados</center> 
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
        <div class="modal-body">
            <div class="container-fluid">
          
            
              <div class="row p-3">
                <div class="col-lg-12 mt-2">
                   
                <center><label for="tablarep" class="mb-2"> <b>LISTA DE REPUESTOS</b> </label></center>
                @if ($repuestos != null)
                  <center> <table class="salidarepuestos" id="tablarep">
                        <thead class="table-light">
                            <tr>
                                <th style="width:20px">#</th>
                                <th>Producto</th>         
                                <th style="width: 40px">Cant.</th>
                                <th style="width: 40px">p/v</th>
                                <th>Destino</th>

                                <th style="width: 3rem">Acc.</th>
                              
                            </tr>
                        </thead>
                    <tbody>
                                        @foreach ($repuestos as $item)
                                        
                                        <tr>
                                            <td>
                                                {{$loop->index+1}}
                                            </td>
                                            <td>{{$item->prod_name}}</td>
                                        
                                        
                                            <td>
                                            {{$item->cant}}
                                            </td>
                                            <td>
                                                {{$item->pv}}
                                            </td>
                                            <td>

                                                <button class="btn btn-sm btn-danger fas fa-times pl-1 pr-1 pt-0 pb-0 m-0"></button>
                                            </td>
                                         
                                        
                                        </tr>
                                 
                                        @endforeach
                               
                               
                            </tbody>
                        </table>
                    </center> 
                    @endif
                    
                    
                    
                </div>
                
              </div>
             
             
            </div>
        </div>
    </div>
</div>



</div>

