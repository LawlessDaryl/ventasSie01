<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>INGRESOS Y EGRESOS</b>
                </h4>

                <ul class="row justify-content-end">
              
                </ul>
                <ul class="row justify-content-end">
                    @can('Ver_Generar_Ingreso_Egreso_Boton')
                        <a wire:click.prevent="viewDetails()" class="btn btn-dark text-white">
                            <i class="fas fa-arrow-alt-circle-down" ></i>  <i class="fas fa-arrow-alt-circle-up" ></i> Generar Ingreso/Egreso
                        </a>
                        <a wire:click.prevent="generarpdf({{$data}})" class="btn btn-warning">
                          <i class="fas fa-print" ></i>  Generar PDF
                        </a>
                    @endcan
                </ul>
              
            </div>
            <div class="row">

                <div class="col-sm-12 col-md-12 d-flex">
                    @foreach ($grouped as $key=>$item)
                    <div class="card m-2 p-2" style="width: 18rem;">
                    
                        <h6 class="card-title">
                            <b>Caja: {{ $key }},</b>
                            
                        </h6>
                        @foreach ($item as $dum)
                            
                       <div>{{$dum->carteraNombre}}:{{$dum->monto}}</div> 
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group" >
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
                <div class="col-sm-12 col-md-2">
                   <div class="form-group">
                                    <label>Sucursal</label>
                                    <select wire:model="sucursal" class="form-control">
                                        @foreach ($sucursals as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                           
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                   <div class="form-group">
                                    <label>Categoria</label>
                                    <select wire:model='categoria_id' class="form-control">
                                        <option value="Todos">Todas las Categorias</option>
                                        @foreach ($categorias as $c)
                                            <option value="{{ $c->id }}">{{ $c->nombre }} - {{ $c->tipo }}</option>
                                        @endforeach
                                    </select>
                                           
                    </div>
                </div>

            </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #02b1ce">
                                <tr>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">#</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">FECHA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">MOVIMIENTO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">CATEGORIA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">CAJA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">CARTERA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">IMPORTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">MOTIVO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">USUARIO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">ESTADO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">ACC.</th>
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
                                                @if($p->nombrecategoria != null)
                                                    <b>{{ $p->nombrecategoria }}</b>
                                                @else
                                                    Sin Categoria
                                                @endif


                                            </h6>
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
                                            <h6 class="text-center" style="font-size: 100%">  {{ number_format($p->import,2) }}
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

                                        @if( $p->movstatus == 'ACTIVO')
                                        <td>
                                            <h6 class="text-center text-white bg-primary">{{ $p->movstatus }}</h6>
                                        </td>
                                        @else
                                        <td>
                                            <h6 class="text-center text-white bg-danger">ANULADO</h6>
                                        </td>
                                        @endif

                                        @if ($p->movstatus == 'INACTIVO')

                                        <td>
                                            <div class="btn-group m-1" role="group" aria-label="Basic example">
                                                <button disabled  wire:click="anularOperacion({{$p->movid}})" class="btn btn-sm" title="sin accion" style="background-color: rgb(10, 137, 235); color:white">
                                                    <i class="la flaticon-cross"></i>
                                                </button>
                                            
                                            </div>
                                        </td>
                                        @else
                                            
                                        <td>
                                            <div class="btn-group m-1" role="group" aria-label="Basic example">
                                                <button href="javascript:void(0)" onclick="Confirm('{{ $p->movid }}')" class="btn btn-sm" title="Anular Ingreso/Egreso" style="background-color: rgb(10, 137, 235); color:white">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                             
                                                <button  wire:click="editarOperacion({{$p->movid}})" class="btn btn-sm" title="Editar Ingreso/egreso" style="background-color: rgb(0, 104, 21); color:white">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                       
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>

                                    <td colspan="5">
                                        <h6 class="text-right p-l-1" colspan="5" style="font-size: 100%">
                                         <b>TOTAL Bs.</b></h6>
                                    </td>
                                    <td colspan="1">
                                        <h6 class="text-center" colspan="5" style="font-size: 100%">
                                          {{ number_format($sumaTotal,2) }} </h6>
                                    </td>
                                </tr>
                                <tr>

                                    <td colspan="5">
                                        <h6 class="text-right p-l-1" colspan="5" style="font-size: 100%">
                                         <b>TOTAL $us.</b></h6>
                                    </td>
                                    <td colspan="1">
                                        <h6 class="text-center" colspan="5" style="font-size: 100%">
                                            {{ number_format($sumaTotal/$cot_dolar,2) }} </h6>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
         
        </div>
    </div>
    @include('livewire.reportemovimientoresumen.modalDetails')
    @include('livewire.reportemovimientoresumen.modaleditar')
  
</div>

@section('javascript')

<script>

    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg => {
            $('#modal-details').modal('show')
        });
        window.livewire.on('editar-movimiento', Msg => {
            $('#modal-mov').modal('show')
            });
            window.livewire.on('hide_editar', Msg => {
                $('#modal-mov').modal('hide')
            });
            window.livewire.on('hide-modal', Msg => {
                $('#modal-details').modal('hide')
                noty(Msg)
            });
            
            window.livewire.on('openothertap', Msg => {
                var win = window.open('report/pdfingresos');
                // Cambiar el foco al nuevo tab (punto opcional)
                //win.focus();
                
            });
        });
        

  
    function Confirm(id){
        
        Swal.fire({
            title: 'Esta seguro de anular esta operacion?',
            text: "Esta accion es irreversible",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.value) {
                
                window.livewire.emit('eliminar_operacion',id);
                
                Swal.fire(
                    'Anulado!',
                    'El registro fue anulado con exito',
                    'success'
                    )
                }
            })
            
        }
        
        
        </script>
        
        <script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
    
@endsection