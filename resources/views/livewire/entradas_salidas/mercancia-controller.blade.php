
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Control Entrada y Salida de Productos</b>
                </h4>
                <ul class="row justify-content-end">
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                    data-target="#operacion">Registrar Operacion</a>
                    {{-- <a href="javascript:void(0)"
                     wire:click="Incrementar()"
                        class="btn btn-warning"
                    title="increment">
                    Incrementar
                    </a> --}}
                     
                </ul>
               
            </div>

            <div class="widget-body">

                {{-- <div class="row m-1">
                    <div class="col-12 col-lg-5 col-md-4 card">
                        <h5 class="mt-2">Fecha de Compra</h5>

                        <div class="row align-items-center mt-1">

                            <div class="col-lg-8">

                                <select wire:model="fecha" class="form-control">
                                        <option value='hoy' selected>Hoy</option>
                                        <option value='ayer'>Ayer</option>
                                        <option value='semana'>Semana</option>
                                        <option value='fechas'>Entre Fechas</option>
                                </select>
                            </div>
                            @if($fecha == 'fechas')
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Fecha inicial</label>
                                    <input type="date" wire:model.lazy="fromDate" class="form-control">
                                    @error('fromDate')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                 </div>
                             </div>
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Fecha final</label>
                                    <input type="date" wire:model.lazy="toDate" class="form-control">
                                    @error('toDate')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                </div>
                        </div>
                            @endif

                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12 col-12 mt-3">

                        @include('common.searchbox')
                    </div>
                </div> --}}

    {{--tabla que muestra todas las compras--}}

                {{-- <div class="row">
                    <div class="col-lg-12">
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                            <th class="table-th text-withe text-center">#</th>                                
                                            <th class="table-th text-withe text-center">Fecha</th>                                
                                            <th class="table-th text-withe text-center">Entrada/Salida</th>                                
                                            <th class="table-th text-withe text-center">Ubicacion</th>                                
                                            <th class="table-th text-withe text-center">Tipo Operacion</th>
                                            <th class="table-th text-withe text-center">Observacion</th>
                                            <th class="table-th text-withe text-center">Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($operaciones as $data)
                                           <tr>
                                                <td>
                                                    {{$loop->iteration}}
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($data->created_at)->format('d-m-Y')}}
                                                    <br>
                                                    {{\Carbon\Carbon::parse($data->created_at)->format('h:i:s a')}}
                                                </td>
                                                <td>
                                                    {{$data->proceso}}
                                                </td>
                                                <td>
                                                    {{$data->destino_nombre}}
                                                    {{$data->suc_name}}
                                                </td>
                                                <td>
                                                    {{$data->concepto}}
                                                </td>
                                                <td>
                                                    {{$data->observacion}}
                                                </td>
                                                <td>
                                                    {{$data->userop}}
                                                </td>

                                           </tr>

                                       @endforeach
                                    </tbody>
                                </table>
                           
                            </div>
                        </div>
                    </div>
                </div> --}}


                <div class="row">
                    <div class="col-lg-12">
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                            <th class="table-th text-withe text-center">#</th>                                
                                            <th class="table-th text-withe text-center">Fechad</th>                                
                                                               
                                            <th class="table-th text-withe text-center">Ubicacion</th>                                
                                            <th class="table-th text-withe text-center">Tipo Operacion</th>
                                            <th class="table-th text-withe text-center">Observacion</th>
                                            <th class="table-th text-withe text-center">Usuario</th>
                                            <th class="table-th text-withe text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($ingprod as $data2)
                                           <tr>
                                                <td>
                                                    
                                                        <h6>{{ ($ingprod->currentpage()-1) * $ingprod->perpage() + $loop->index + 1 }}</h6>
                                                    
                                                </td>
                                                <td>
                                                    {{\Carbon\Carbon::parse($data2->created_at)->format('d-m-Y')}}
                                                    <br>
                                                    {{\Carbon\Carbon::parse($data2->created_at)->format('h:i:s a')}}
                                                </td>
                                             
                                                <td>
                                                   Sucursal {{$data2->destinos->sucursals->name}}
                                                    {{$data2->destinos->nombre}}
                                                  
                                                </td>
                                                <td>
                                                    {{$data2->concepto}}
                                                </td>
                                                <td>
                                                    {{$data2->observacion}}
                                                </td>
                                                <td>
                                                    {{$data2->usuarios->name}}
                                                </td>
                                                <td>
                                                    <center>
                                                    <button wire:click="ver({{ $data2->id }})" type="button" class="btn btn-secondary p-1" style="background-color: rgb(12, 100, 194)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                                    </button>
                                                </center>
                                                  </td>

                                           </tr>

                                       @endforeach
                                    </tbody>
                                </table>
                                {{ $ingprod->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
@include('livewire.entradas_salidas.operacion')
@include('livewire.entradas_salidas.buscarproducto')
        </div>
    </div>
   </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('product-added', msg => {
            $('#operacion').modal('hide')
            
        });
        window.livewire.on('show-detail', msg => {
            $('#buscarproducto').modal('show')
            
        });
       
     
    })
    </script>