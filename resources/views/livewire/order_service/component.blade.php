<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click="IrInicio">Ir a Inicio</a>
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click="GoService">Agregar</a>
                </ul>

            </div>

            {{-- SEARCH-> --}}
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-gp">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" wire:model="search" placeholder="Buscar" class="form-control">

                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <select wire:model.lazy="opciones" class="form-control">
                        <option value="PENDIENTE">PENDIENTE</option>
                        <option value="PROCESO">PROCESO</option>
                        <option value="TERMINADO">TERMINADO</option>
                        <option value="ENTREGADO">ENTREGADO</option>
                        <option value="ABANDONADO">ABANDONADO</option>
                        <option value="fechas">POR FECHA</option>
                    </select>
                    @error('opciones')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            


            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-striped mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center" width="2%">#</th>
                                <th class="table-th text-withe text-center" width="60%">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="row">
                                            <div class="col-sm-1">CLIENTE</div>
                                            <div class="col-sm-2">FECHAS</div>
                                            <div class="col-sm-4">SERVICIOS</div>
                                            <div class="col-sm-5">ESTADO</div>
                                        </div>
                                    </div>
                                </th>
                                <th class="table-th text-withe text-center" width="7%">CÓDIGO</th>
                                <th class="table-th text-withe text-center" width="7%">TOTAL</th>
                                <th class="table-th text-withe text-center" width="10%">A CUENTA</th>
                                <th class="table-th text-withe text-center" width="7%">SALDO</th>
                                <th class="table-th text-withe text-center" width="7%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                @if ($item->status == 'ACTIVO')
                                    <tr>
                                        <td width="2%">
                                            <h6 class="table-th text-withe text-center">{{ $loop->iteration }}</h6>
                                        </td>
                                        @php
                                            $mytotal = 0;
                                            $myacuenta = 0;
                                            $mysaldo = 0;
                                        @endphp
                                        <td width="60%">

                                            @foreach ($item->services as $key => $service)
                                                @php
                                                    $mytotal += $service->movservices[0]->movs->import;
                                                    $myacuenta += $service->movservices[0]->movs->on_account;
                                                    $mysaldo += $service->movservices[0]->movs->saldo;
                                                @endphp
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="row">
                                                        {{-- CLIENTE --}}
                                                        <div class="col-sm-1">
                                                            @if ($key == 0)
                                                                <h6 class="table-th text-withe text-center"><b>
                                                                        {{ $service->movservices[0]->movs->climov->client->nombre }}</b>
                                                                </h6>
                                                            @endif
                                                        </div>
                                                        {{-- FECHA --}}
                                                        <div class="col-sm-2">
                                                            <h6 class="table-th text-withe text-center">
                                                                {{ $service->fecha_estimada_entrega }}</h6><br />
                                                        </div>
                                                        {{-- SERVICIOS --}}
                                                        <div class="col-sm-4">
                                                            <a href="javascript:void(0)"
                                                                wire:click="InfoService({{ $service->id }})"
                                                                title="Ver Servicio">
                                                                <h6>{{ $service->categoria->nombre }}&nbsp{{ $service->marca }}&nbsp
                                                                    | {{ $service->detalle }}&nbsp |
                                                                    {{ $service->falla_segun_cliente }}</h6>
                                                            </a>

                                                            @foreach ($service->movservices as $mm)
                                                                @if ($mm->movs->status == 'ACTIVO')
                                                                    <h6><b>Responsable:</b>
                                                                        {{ $mm->movs->usermov->name }}</h6>
                                                        </div>
                                                        {{-- ESTADO --}}
                                                        <div class="col-sm-5">
                                                            <div class="col-2 col-xl-6 col-lg-1 mb-xl-1 mb-1 ">
                                                                <h6 class="table-th text-withe text-center">
                                                                    <b>{{ $mm->movs->type }}</b></h6>
                                                                Serv: {{ $item->type_service }}
                                                            </div>
                                                            @if ($mm->movs->type == 'PENDIENTE')
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-dark mtmobile"
                                                                    wire:click="Edit({{ $service->id }})"
                                                                    title="Cambiar Estado">{{ $mm->movs->type }}</a>
                                                            @endif

                                                            @if (!empty(session('sesionCaja')))
                                                                @if ($mm->movs->type == 'TERMINADO')
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-dark mtmobile"
                                                                        wire:click="DetallesTerminado({{ $service->id }})"
                                                                        title="Cambiar Estado">Entregar</a>
                                                                @endif
                                                            @endif

                                                            @if ($mm->movs->type != 'ENTREGADO')
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-dark mtmobile"
                                                                    wire:click="Detalles({{ $service->id }})"
                                                                    title="Cambiar Estado">Detalle</a>
                                                            @endif

                                                            @if ($mm->movs->type == 'ENTREGADO')
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-dark mtmobile"
                                                                    wire:click="DetalleEntregado({{ $service->id }})"
                                                                    title="Ver Detalle">Detalle Entregado</a>
                                                            @endif

                                                            @if (count($item->services) - 1 != $key)
                                                                <br />
                                                            @endif
                                            @endif
                                @endforeach
                </div>
            </div>
            {{-- BORDE ENTRE SERVICIOS --}}
            @if (count($item->services) - 1 != $key)
                <hr
                    style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                <br />
            @endif
        </div>
        @endforeach
        </td>

        {{-- CODIGO --}}
        @if ($item->id < 10)
            <td class="text-center" width="7%">
                <h6 class="table-th text-withe text-center">000{{ $item->id }}</h6>
            </td>
        @endif
        @if ($item->id < 100 && $item->id >= 10)
            <td class="text-center" width="7%">
                <h6 class="table-th text-withe text-center">00{{ $item->id }}</h6>
            </td>
        @endif
        @if ($item->id < 1000 && $item->id >= 100)
            <td class="text-center" width="7%">
                <h6 class="table-th text-withe text-center">0{{ $item->id }}</h6>
            </td>
        @endif
        @if ($item->id < 10000 && $item->id >= 1000)
            <td class="text-center" width="7%">
                <h6 class="table-th text-withe text-center">{{ $item->id }}</h6>
            </td>
        @endif
        {{-- TOTAL --}}
        <td class="text-center" width="7%">
            <h6 class="text-info">
                {{ number_format($mytotal, 2) }} Bs.
            </h6>
        </td>
        {{-- A CUENTA --}}
        <td class="text-center" width="10%">
            <h6 class="text-info">
                {{ number_format($myacuenta, 2) }} Bs.
            </h6>
        </td>
        {{-- SALDO --}}
        <td class="text-center" width="7%">
            <h6 class="text-info">
                {{ number_format($mysaldo, 2) }} Bs.
            </h6>
        </td>
        {{-- ACCIONES --}}
        <td class="text-center" width="7%">
            <a href="javascript:void(0)" class="btn btn-dark mtmobile" wire:click="VerOpciones({{ $item->id }})"
                title="Opciones">Opciones</a>
        </td>

        </tr>
        @endif
        @endforeach
        </tbody>
        </table>
        {{ $data->links() }}
    </div>
