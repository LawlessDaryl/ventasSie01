@section('css')

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
<!-- END PAGE LEVEL STYLES -->



{{-- Modal --}}

<style>
    /* Estilos de etiqueta*/


table {
  background: white;
  width: 100%;
  margin: 0 auto;
  margin-top: 2%;
  border-collapse: collapse;
  text-align: center;
}

/*Pseudo-clases*/
.titulos {
  background-color: orange;
  color: black;
}

tr:hover {
  background-color: skyblue;
}
tr {
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

a{
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
                   <h3>Lista de Ventas</h3>
                </div>


                @if($this->verificarpermiso())
                <div class="col-lg-2 col-md-12 col-sm-12">
                        <div>
                            <h6>Seleccionar Usuario</h6>
                        </div>
                        <select wire:model="usuarioseleccionado" class="form-control">
                            @foreach ($listausuarios as $u)
                            <option value="{{$u->id}}">{{$u->nombreusuario}}</option>
                            @endforeach
                            <option value="Todos" selected>Todos los Usuarios</option>
                        </select>
                </div>
                @endif


            </div>



            <div class="table-responsive mb-4 mt-4">
                <table id="zero-config" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="table-th text-withe text-center">No</th>
                            <th class="table-th text-withe text-center">Cliente</th>
                            <th class="table-th text-withe text-center">Totales Bs</th>
                            <th class="table-th text-withe text-center">Usuario</th>
                            <th class="table-th text-withe text-center">Tipo Pago</th>
                            <th class="table-th text-withe text-center">¿Factura?</th>
                            <th class="table-th text-withe text-center">Observación</th>
                            <th class="table-th text-withe text-center">Fecha</th>
                            <th>Estado</th>
                            <th class="table-th text-withe text-center">Detalles</th>
                            @if($this->verificarpermiso())
                            <th class="table-th text-withe text-center" width="50px"> Acciònes</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>{{$loop->iteration}}</h6>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    
                                    <p>Ci:{{ $d->ci }}</p>
                                    <h6>{{ $d->rz }}</h6>
                                    <p>Celular:{{ $d->celular }}</p>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-right">
                                    <p>Descuento Bs {{number_format( $this->totaldescuento($d->id), 2) }}</p>
                                    <h6><b>Total Bs {{number_format( $d->totalbs - $d->cambio, 2) }}</b></h6>
                                    <p>Cambio Bs {{number_format( $d->cambio, 2) }}</p>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>{{ $d->user }}</h6>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>{{ $d->tipopago }}</h6>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>{{ $d->factura }}</h6>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>{{ $d->obs }}</h6>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>
                                        {{\Carbon\Carbon::parse($d->fecha)->format('d-m-Y')}}
                                        <br>
                                        {{\Carbon\Carbon::parse($d->fecha)->format('h:i:s a')}}
                                    </h6>
                                </td>
                                @if($d->status == 'CANCELED')
                                <td>
                                    <div class="table-th text-withe text-center">
                                        <h6 style="color: rgb(237, 0, 0);"><b>Anulado</b></h6>
                                    </div>
                                </td>
                                @else
                                <td>
                                    <div class="table-th text-withe text-center">
                                        <h6  style="color: rgb(14, 207, 43);"><b>Normal</b></h6>
                                    </div>
                                </td>
                                @endif
                                <td style="padding: 0%"  class="table-th text-withe text-center">
                                      <div class="btn-group" role="group" aria-label="Basic example">
                                        <button wire:click="cambiaridventa({{ $d->id }})" type="button" class="btn btn-secondary" style="background-color: rgb(12, 100, 194)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                        </button>
                                      </div>
                                </td>
                                @if($this->verificarpermiso())
                                <td style="padding: 0%"  class="table-th text-withe text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        @if($d->status != 'CANCELED')
                                        <button wire:click="mostraranularmodal({{$d->id}})" title="Anular Venta" type="button" class="btn btn-secondary" style="background-color: crimson">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                        Anular
                                        </button>
                                        <button title="Modificar Usuario Vendedor" type="button" class="btn btn-secondary" style="background-color: dodgerblue">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                                @endif
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
        
    });




</script>

@endsection

