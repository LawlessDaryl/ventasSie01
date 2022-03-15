<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                @if ($total > 0)
                <div class="table-responsive tblscroll" style="overflow: hidden">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c ">
                            <tr>
                                <th class="table-th text-left text-white">IMAGEN</th>
                                <th class="table-th text-left text-white">DESCRIPCIóN</th>
                                <th class="table-th text-center text-white">PRECIO</th>
                                <th width="12%" class="table-th text-center text-white">CANTIDAD</th>
                                <th class="table-th text-center text-white">IMPORTE</th>
                                <th class="table-th text-center text-white">ACCIONES</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                            <tr>
                                {{-- Imagen Producto --}}
                                <td class="text-center table-th">
                                    @if (count($item->attributes) > 0)
                                    <span>
                                        <img src="{{ asset('storage/productos/' . $item->attributes[0]) }}" alt="imágen del producto" height="90" class="rounded">
                                    </span>
                                    @endif
                                </td>
                                {{-- Descripciòn Producto --}}
                                <td>
                                    <h6>{{ $item->name }}</h6>
                                </td>
                                {{-- Precio --}}
                                <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                {{-- Cantidad --}}
                                <td>
                                    <input type="number" maxlength="{{$item->stock}}"
                                    id="r{{$item->id}}" 
                                    wire:change="UpdateQty({{$item->id}}, $('#r' + {{$item->id}}).val() )" 
                                    style="font-size: 1rem!important;" 
                                    class="form-control text-center" 
                                    value="{{$item->quantity}}">
                                </td>
                                {{-- Importe --}}
                                <td class="text-center">
                                    <h6>{{ $item->price * $item->quantity, 2 }}</h6>
                                </td>
                                {{-- Acciones --}}
                                <td class="text-center">
                                    <button onclick="Confirm('{{ $item->id }}','removeItem','¿Confirmas eliminar elregistro?')" class="btn btn-dark mbmobile">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button wire:click.prevent="decreaseQty({{ $item->id }})" class="btn btn-dark mbmobile">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <button wire:click.prevent="increaseQty({{ $item->id }})" class="btn btn-dark mbmobile">
                                        <i class="fas fa-plus"></i>
                                    </button>


                                    <div id="modalVerticallyCentered" class="col-lg-12 layout-spacing">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area">
                                                <div class="text-center">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#exampleModalCenter">
                                                      Añadir de Almacen
                                                    </button>
                                                </div>
            
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                                        No se encontraron mas Productos en la Tienda. Pero se encontraron 10 Unidades del Producto $Nombre
                                                                        ¿Desea Agregarlos al Carrito?
                                                                    </h6>
                                                                        
                                                                        {{-- <div class="alert alert-arrow-left alert-icon-left alert-light-primary mb-4" role="alert">
                                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                                                            <strong>¡AVISO!</strong> Esta acciòn movera productos del Almacen a la Tienda.
                                                                        </div> --}}

                                                                                <div class="alert alert-warning mb-4" role="alert"> 
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                                                                stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert">
                                                                                <line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18">
                                                                                    </line></svg>
                                                                                </button> <strong>¡AVISO!</strong> Esta acciòn movera productos de la Tabla Almacen a la Tabla Tienda
                                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> No</button>
                                                                <button type="button" class="btn btn-primary">Si</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h5 class="text-center text-muted">Agregar productos a la venta</h5>
                @endif
                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danger text-center">Guardando venta...</h4>
                </div>
            </div>
        </div>
    </div>
</div>