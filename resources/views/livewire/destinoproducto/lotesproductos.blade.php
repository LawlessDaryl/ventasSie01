
<div wire:ignore.self class="modal fade" id="lotes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Lotes Productos</h5>
                <button type="button" class="close" data-keyboard="false" data-backdrop="static" data-dismiss="modal" aria-label="Close" wire:click="cerrar()">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div>
                @if ($loteproducto)
                    <div class="col-lg-12">
                          <div class="container">                       
                                            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                    <table class="table table-bordered table-striped mt-1">
                                                    <thead class="text-white" style="background: #2bda6e">
                                                        <tr>
                                                            <th class="table-th text-withe text-center">#</th>
                                                            <th class="table-th text-withe text-center">Producto</th>                              
                                                            <th class="table-th text-withe text-center">Existencia</th>   
                                                            <th class="table-th text-withe text-center">Costo Lote</th>                                                    
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($loteproducto as $data)
                                                        <tr>


                                                            {{-- {{$data}} --}}

                                                            <td>
                                                                <h6 class="text-center">{{ $loop->iteration}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6>{{$data->productos->nombre}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6>{{$data->existencia}}</h6>
                                                            </td>                                                        
                                                            <td>
                                                                <h6>{{$data->costo}}</h6>
                                                            </td>                                                        
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            
                                            </div>
                            

                        </div>
                    
               
         
                     </div>
        @endif                                    
                

             
            </div>
                   
          
            
        </div>
    </div>
</div>