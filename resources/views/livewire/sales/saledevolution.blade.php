<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <p class=""> <h3>Total Ventas: 0 Bs</h3> </p>
                </ul>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Devolución Por Venta</a>
                        
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal" data-target="#devolucionProducto"
                    >Devolución Por Producto</a>
                </ul>
                
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">No</th>
                                <th class="table-th text-withe text-center">Fecha Devolución</th>
                                <th class="table-th text-withe text-center">Tipo de Devolución</th>
                                <th class="table-th text-withe text-center">Observación</th>
                                <th class="table-th text-withe text-center">Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $item->id }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $item->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        @include('livewire.sales.modalproducto')


    </div>
</div>