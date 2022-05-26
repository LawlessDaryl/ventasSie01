@section('css')


{{-- Estilos para la tabla Movimiento Diario --}}
<style>


    .contenedortabla{
        /* overflow:scroll; */
        overflow-x:auto;
        /* max-height: 100%; */
        /* min-height:200px; */
        /* max-width: 100%; */
        /* min-width:100px; */
    }

    .estilostable {
    width: 100%;
    min-width: 1000px;
    }

</style>
@endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Almacen Producto</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="transferencia" class="btn btn-dark" >Transferir <br/>Productos</a>
                        <a href="transferencias" class="btn btn-dark">Ver<br/>Transferencias</a>
                      
                    
                </ul>
               
            </div>
          

            {{--SELECT DE LAS SUCURSALES--}}
            <div class="row">
                <div class="col-12 col-lg-4 col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                            </div>
                </div>
                
                <div class="col-12 col-lg-5 col-md-3">

                    <div class="form-group">
                        <select wire:model='selected_id' class="form-control">
                            <option value="General">Almacen Total</option>
                          @foreach ($data_suc as $data)
                          <option value="{{ $data->id }}">{{ $data->sucursal }}-{{$data->destino}}</option>
                          @endforeach
                         
                         
                        </select>
                      </div>
                </div>
            </div>
          
          

             
                <div class="contenedortabla">
                    <table class="estilostable">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">ITEM</th>
                                <th class="table-th text-withe text-center">PRODUCTO</th>                              
                                <th class="table-th text-withe text-center">STOCK</th>   
                                @if ($selected_id == 'General' || $selected_id == null)
                                <th class="table-th text-withe text-center">CANT.MIN</th>                                       
                                <th class="table-th text-withe text-center">ACCIONES</th>
                                @endif                           
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($destinos_almacen as $destino)
                            @if ($destino->stock_s < $destino->cant_min)
                                
                            <tr style="background-color: rgb(227, 146, 146)">
                            @else
                            <tr>
                            @endif
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration}}</h6>
                                    </td>
                                    <td>
                                        <h5> <strong>{{$destino->nombre}}</strong> </h5>
                                        <label>{{ $destino->unidad}}</label>|<label>{{ $destino->marca}}</label>|<label>{{ $destino->industria }}</label>
                                        <h6>{{ $destino->caracteristicas }}</h6>
                                     
                                    </td>
                                    @if ($selected_id == 'General' || $selected_id == null)
                                    <td>
                                      <h6 class="text-center">{{ $destino->stock_s }}</h6>
                                  </td>
                                    <td>
                                      <h6 class="text-center">{{ $destino->cantidad_minima }}</h6>
                                  </td>
                                  <td class="text-center">
                                    <button wire:click="ver({{ $destino->id }})" type="button" class="btn btn-secondary" style="background-color: rgb(12, 100, 194)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                    </button>
                                </td>
                                    @else
                                    <td>
                                      <h6 class="text-center">{{ $destino->stock }}</h6>
                                  </td>
                                    @endif
                                    
                                    
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$destinos_almacen->links() }}
                
                </div>
                 
            
                  
        </div>
         
    </div>
      
   
   
    @include('livewire.destinoproducto.detallemobiliario')
    </div>
@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal', msg => {
            $('#mobil').modal({backdrop: 'static', keyboard: false})
            $('#mobil').modal('show')
           
        });
       
    });




</script>

@endsection