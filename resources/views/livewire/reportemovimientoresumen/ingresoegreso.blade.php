<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>INGRESOS Y EGRESOS</b>
                </h4>
                <ul class="row justify-content-end">
                    @can('Ver_Generar_Ingreso_Egreso_Boton')
                        <a wire:click.prevent="viewDetails()" class="btn btn-warning">
                            Generar Ingreso/Egreso en Cartera
                        </a>
                    @endcan
                </ul>
                {{-- <ul class="tabs tab-pills">
                    <a wire:click.prevent="EliminarTigoMoney()" class="btn btn-dark">
                        Eliminar tigo money
                    </a>
                </ul> --}}
                {{-- <ul class="tabs tab-pills">
                    <a wire:click.prevent="EliminarStreaming()" class="btn btn-dark">
                        Eliminar streaming
                    </a>
                </ul> --}}
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12">

                    <div class="form-group">
                        <label>Buscar</label>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                        </div>
                    </div>

                    


                </div>

                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                                            

                                    <label>Fecha inicial</label>
                                    <input type="date" wire:model="fromDate" class="form-control">
                                    @error('fromDate')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                   </div>
                </div>
                <div class="col-sm-12 col-md-2">
                   <div class="form-group">
                                    <label>Fecha final</label>
                                    <input type="date" wire:model="toDate" class="form-control">
                                    @error('toDate')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                   <div class="form-group">
                                    <label>Cajas</label>
                                    <select wire:model="caja" class="form-control">
                                        @foreach ($cajas2 as $item)
                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                        <option value="TODAS">TODAS</option>
                                       
                                    </select>
                                           
                    </div>
                </div>


                {{-- <div class="col-sm-12 col-md-12">
                    <h6 class="card-title">
                        <b>CARTERAS EN TU SUCURSAL:</b>
                    </h6>
                    @foreach ($carterasSucursal as $item)
                        <b>{{ $item->cajaNombre }},</b>
                        <b>{{ $item->carteraNombre }}: </b>
                        <b>${{ $item->monto }}.</b>
                        <br>
                    @endforeach
                </div> --}}

            
            </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                                <tr>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">#</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">FECHA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">TIPO DE MOVIMIENTO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">CAJA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">NOMBRE CARTERA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">IMPORTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">MOTIVO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">USUARIO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $p)
                                    <tr>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">{{ $loop->iteration }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{\Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->carteramovtype }}</h6>
                                        </td>
                                     
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->cajaNombre }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">{{ $p->nombre }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">{{ $p->import }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">{{ $p->comentario }}
                                            </h6>
                                        </td>
                                   
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->usuarioNombre }}</h6>
                                        </td>
                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
         
        </div>
    </div>
    @include('livewire.reportemovimientoresumen.modalDetails')
  
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg => {
            $('#modal-details').modal('show')
        })
        window.livewire.on('hide-modal', Msg => {
            $('#modal-details').modal('hide')
            noty(Msg)
        })
       
    });
</script>
