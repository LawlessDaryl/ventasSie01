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
.PrecioTotal:hover,
.CantidadTotal:hover {
  color: rgb(230, 50, 50);
}

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



{{-- <div class="page-header">
    <div class="page-title">
        <h3>Ventas</h3>
    </div>
</div> --}}

<div class="row layout-top-spacing" id="cancel-row">

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="zero-config" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="table-th text-withe text-center">No</th>
                            <th class="table-th text-withe text-center">Cliente</th>
                            <th class="table-th text-withe text-center">Totales Bs</th>
                            <th class="table-th text-withe text-center">Usuario</th>
                            <th class="table-th text-withe text-center">Tipo Pago</th>
                            <th class="table-th text-withe text-center">Fecha</th>
                            <th class="table-th text-withe text-center">Detalles</th>
                            <th class="table-th text-withe text-center" width="50px"> Acciònes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($data) < 1) <tr>
                            <td colspan="7">
                                <h5>Sin Resultados</h5>
                            </td>
                            </tr>
                            @endif

                            @foreach ($data as $d)
                            <tr>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>{{ $d->id }}</h6>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    
                                    <p>Ci:{{ $d->ci }}</p>
                                    <h6>{{ $d->rz }}</h6>
                                    <p>Celular:{{ $d->celular }}</p>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-right">
                                    <p>Descuento Bs {{number_format( $d->totalbs, 2) }}</p>
                                    <h6>Total Bs {{number_format( $d->totalbs, 2) }}</h6>
                                    <p>Cambio Bs {{number_format( $d->cambio, 2) }}</p>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>{{ $d->user }}</h6>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>{{ $d->tipopago }}</h6>
                                </td>
                                <td style="padding: 0%" class="table-th text-withe text-center">
                                    <h6>
                                        {{\Carbon\Carbon::parse($d->fecha)->format('d-m-Y')}}
                                        <br>
                                        {{\Carbon\Carbon::parse($d->fecha)->format('h:i:s a')}}
                                    </h6>
                                </td>
                                <td style="padding: 0%"  class="table-th text-withe text-center">
                                      <div class="btn-group" role="group" aria-label="Basic example">
                                        <button wire:click="cambiaridventa({{ $d->id }})" type="button" class="btn btn-primary mb-2 mr-2">
                                            Detalles
                                          </button>
                                    </div>
                                </td>
                                <td style="padding: 0%"  class="text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button title="Anular Venta" type="button" class="btn btn-secondary" style="background-color: crimson">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                        </button>
                                        <button title="Modificar Usuario Vendedor" type="button" class="btn btn-secondary" style="background-color: dodgerblue">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @include('livewire.sales.modalsalelist')

    </div>

</div>

@section('javascript')
 <script src="plugins/table/datatable/datatables.js"></script>
 <script>
     $('#zero-config').DataTable({
         "oLanguage": {
             "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
             "sInfo": "Mostrando Página _PAGE_ de _PAGES_",
             "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
             "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Filas :  _MENU_",
         },
         "stripeClasses": [],
         "lengthMenu": [7, 10, 20, 50],
         "pageLength": 7 
     });
 </script>









<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('show-modal', msg => {
            $('#detalles').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
    });
</script>

@endsection

