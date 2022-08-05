@section('css')
<style>
/* Estilos para la Tabla - Ventana Modal Buscar Cliente*/
.table-wrapper {
    width: 100%;/* Anchura de ejemplo */
    height: 350px; /* Altura de ejemplo */
    overflow: auto;
}

.table-wrapper table {
    border-collapse: separate;
    border-spacing: 0;
}

.table-wrapper table thead {
    position: -webkit-sticky; /* Safari... */
    position: sticky;
    top: 0;
    left: 0;
}











.tablaservicios {
        width: 100%;
        /* min-width: 1100px; */
    }
    .tablaservicios thead {
        background-color: #1572e8;
        color: white;
    }
    .tablaservicios th, td {
        border: 0.5px solid #1571e894;
        /* padding: 4px; */
    }
    .tablaservicios tr:hover {
        background-color: rgba(0, 195, 255, 0.336);
    }


    /*Estilos Hora*/


    



</style>
 @endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h5 class="card-title">
                    <b>{{ $pageTitle }} {{ $orderservice == '0' ? 'NO DEFINIDO' : $orderservice }} </b>
                </h5>
            </div>
            <div class="widget-heading">


                <div class="col-12 col-xl-6 col-lg-12 mb-xl-5 mb-5 ">

                    <div class="d-flex b-skills">
                        <div>
                        </div>
                        <div class="infobox">
                            <b class="info-text">Cliente: </b>
                            @if (!empty($cliente))
                                {{ ucwords(strtolower($cliente->nombre)) }}
                            @else
                                NO DEFINIDO
                            @endif <br />

                            <b class="info-text">Fecha: </b>{{ $from }}<br />

                            <b class="info-text">Registrado por (Técnico Receptor): </b>{{ $usuariolog }} <br />
                            <b class="info-text">Tipo de servicio: </b> {{ $typeservice }} <br />
                        </div>
                    </div>

                </div>
               
                <div class=" row row-demo-grid"> 
                    <div  class="col-md-4 ml-auto">
                @if ($orderservice == 0 || $cliente == '')
                   
                        <a href="javascript:void(0)" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#theClient">ASIGNAR CLIENTE</a>
                   

                  
                        <a href="javascript:void(0)" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#theNewClient">NUEVO CLIENTE</a>
                 
                @endif
              
                @if (!empty($cliente))
              
               
                  
                        <a href="javascript:void(0)" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#theModal">AGREGAR SERVICIO</a>
                   
               
                @endif
                @if ($orderservice != 0)
                
                        <a href="javascript:void(0)" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#theType">TIPO DE SERVICIO</a>
                        
                @endif
            
            </div>
            </div>
           

            <div class="widget-content">
                <div class="table-wrapper">
                    <table class="tablaservicios">
                        <thead>
                            <tr>
                                <th class="table-th text-withe">#</th>
                                <th class="text-center">EQUIPO</th>
                                <th class="text-center">MARCA</th>
                                <th class="text-center">DETALLE</th>
                                <th class="text-center">ESTADO</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">A CUENTA</th>
                                <th class="text-center">SALDO</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->category }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->marca }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->detalle }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->tipo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->import }}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{ $item->on_account }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->saldo }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $item->id }})"
                                            class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($item->tipo != 'TERMINADO' && $item->tipo != 'ENTREGADO')
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $item->id }}','{{ $item->category }}','{{ $item->marca }}')"
                                            class="btn btn-outline-danger btn-sm" title="Eliminar Servicio">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
            <div class="modal-footer">

                <ul class="tabs tab-pills">
                    @if (!empty(session('od')))
                        <a class="btn btn-outline-primary" href="{{ url('reporte/pdf' . '/' . $orderservice) }}" 
                        target="_blank" wire:click="ResetSession">IMPRIMIR</a>
                    @endif
                    <button class="btn btn-outline-primary" wire:click="ResetSession">IR A ORDENES DE SERVICIOS</button>
                </ul>
            </div>
        </div>
    </div>
    @include('livewire.servicio.formclientebuscar')
    @include('livewire.servicio.formclientenuevo')
    @include('livewire.servicio.formservicio')
    @include('livewire.servicio.formtiposervicio')
</div>
</div> 
<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('client-selected', msg => {
            $('#theClient').modal('hide'),
                noty(msg)
        });
        window.livewire.on('service-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('tipoServ-updated', msg => {
            $('#theType').modal('hide')
            noty(msg)
        });
        window.livewire.on('service-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('item-error', msg => {
            noty(msg)
        });
        window.livewire.on('modalsearchc-show', msg => {
            $('#theClient').modal('show')
        });
        window.livewire.on('modalsearch-hide', msg => {
            $('#theClient').modal('hide')
        });
        window.livewire.on('modalclient-show', msg => {
            $('#theNewClient').modal('show')
        });
        window.livewire.on('modalclient-hide', msg => {
            $('#theNewClient').modal('hide')
        });
        window.livewire.on('modalclient-selected', msg => {
            $('#theNewClient').modal('hide'),
                noty(msg)
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('modal-selected', msg => {
            $('#theModal').modal('hide'),
                noty(msg)
        });
        window.livewire.on('modaltype-show', msg => {
            $('#theType').modal('show')
        });
        window.livewire.on('modaltype-hide', msg => {
            $('#theType').modal('hide')
        });
        window.livewire.on('modaltype-selected', msg => {
            $('#theType').modal('hide'),
                noty(msg)
        });


        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });
    });

    function Confirm(id, categoria, marca) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el servicio "' + categoria + '" de marca "' + marca + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>
