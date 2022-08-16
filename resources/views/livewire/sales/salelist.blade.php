@section('css')

<style>

.estilostable {
  background: white;
  width: 100%;
  margin: 0 auto;
  margin-top: 2%;
  border-collapse: collapse;
  text-align: center;
}

.estilostr:hover {
  background-color: skyblue;
}
.estilostr {
  color: black;
}

/* Estililos de clases*/

.Cabecera {
  background-color: white;
  border-radius: 4px;
  height: 30px;
  padding: 2em;
  margin: 0 25%;
  text-align: center;
  color: white;
}

.estilosa{
  text-decoration: none;
  color: white;
  font-size: 14pt;
}
</style>

@endsection

<div class="row layout-top-spacing" id="cancel-row">

    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            
            
            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-12 col-md-4 text-center">

                    </div>

                    <div class="col-12 col-sm-12 col-md-4 text-center">
                        <h2><b>Lista de Ventas</b></h2>
                        Ordenados por Fecha de Venta
                    </div>

                    <div class="col-12 col-sm-12 col-md-4">
                        <ul class="tabs tab-pills text-right">
                            <a href="javascript:void(0)" wire:click="irservicio()" class="btn btn-outline-primary">Nueva Venta</a>

                            <div class="custom-control custom-switch" style="padding-top: 5px;">
                                <input type="checkbox" class="custom-control-input" id="customSwitches"
                                wire:change="mostrarocultarmasfiltros()" {{ $masfiltros ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customSwitches">+Filtros</label>
                            </div>
                            
                        </ul>
                    </div>

                </div>
            </div>











            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b wire:click="limpiarsearch()" style="cursor: pointer;">Buscar...</b>
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="search" placeholder="Busqueda General..." class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccionar Sucursal</b>
                        <div class="form-group">
                            <select wire:model="sucursal_id" class="form-control">
                                @foreach($listasucursales as $sucursal)
                                <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                @endforeach
                                <option value="Todos">Todas las Sucursales</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccionar Caja</b>
                        <div class="form-group">
                            <select wire:model.lazy="user_id" class="form-control">
                                <option value="Todos" selected>Todos</option>
                                @foreach ($listausuarios as $u)
                                    <option value="{{ $u->idusuario }}">{{ ucwords(strtolower($u->nombreusuario)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccione Cartera</b>
                        <div class="form-group">
                            <select wire:model="caja_id" class="form-control">
                                <option value="PENDIENTE">Pendientes</option>
                                <option value="PROCESO">Proceso</option>
                                <option value="TERMINADO">Terminados</option>
                                <option value="ENTREGADO">Entregados</option>
                                <option value="ABANDONADO">Abandonados</option>
                                <option value="ANULADO">Anulados</option>
                                <option value="Todos">Todos</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccionar Usuario</b>
                        <div class="form-group">
                            <select wire:model="sucursal_id" class="form-control">
                                @foreach($listasucursales as $sucursal)
                                <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                @endforeach
                                <option value="Todos">Todas las Sucursales</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Tipo de Fecha</b>
                        <div class="form-group">
                            <select wire:model.lazy="user_id" class="form-control">
                                <option value="Todos" selected>Todos</option>
                                @foreach ($listausuarios as $u)
                                    <option value="{{ $u->idusuario }}">{{ ucwords(strtolower($u->nombreusuario)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Fecha Inicio</b>
                        <div class="form-group">
                            <input @if ($tipofecha != 'Rango') disabled @endif type="date" wire:model="dateFrom" class="form-control flatpickr" >
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Fecha Fin</b>
                        <div class="form-group">
                            <input @if ($tipofecha != 'Rango') disabled @endif type="date" wire:model="dateTo" class="form-control flatpickr" >
                        </div>
                    </div>

                </div>
            </div>


















            <div class="table-responsive mb-4 mt-4">
                <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4" style="min-width: 1000px;">
                    <thead class="text-white" style="background: #ee761c">
                        <tr>
                            <th class="table-th text-withe text-center">#</th>
                            @if($mostrarcliente == 'Si')
                            <th class="table-th text-withe text-center">Cliente</th>
                            @endif
                            <th class="table-th text-withe text-center">Totales Bs</th>
                            <th class="table-th text-withe text-center">Usuario</th>
                            <th class="table-th text-withe text-center">Tipo Pago</th>
                            {{-- <th class="table-th text-withe text-center">¿Factura?</th> --}}
                            {{-- <th class="table-th text-withe text-center">Observación</th> --}}
                            <th class="table-th text-withe text-center">Fecha</th>
                            <th class="table-th text-withe text-center">Estado</th>
                            <th class="table-th text-withe text-center"> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($listaventas as $d)
                            <tr>
                                <td class="table-th text-withe text-center">
                                    <span class="stamp stamp" style="background-color: #ee761c">
                                        {{$d->id}}
									</span>
                                </td>
                                @if($mostrarcliente == 'Si')
                                <td class="table-th text-withe text-center">
                                    Ci:{{ $d->ci }}
                                    <br>
                                    <b>{{ $d->rz }}</b>
                                    <br>
                                    Celular:{{ $d->celular }}
                                </td>
                                @endif
                                <td class="table-th text-withe text-center">
                                    @if($this->totaldescuento($d->id) > 0)
                                        Recargo Bs {{number_format( $this->totaldescuento($d->id), 2) }}
                                        <br>
                                        <b>Total Bs {{number_format( $d->totalbsventa, 2) }}</b>
                                        <br>
                                        Cambio Bs {{number_format( $d->cambio, 2) }}
                                    @else
                                        Descuento Bs {{number_format( $this->totaldescuento($d->id), 2) }}
                                        <br>
                                        <b>Total Bs {{number_format( $d->totalbsventa, 2) }}</b>
                                        <br>
                                        Cambio Bs {{number_format( $d->cambio, 2) }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $d->user }}
                                </td>
                                <td class="text-center">
                                    {{ $d->cartera }}
                                </td>
                                {{-- <td class="text-center">
                                    {{ $d->factura }}
                                </td> --}}
                                {{-- <td class="text-center">
                                    {{ $d->obs }}
                                </td> --}}
                                <td class="table-th text-withe text-center">
                                    {{\Carbon\Carbon::parse($d->fecha)->format('d-m-Y')}}
                                    <br>
                                    {{\Carbon\Carbon::parse($d->fecha)->format('h:i:s a')}}
                                </td>
                                @if($d->status == 'CANCELED')
                                <td class="table-th text-withe text-center">
                                    <span class="stamp stamp-md bg-danger mr-3">
										ANULADO
									</span>
                                </td>
                                @else
                                <td class="table-th text-withe text-center">
                                    <span class="stamp stamp-md bg-success mr-3">
										NORMAL
									</span>
                                </td>
                                @endif
                                <td class="text-center">

                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button wire:click="cambiaridventa({{ $d->id }})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(10, 137, 235); color:white">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        @if($this->verificarpermiso())
                                            @if($d->status != 'CANCELED')
                                            <button wire:click="mostraranularmodal({{$d->id}})" class="btn btn-sm" title="Anular Venta" style="background-color: red; color:white">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button wire:click="editsale({{$d->id}})" class="btn btn-sm" title="Editar Venta" style="background-color: rgb(13, 175, 220); color:white">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="cambiarusuario({{$d->id}})" class="btn btn-sm" title="Cambiar Usuario Vendedor" style="background: #ee761c; color:white">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                            @endif
                                        @endif
                                        <button wire:click="crearcomprobante({{$d->id}})" class="btn btn-sm" title="Crear Comprobante" style="background-color: rgb(0, 104, 21); color:white">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                {{ $listaventas->links() }}
            </div>
        </div>

        @include('livewire.sales.salelistmodaldetalles')
        @include('livewire.sales.salelistmodalanular')
        @include('livewire.sales.modalcambiarusuario')



    </div>

</div>

@section('javascript')





<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal', msg => {
            $('#detalles').modal('show')
        });
        window.livewire.on('show-anular', msg => {
            $('#anular').modal('show')
        });
        window.livewire.on('show-anularcerrar', msg => {
            $('#anular').modal('hide')
        });
        window.livewire.on('show-editar', msg => {
            $('#editarventa').modal('show')
        });
        window.livewire.on('show-cam-user', msg => {
            $('#cambiarusuario').modal('show')
        });
        window.livewire.on('hide-cam-user', msg => {
            $('#cambiarusuario').modal('hide')
        });
        
    });




</script>

@endsection

