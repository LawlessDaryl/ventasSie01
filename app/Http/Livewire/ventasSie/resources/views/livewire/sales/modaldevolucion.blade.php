<!-- Modal -->
<div wire:ignore.self class="modal fade" id="tabsModal" tabindex="-1" role="dialog" aria-labelledby="tabsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tabsModalLabel">Devolución Producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Devolución</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Historial de Ventas</a>
                  </li>
              </ul>
              <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                     
                    
                    

                    
                    
                    <div class="modal-body">
                        
                        <div class="row text-center">
                            
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-gp">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" wire:model="nombreproducto" placeholder="Buscar Producto..." class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-6">
                                <select wire:model="tipodevolucion" class="form-control  basic">
                                    <option value="monetario" selected="selected">Devolución Monetaria</option>
                                    <option value="productoigualitario" >Devolución Cambio Igualitario</option>
                                </select>
                            </div>
                        </div>
                        


                        @if($BuscarProductoNombre != 0)
    
                        <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">

                            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                                <thead class="text-white" style="background: #ee761c">
                                    <tr>
                                        <th class="table-th text-center text-white">IMAGEN</th>
                                        <th class="table-th text-left text-white">DESCRIPCIóN</th>
                                        <th class="table-th text-right text-white">COSTO</th>
                                        <th class="table-th text-right text-white">PRECIO</th>
                                        {{-- <th width="12%" class="table-th text-center text-white">Stock</th> --}}
                                        <th colspan="2" class="table-th text-center text-white">ACCION</th>
                                        
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
                                            <button  wire:click="entry({{ $p->llaveid }})" title="Producto que nos devuelve el Cliente" class="btn btn-dark mbmobile">
                                                Devolver
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
                                    @foreach ($ppee as $p)
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
                                        <td>
                                            <p style="background-color: white">Producto que nos están devolviendo</p>
                                        </td>
                                        {{-- Precio Producto--}}
                                        <td class="text-right">
                                            <h6>{{ $p->precio_venta }} Bs</h6>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                        
                    
                        
                        @endif
                        
                        @if($productoentrante == 1)
                        
                            @if($tipodevolucion == 'productoigualitario')
                                <table class="table" style="background-color: rgb(193, 242, 246)">
                                    <tbody>
                                        @foreach ($ppee as $p)
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
                                            <td>
                                                <p style="background-color: white">Producto que nosotros estamos devolviendo</p>
                                            </td>
                                            {{-- Precio Producto--}}
                                            <td class="text-right">
                                                <h6>{{ $p->precio_venta }} Bs</h6>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                                <br>
                                <br>
                            @else
                            <div class="form-row text-center">
                                <div class="col-md-3 mb-3">
                                    <label for="validationCustom02">Monto Bs</label>
                                    <input wire:model="bs" type="number" class="form-control" placeholder="Ingrese Bs" required>
                                    <p style="color: crimson">Se Generará un Egreso de este Monto</p>
                                </div>






                                <div class="col-md-9 mb-9">
                                    <label for="validationCustom02">Motivo</label>
                                    <textarea class="form-control" placeholder="Ingrese el Motivo de la Devolución..." aria-label="With textarea" wire:model="observaciondevolucion"></textarea>
                                </div>

                            </div>
                            <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                            @endif
                        @endif



                        {{-- Footer del Modal --}}
                        
                            @if($productoentrante == 1)
                            <div class="text-center">

                            <button class="btn" data-dismiss="modal" wire:click.prevent="resetUI()"><i class="flaticon-cancel-12"></i> Cancelar Todo</button>
            
                                @if($tipodevolucion == 'monetario')
                                    
                                        <button type="button" data-dismiss="modal" wire:click.prevent="guardardevolucion()" 
                                        class="btn btn-primary">Guardar Devolución</button>
                                @else
                                    {{-- Verificamos si existe stock del producto que queremos devolver --}}
                                        @if($this->verificarstock() == true)
                                        <button type="button" data-dismiss="modal" wire:click.prevent="devolverproducto()" 
                                        class="btn btn-primary">Devolver Producto</button>
                                        @else
                                        <br>
                                        <br>
                                        <h4>No  Existe Stock en Tienda Disponible para Devolver</h4>
                                        @endif
                                @endif
                        
                    {{-- --------------- --}}
                            </div>
                            @endif



                    </div>
                
                
                
                
                
                </div>








                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    @if($productoentrante != 1)
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                      <p class="modal-text text-center">Seleccione un Producto para ver su Historial de Ventas</p>
                          
                    <br> 
                    <br> 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    @else



                        @if($historialventa->count() > 0)
                            <div class="widget-content widget-content-area text-center">
                                <div>
                                    <h4>Historial de Ventas del Producto Seleccionado</h4>
                                </div>
                                <br>
                                <div class="table-responsive mb-4">
                                    <table id="show-hide-col" class="table table-hover" style="width:100%">
                                        <thead style="border-bottom: none; align-items: center;">
                                            <tr>
                                                <th>Producto Buscado</th>
                                                <th>Fecha de la Venta</th>
                                                {{-- <th>Cantidad Total</th> --}}
                                                <th>Usuario Responsable</th>
                                                <th colspan="4"> Mostrar Detalles</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($historialventa as $p)
                                            <tr>
                                                <td class="text-center">
                                                    <span>
                                                        <img src="{{('storage/productos/'.$p->image) }}"
                                                            height="40" class="rounded">
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{$this->cambiarformatofecha($p->fechaventa)}}</p>
                                                </td>
                                                {{-- <td class="text-center">
                                                    <p>{{ $p->totalbs }} Bs</p>
                                                </td> --}}
                                                {{-- <td class="text-center">
                                                    <p>{{ $p->items }}</p>
                                                </td> --}}
                                                <td class="text-center">
                                                    <p>{{ $p->nombreusuario }}</p>
                                                </td>
                                                <td colspan="4">
                                                    <div id="toggleAccordion">
                                                        <div class="card">
                                                            <div class="card-header" id="...">
                                                                <section class="mb-0 mt-0">
                                                                    <div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordion{{ $p->id }}" aria-expanded="true" aria-controls="defaultAccordion{{ $p->id }}">
                                                                         {{-- IIIIIIIIIIIIIIIIIIIIIIIIIIIIDetallesIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII --}}
                                                                              |||||||||||||||||||||||||||||MostratOcultar|||||||||||||||||||||||||||
                                                                    </div>
                                                                </section>
                                                            </div>
                                                    
                                                            <div id="defaultAccordion{{ $p->id }}" class="collapse" aria-labelledby="..." data-parent="#toggleAccordion">
                                                                <div class="card-body">
                                                                
                                                                    
                                                                    


                                                                    <table>
                                                                        <thead class="text-white" style="background: #e4e0e0 ">
                                                                            <tr>
                                                                                <th class="table-th text-left text-dark" colspan="2">Nombre Producto</th>
                                                                                <th class="table-th text-center text-dark">Bs</th>
                                                                                <th class="table-th text-center text-dark">Cantidad</th>
                                                                                <th class="table-th text-center text-dark">Total</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody style="background-color: rgb(255, 255, 255)">
                                                                            @foreach ($this->venta($p->id) as $item)
                                                                            <tr>
                                                                                <td class="text-left" style="padding: 0%" colspan="2">
                                                                                    {{ substr($item->nombre, 0, 15)  }}...
                                                                                </td>
                                                                                <td style="padding: 0%" class="text-right">
                                                                                    {{ number_format($item->precio, 2) }}
                                                                                </td>
                                                                                <td style="padding: 0%" class="text-center">
                                                                                    {{ $item->cantidad }}
                                                                                </td>
                                                                                <td style="padding: 0%" class="text-right">
                                                                                    {{ number_format($item->precio *  $item->cantidad, 2) }} Bs
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>






                                                    
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
                            </div>
                        @else
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p class="text-center">¡No Existen Ventas del Producto Seleccionado en los Últimos 30 Días!</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>    
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                        @endif


                    @endif





                        
                </div>






                
                {{-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                </div> --}}
          </div>
        
          <div class="modal-footer">
            
        </div>
      </div>
    </div>
  </div>