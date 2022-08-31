{{-- Modal para avisar stock insuficiente en la Tienda y mostrar stock disponibles
en otros destinos dentro de la misma sucursal --}}

<div wire:ignore.self class="modal fade text-center" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" style="color: aliceblue" id="exampleModalCenterTitle">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <h4 style="color: rgb(0, 0, 0)" class="modal-heading mb-4 mt-2">Stock Insuficiente en Tienda</h4>




                
                    <h6 class="modal-text" style="color: rgb(0, 0, 0)">
                        No existe mas Stock del producto "{{$nombrestockproducto}}" en  la TIENDA
                        , pero se encontraron stock disponibles en los siguientes lugares:
                    </h6>
                        <br> 
                        <table class="estilostable" style="color: black">
                            <thead style="background-color: rgb(243, 201, 146)">
                              <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                {{-- <th>Total Bs</th> --}}
                                <th>Stock</th>
                                <th>Seleccionar</th>
                                {{-- <th>Total</th> --}}
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($listdestinos as $item)


                                    <tr class="seleccionar">
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            {{ $item->nombredestino }}
                                        </td>
                                        <td>
                                            {{ $item->stock }}
                                        </td>
                                        <td>
                                            <button title="Mover Inventario de este lugar" wire:click="seleccionardestino({{ $item->id }})"  class="btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </button>
                                        </td>
                                    </tr>


                                    @endforeach
                            </tbody>
                        </table>


                   








                        
                        
                    <br>
                    
                    @if($iddestinoseleccionado > 0)

                    
                    

                        <center>
                            <div class="col-lg-6">
                                <input type="number" min="1" max="{{$stockalmacen}}" wire:model.lazy="cantidadToTienda" class="form-control">
                                @error('cantidadToTienda')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </center>
                        
                        <br>


                        <strong style="color: red">¡AVISO!</strong> 
                        <p style="color: red">
                            Esta acciòn movera productos a la TIENDA de:
                        </p>
                        <h4 style="color: red">{{$nombredestinoseleccionado}}</h4>
                        <br>
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> No</button>
                        <button type="button" class="btn btn-primary" wire:click.prevent="almacenToTienda()" >Si</button>

                    @endif

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
