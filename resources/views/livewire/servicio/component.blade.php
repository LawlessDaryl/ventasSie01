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
                            @if (isset($cliente))
                                {{ $cliente->nombre }}
                            @else
                                NO DEFINIDO
                            @endif <br />

                            <b class="info-text">Fecha: </b>{{ $from }}<br />

                            <b class="info-text">Registrado por: </b>{{ $usuariolog }} <br />
                            <b class="info-text">Tipo de servicio: </b> {{ $typeservice }} <br />
                        </div>
                    </div>

                </div>
                @if ($orderservice == 0)
                    <ul class="tabs tab-pills">
                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                            data-target="#theClient">Asignar Cliente</a>
                    </ul>

                    <ul class="tabs tab-pills">
                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                            data-target="#theNewClient">Nuevo Cliente</a>
                    </ul>
                @endif
                @if (!empty($cliente))
                    <ul class="tabs tab-pills">
                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                            data-target="#theModal">Agregar Servicio</a>
                    </ul>
                @endif
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theTypeService">Tipo de Servicio</a>
                </ul>

            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe">#</th>

                                <th class="table-th text-withe text-center">EQUIPO</th>

                                <th class="table-th text-withe text-center">MARCA</th>
                                <th class="table-th text-withe text-center">DETALLE</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">TOTAL</th>
                                <th class="table-th text-withe text-center">A CUENTA</th>
                                <th class="table-th text-withe text-center">SALDO</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $product)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{ $product->category }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $product->marca }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $product->detalle }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $product->tipo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $product->import }}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{ $product->on_account }}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{ $product->saldo }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $product->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $product->id }}')"
                                            class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
                    <button class="btn btn-dark mb-2">Guardar</button>
                    <button class="btn btn-dark mb-2">Salir</button>
                </ul>
            </div>
        </div>
    </div>
    @include('livewire.servicio.formclientebuscar')

    @include('livewire.servicio.formclientenuevo')
    @include('livewire.servicio.formservicio')
    {{-- @include('livewire.servicio.formtiposervicio') --}}
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
        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });
    });

    function Confirm(id, name, clients) {
        if (clients > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el servicio, ' + name + ' porque tiene ' +
                    clients + ' clientes relacionados'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el prouducto ' + '"' + name + '"',
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
