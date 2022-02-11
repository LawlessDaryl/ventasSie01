<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal" wire:click="GoService">Agregar</a>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-striped mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">NOMBRE CLIENTE</th>
                                <th class="table-th text-withe text-center">CÓDIGO</th>
                                <th class="table-th text-withe text-center">TIPO DE SERVICIO</th>
                                <th class="table-th text-withe text-center">SERVICIOS</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">TOTAL</th>
                                <th class="table-th text-withe text-center">A CUENTA</th>
                                <th class="table-th text-withe text-center">SALDO</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <h6 class="table-th text-withe text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    @php
                                        $mytotal = 0;
                                        $myacuenta = 0;
                                        $mysaldo = 0;
                                    @endphp
                                    <td>
                                        @foreach ($item->services as $key => $service)
                                            @php
                                                $mytotal += $service->movservices[0]->movs->import;
                                                $myacuenta += $service->movservices[0]->movs->on_account;
                                                $mysaldo += $service ->movservices[0]->movs->saldo;
                                            @endphp
                                            @if (count($item->services) - 1 == $key)
                                                <h6 class="table-th text-withe text-center">
                                                    {{ $service->movservices[0]->movs->climov->client->nombre }}</h6>
                                            @endif

                                        @endforeach
                                    </td>
                                    
                                    <td>
                                        <h6 class="table-th text-withe text-center">{{ $item->id }}</h6>
                                    </td>

                                    <td>
                                        <h6 class="table-th text-withe text-center">{{ $item->type_service }}</h6>
                                    </td>

                                    <td>
                                        @foreach ($item->services as $key => $service)

                                            <h6>
                                                {{ $service->categoria->nombre }}&nbsp{{ $service->marca }}&nbsp | {{ $service->detalle }}&nbsp | {{ $service->falla_segun_cliente }}
                                            </h6><br/>

                                            @if (count($item->services) - 1 != $key)
                                                <hr
                                                    style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                                <br />
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach ($item->services as $key => $service)
                                            @foreach ($service->movservices as $mm)
                                                @if ($mm->movs->status == 'ACTIVO')
                                                    <h6 class="table-th text-withe">{{ $mm->movs->type }}</h6><br/>
                                                    @if (count($item->services) - 1 != $key)
                                                        <hr
                                                            style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                                        <br />
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>

                                    <td class="text-center">
                                        <h6 class="text-info">
                                            {{ number_format($mytotal, 2) }} Bs.
                                        </h6>
                                    </td>

                                    <td class="text-center">
                                        <h6 class="text-info">
                                            {{ number_format($myacuenta, 2) }} Bs.
                                        </h6>
                                    </td>

                                    <td class="text-center">
                                        <h6 class="text-info">
                                            {{ number_format($mysaldo, 2) }} Bs.
                                        </h6>
                                    </td>

                                    <td class="text-center">
                                        @foreach ($item->services as $key => $service)
                                            @if($mm->movs->type == 'PENDIENTE')
                                                <a href="javascript:void(0)" class="btn btn-dark mtmobile" 
                                                title="Cambiar Estado" data-toggle="modal" 
                                                data-target="#theModal">PENDIENTE</a><br/><br/>

                                                @if (count($item->services) - 1 != $key)
                                                <hr
                                                    style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                                <br />
                                                @endif

                                                
                                            @elseif($mm->movs->type == 'PROCESO')
                                                <a href="javascript:void(0)" class="btn btn-dark mtmobile" 
                                                title="Cambiar Estado">PROCESO</a>

                                                @if (count($item->services) - 1 != $key)
                                                <hr
                                                    style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                                <br />
                                                @endif
                                            
                                            @elseif($mm->movs->type == 'TERMINADO')
                                                <a href="javascript:void(0)" class="btn btn-dark mtmobile" 
                                                title="Cambiar Estado">TERMINADO</a>
                                            
                                                @if (count($item->services) - 1 != $key)
                                                <hr
                                                    style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                                <br />
                                                @endif

                                            @endif

                                        @endforeach

                                        {{--<a href="javascript:void(0)"
                                            onclick="Confirm('{{ $item->id }}','{{ $item->category }}','{{ $item->marca }}')"
                                            class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>--}}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.order_service.form')
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
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
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

    function ChangeStates()
    {
        
    }

</script>
