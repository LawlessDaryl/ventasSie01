<!-- Modal -->
<div wire:ignore.self class="modal fade" id="tabsModal" tabindex="-1" role="dialog" aria-labelledby="tabsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tabsModalLabel">Nueva Devolución</h5>
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
                    @if($productoentrante == 1)
                        <div class="text-center">
                            Se encontraron <b>{{$historialventa->count()}} ventas de este producto en los ultimos 30 dias</b>
                        </div>
                    @endif
                    <div class="modal-body">
                        <div class="row text-center">
                            <div class="col-lg-7 col-md-9 col-sm-12">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-gp">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" wire:model="nombreproducto" placeholder="Buscar Producto por Nombre o Código..." class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-3 col-sm-12">
                                <select wire:model="tipodevolucion" class="form-control  basic">
                                    <option value="monetario" selected="selected">Devolución Monetaria</option>
                                    <option value="productoigualitario" >Devolución por Producto</option>
                                </select>
                            </div>
                        </div>
                        


                        @if($BuscarProductoNombre != 0)
    
                        <div class="table-wrapper">
                            {{-- <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"> --}}
                                <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4" style="min-height: 150px;">
                                    <thead>
                                        <tr>
                                            {{-- <th class="table-th text-center text-white">IMAGEN</th> --}}
                                            <th class="table-th text-left text-white">DESCRIPCIÓN</th>
                                            <th colspan="2" class="table-th text-center text-white">#</th>
                                            
                                        </tr>
                                    </thead>
                                <tbody>
                                    @foreach ($datosnombreproducto as $p)
                                    <tr>
                                        {{-- Descripciòn Producto --}}
                                        <td>
                                            {{ $p->nombre }} - {{ $p->barcode }} :: <b>{{ $p->precio_venta }}Bs</b>
                                        </td>
                                        <td class="text-center">
                                            <button wire:click="entry({{$p->llaveid}})" class="btn btn-sm" title="Editar Venta" style="background-color: rgb(13, 175, 220); color:white;">
                                                <i class="far fa-check-square"></i>
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

                            <table class="table">
                                <tbody>
                                    @foreach ($ppee as $p)
                                    <tr style="background-color: rgb(231, 255, 10)">
                                        {{-- Descripciòn Producto --}}
                                        <td>
                                            {{ $p->nombre }}
                                        </td>
                                        {{-- Precio Producto--}}
                                        <td class="text-right">
                                            {{ $p->precio_venta }} Bs
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                        
                    
                        
                        @endif
                        
                        @if($productoentrante == 1)
                        
                            @if($tipodevolucion == 'productoigualitario')
                            <div class="text-center">
                                <b>Se descontara una Unidad del Stock de la Tienda del Producto </b>
                            </div>
                                <table class="table" style="background-color: rgb(34, 211, 255)">
                                    <tbody>
                                        @foreach ($ppee as $p)
                                        <tr>
                                            {{-- Descripciòn Producto --}}
                                            <td>
                                                {{ $p->nombre }}
                                            </td>
                                            {{-- Precio Producto--}}
                                            <td class="text-right">
                                                {{ $p->precio_venta }} Bs
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                                
                                <div class="form-row text-center">

                                    <div class="col-md-3 mb-9">
                                        <label for="validationCustom02">El Producto Irá a:</label>
                                    <select wire:model="destino" class="form-control">
                                        @foreach ($listardestinos as $d)
                                        <option value="{{$d->iddestino}}">{{ucwords(strtolower($d->nombredestino))}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-9 mb-9">
                                        <label for="validationCustom02">Motivo</label>
                                        <textarea class="form-control" placeholder="Ingrese el Motivo de la Devolución..." aria-label="With textarea" wire:model="observaciondevolucion"></textarea>
                                    </div>




                                </div>
                                <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />
                            @else
                            <div class="row text-center">
                                <div class="col-sm-6 col-md-2">
                                    <label for="validationCustom02">Monto Bs</label>
                                    <input wire:model="bs" type="number" class="form-control" placeholder="Ingrese Bs" required>
                                    <p style="color: crimson">Se Generará un Egreso de este Monto</p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <strong>Elegir Cartera</strong>

                                    <select wire:model="tipopago" class="form-control">
                                        <option disabled value="Elegir">Elegir</option>
                                        @foreach ($listacarteras as $cartera)
                                        <option value="{{$cartera->idcartera}}">{{ucwords(strtolower($cartera->nombrecartera)) .' - ' .ucwords(strtolower($cartera->dc))}}</option>
                                        @endforeach
                                        @foreach ($listacarterasg as $carteras)
                                        <option value="{{$carteras->idcartera}}">{{ucwords(strtolower($carteras->nombrecartera)) .' - ' .ucwords(strtolower($carteras->dc))}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <label for="validationCustom02">El Producto Irá a:</label>
                                    <select wire:model="destino" class="form-control">
                                        @foreach ($listardestinos as $d)
                                        <option value="{{$d->iddestino}}">{{ucwords(strtolower($d->nombredestino))}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-4">
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
                                    
                                        <button type="button" data-dismiss="modal" wire:click.prevent="guardardevolucionmonetaria()" 
                                        class="btn btn-primary">Guardar Devolución Monetaria</button>
                                @else
                                    {{-- Verificamos si existe stock del producto que queremos devolver --}}
                                        @if($this->verificarstock() == true)
                                        <button type="button" data-dismiss="modal" wire:click.prevent="guardardevolucionproducto()" 
                                        class="btn btn-primary">Guardar Devolucion por Producto</button>
                                        @else
                                        <br>
                                        <br>
                                        <h4>No  Existe Stock en Tienda Disponible para Devolver</h4>
                                        @endif
                                @endif
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
                                <div class="table-wrapper2">
                                    {{-- <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"> --}}
                            
                                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4" style="min-height: 150px;">
                                        <thead style="border-bottom: none; align-items: center;">
                                            <tr>
                                                <th>Fecha de la Venta</th>
                                                <th>Usuario Responsable</th>
                                                <th colspan="4"> Mostrar Detalles</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($historialventa as $p)
                                            <tr>
                                                <td class="text-center">
                                                    {{$p->fechaventa}}
                                                </td>
                                                <td class="text-center">
                                                    <p>{{ $p->nombreusuario }}</p>
                                                </td>
                                                <td colspan="4">
                                                    <div id="toggleAccordion">
                                                        <div class="card">
                                                            <div class="card-header" id="...">
                                                                <section class="mb-0 mt-0">
                                                                    <div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordion{{ $p->id }}" aria-expanded="true" aria-controls="defaultAccordion{{ $p->id }}">
                                                                         MostratOcultar
                                                                    </div>
                                                                </section>
                                                            </div>
                                                    
                                                            <div id="defaultAccordion{{ $p->id }}" class="collapse" aria-labelledby="..." data-parent="#toggleAccordion">
                                                                <div class="table-wrapper">
                                                                    {{-- <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"> --}}
                                                            
                                                                        <table class="" style="min-height: 150px;">
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
                        @endif
                    @endif
                </div>
                {{-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                </div> --}}
          </div>
        
        </div>
      </div>
    </div>
  </div>