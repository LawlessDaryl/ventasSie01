
        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="devolucionProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Devolución Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row text-center">
                            
                            @if($productoentrante == 1)
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-gp">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" wire:model="nombreproducto" placeholder="Buscar Producto..." class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <select class="form-control  basic">
                                    <option selected="selected">Producto Entrante</option>
                                    <option>Producto Saliente</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <select class="form-control  basic">
                                    <option selected="selected">Devolución Producto</option>
                                    <option>Devolución Monetario</option>
                                    <option>Devolución Producto-Monetario</option>
                                </select>
                            </div>
                            @else
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-gp">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" wire:model="nombreproducto" placeholder="Buscar Producto..." class="form-control">
                                </div>
                            </div>
                            @endif
                        </div>
                        


                        @if($BuscarProductoNombre != 0)
    
                        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">

                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white" style="background: #3b3f5c ">
                                    <tr>
                                        <th class="table-th text-center text-white">IMAGEN</th>
                                        <th class="table-th text-left text-white">DESCRIPCIóN</th>
                                        <th class="table-th text-right text-white">COSTO</th>
                                        <th class="table-th text-right text-white">PRECIO</th>
                                        {{-- <th width="12%" class="table-th text-center text-white">Stock</th> --}}
                                        <th class="table-th text-center text-white">DEVOLVER</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datosnombreproducto as $p)
                                    <tr>
                                        {{-- Imagen Producto --}}
                                        <td class="text-center">
                                            <span>
                                                <img src="{{('storage/productos/'.$p->image) }}"
                                                    height="40" class="rounded">
                                            </span>
                                        </td>
                                        {{-- Descripciòn Producto --}}
                                        <td>
                                            <h6>{{ $p->nombre }}</h6>
                                        </td>
                                        <td class="text-right">
                                            <h6>{{ $p->costoproducto }}</h6>
                                        </td>
                                        {{-- Precio Producto--}}
                                        <td class="text-right">
                                            <h6>{{ $p->precio_venta }} Bs</h6>
                                        </td>
                                        {{-- Stock Disponible --}}
                                        {{-- <td  class="text-center">
                                            <h6>{{$p->stock}}</h6>
                                        </td> --}}
                                        {{-- Acciones --}}
                                        <td class="text-center">
                                            <button  wire:click="abrirdetalles({{ $p->llaveid }})" class="btn btn-dark mbmobile">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        @else

                        <br>
                        <br>
                        <br>
                        <br>
                        <p class="text-center">Busque el Producto</p>
                        <br>
                        <br>
                        <br>
                        <br>

                        @endif


                        @if($productoentrante == 1)
                        <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                        <table class="table" style="background-color: rgb(234, 210, 187)">
                            <tbody>
                                @foreach ($asd as $pp)
                                <tr>
                                    {{-- Imagen Producto --}}
                                    <td class="text-center">
                                        <span>
                                            <img src="{{('storage/productos/'.$pp->image) }}"
                                                height="40" class="rounded">
                                        </span>
                                    </td>
                                    {{-- Descripciòn Producto --}}
                                    <td>
                                        <h6>{{ $pp->nombre }}</h6>
                                    </td>
                                    <td>
                                        <marquee behavior="" direction="" style="margin: 0px; padding:0px;">
                                            <p style="background-color: white">Producto que nos están devolviendo</p>
                                        </marquee>
                                    </td>
                                    {{-- Precio Producto--}}
                                    <td class="text-right">
                                        <h6>{{ $pp->precio_venta }} Bs</h6>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                        
                        
                        <table class="table" style="background-color: rgb(193, 242, 246)">
                            <tbody>
                                <tr>
                                    {{-- Imagen Producto --}}
                                    <td class="text-center">
                                        <span>
                                            <img src="{{('storage/productos/'.$pp->image) }}"
                                                height="40" class="rounded">
                                        </span>
                                    </td>
                                    {{-- Descripciòn Producto --}}
                                    <td>
                                        <h6>{{ $pp->nombre }}</h6>
                                    </td>
                                    <td>
                                        <marquee behavior="" direction="" style="margin: 0px; padding:0px;">
                                            <p style="background-color: white">Producto que nosotros estamos devolviendo</p>
                                        </marquee>
                                    </td>
                                    {{-- Precio Producto--}}
                                    <td class="text-right" style="width: 140px">
                                        <input type="number" class="form-control" placeholder="Ingrese Bs" value="{{ $pp->precio_venta }}" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>




                        <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                        
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">Dinero de Salida</label>
                                <select class="form-control  basic">
                                    <option selected="selected">EFECTIVO</option>
                                    <option>CUENTA BANCARIA</option>
                                    <option>TIGO MONNEY</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom02">Monto Bs</label>
                                <input type="number" class="form-control" placeholder="Ingrese Bs" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label for="validationCustom02">Motivo</label>
                                <input type="text" class="form-control" placeholder="Ingrese el Motivo de la Devolución..." required>
                            </div>
                        </div>
                        <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                        @endif






                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar Todo</button>
                        <button type="button" class="btn btn-primary">Guardar Devolución</button>
                    </div>
                </div>
            </div>
        </div>