</div>
</div>
</div>
@include('livewire.order_service.form')
@include('livewire.order_service.formdetalle')
@include('livewire.order_service.formdetalleentrega')
@include('livewire.order_service.forminfoservicio')
@include('livewire.order_service.formopciones')
@include('livewire.order_service.formentregado')
@include('livewire.order_service.formeliminar')
@include('livewire.order_service.formanular')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide'),
                noty(msg)
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('product-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });

        window.livewire.on('show-detail', Msg => {
            $('#theDetail').modal('show')
        });
        window.livewire.on('detail-hide', msg => {
            $('#theDetail').modal('hide')
        });
        window.livewire.on('detail-hide-msg', msg => {
            $('#theDetail').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-detalle-entrega', Msg => {
            $('#theDetalleEntrega').modal('show')
        });
        window.livewire.on('hide-detalle-entrega', msg => {
            $('#theDetalleEntrega').modal('hide')
        });
        window.livewire.on('hide-detalle-entrega-msg', msg => {
            $('#theDetalleEntrega').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-infserv', Msg => {
            $('#theInfoService').modal('show')
        });
        window.livewire.on('hide-infserv', msg => {
            $('#theInfoService').modal('hide')
        });
        window.livewire.on('hide-infserv-msg', msg => {
            $('#theInfoService').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-options', Msg => {
            $('#theOptions').modal('show')
        });
        window.livewire.on('hide-options', msg => {
            $('#theOptions').modal('hide')
        });
        window.livewire.on('hide-options-msg', msg => {
            $('#theOptions').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-enddetail', Msg => {
            $('#theEndDetail').modal('show')
        });
        window.livewire.on('hide-enddetail', msg => {
            $('#theEndDetail').modal('hide')
        });
        window.livewire.on('hide-enddetail-msg', msg => {
            $('#theEndDetail').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-deletemodal', Msg => {
            $('#theDeleteModal').modal('show')
        });
        window.livewire.on('hide-deletemodal', msg => {
            $('#theDeleteModal').modal('hide')
        });
        window.livewire.on('hide-deletemodal-msg', msg => {
            $('#theDeleteModal').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-modalanular', Msg => {
            $('#ModalAnular').modal('show')
        });
        window.livewire.on('hide-modalanular', msg => {
            $('#ModalAnular').modal('hide')
        });
        window.livewire.on('hide-modalanular-msg', msg => {
            $('#ModalAnular').modal('hide')
            noty(msg)
        });

        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });
    });

    function Confirm(id, name, products) {
        if (products > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el producto, ' + name + ' porque tiene ' +
                    products + ' ventas relacionadas'
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

    function ChangeStates() {

    }
</script>
