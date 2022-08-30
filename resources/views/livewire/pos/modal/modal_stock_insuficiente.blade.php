{{-- Modal para avisar stock insuficiente en la Tienda y mostrar stock disponibles
en otros destinos dentro de la misma sucursal --}}

<div wire:ignore.self class="modal fade text-center" id="stockinsuficiente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" style="color: aliceblue" id="exampleModalCenterTitle">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <h4 style="color: rgb(0, 0, 0)" class="modal-heading mb-4 mt-2">Stock insuficiente en el destino Tienda</h4>




                
                    <h6 class="modal-text" style="color: rgb(0, 0, 0)">
                        No existe mas stock disponible del producto <b>"{{$this->nombreproducto}}"</b> en tu "TIENDA"
                        , a continuacion se muestran todas las sucursales y el stock con el que cuentan de este producto
                    </h6>
                    <div style="background-color: rgb(0, 148, 234); color: white;">
                            TU SUCURSAL: <b>"{{$this->nombresucursal}}"</b>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                <th>N°</th>
                                <th>Nombre Destino</th>
                                <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- listadestinos solo cargará si es diferente de nulo --}}
                                @if($this->listadestinos != null)
                                    @if($listadestinos->count() > 0)
                                        @foreach ($this->listadestinos as $item)
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
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="3">
                                            No hay stock disponible
                                        </td>
                                    </tr>
                                    @endif

                                @endif




                                
                            </tbody>
                        </table>
                        @foreach($this->listasucursales as $i)
                        <div style="background-color: rgb(234, 208, 12);">
                            {{ $i->name }} - {{ $i->adress }}
                        </div>
                        <table>
                            <thead>
                                <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($this->buscarstocksucursal($i->id)->count() > 0)
                                    @foreach ($this->buscarstocksucursal($i->id) as $d)
                                        <tr class="seleccionar">
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{ $d->nombredestino }}
                                            </td>
                                            <td>
                                                {{ $d->stock }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td class="text-center" colspan="3">
                                        No hay stock disponible
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
