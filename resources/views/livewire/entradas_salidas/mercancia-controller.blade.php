
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Entrada Salida Productos</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                    data-target="#operacion">Registrar<br/>Operacion</a>
                    <a href="javascript:void(0)"
                     wire:click="Incrementar()"
                 class="btn btn-warning"
                    title="increment">
                    Incrementar
                    </a>
                     
                </ul>
               
            </div>

            <div class="widget-body">

                <div class="row m-1">
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
                </div>

    {{--tabla que muestra todas las compras--}}

                <div class="row">
                    <div class="col-lg-12">
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                           
                                            <th class="table-th text-withe text-center">#</th>                                
                                            <th class="table-th text-withe text-center">Proceso</th>                                
                                            <th class="table-th text-withe text-center">Destino</th>                                
                                            <th class="table-th text-withe text-center">Concepto</th>
                                            <th class="table-th text-withe text-center">Observacion</th>
                                            <th class="table-th text-withe text-center">Usuario</th>
                                            <th class="table-th text-withe text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                           
                            </div>
                        </div>
                    </div>
                </div>

            </div>
@include('livewire.entradas_salidas.operacion')
        </div>
    </div>
   </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('product-added', msg => {
            $('#operacion').modal('hide')
            
        });
       
     
    })
    </script>