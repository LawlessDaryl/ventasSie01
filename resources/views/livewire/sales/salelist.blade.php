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

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            
            
            <div class="row text-center">
                            
                <div class="col-lg-10 col-md-12 col-sm-12">
                   <h2>Lista de Ventas</h2>
                </div>


                @if($this->verificarpermiso())
                <div class="col-lg-2 col-md-12 col-sm-12">
                        <div>
                            <h6>Seleccionar Usuario</h6>
                        </div>
                        <select wire:model="usuarioseleccionado" class="form-control">
                            <option value="Todos" selected><b>Todos los Usuarios</b></option>
                            @foreach ($listausuarios as $u)
                            <option value="{{$u->id}}">{{$u->nombreusuario}}</option>
                            @endforeach
                        </select>
                </div>
                @endif


            </div>



            <div class="table-responsive mb-4 mt-4">
                <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4" style="min-width: 1500px;">
                    <thead class="text-white" style="background: #ee761c">
                        <tr>
                            <th class="table-th text-withe text-center">Código Venta</th>
                            <th class="table-th text-withe text-center">Cliente</th>
                            <th class="table-th text-withe text-center">Totales Bs</th>
                            <th class="table-th text-withe text-center">Usuario</th>
                            <th class="table-th text-withe text-center">Tipo Pago</th>
                            <th class="table-th text-withe text-center">¿Factura?</th>
                            <th class="table-th text-withe text-center">Observación</th>
                            <th class="table-th text-withe text-center">Fecha</th>
                            <th class="table-th text-withe text-center">Estado</th>
                            <th class="table-th text-withe text-center"> Acciònes</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td class="table-th text-withe text-center">
                                    <span class="stamp stamp" style="background-color: #ee761c">
                                        {{$d->id}}
									</span>
                                </td>
                                <td class="table-th text-withe text-center">
                                    Ci:{{ $d->ci }}
                                    <br>
                                    <b>{{ $d->rz }}</b>
                                    <br>
                                    Celular:{{ $d->celular }}
                                </td>
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
                                    {{ $d->tipopago }}
                                </td>
                                <td class="text-center">
                                    {{ $d->factura }}
                                </td>
                                <td class="text-center">
                                    {{ $d->obs }}
                                </td>
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
                                        <button wire:click="cambiaridventa({{ $d->id }})" class="btn btn" title="Ver detalles de la venta" style="background-color: rgb(10, 137, 235); color:white">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        @if($this->verificarpermiso())
                                            @if($d->status != 'CANCELED')
                                            <button wire:click="mostraranularmodal({{$d->id}})" class="btn btn" title="Anular Venta" style="background-color: red; color:white">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button wire:click="editsale({{$d->id}})" class="btn btn" title="Editar Venta" style="background-color: rgb(13, 175, 220); color:white">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @endif
                                        @endif
                                        <button wire:click="crearcomprobante({{$d->id}})" class="btn btn" title="Crear Comprobante" style="background-color: rgb(0, 104, 21); color:white">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>

        @include('livewire.sales.salelistmodaldetalles')
        @include('livewire.sales.salelistmodalanular')



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
        
    });




</script>

@endsection

