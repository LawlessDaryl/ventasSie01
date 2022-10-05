
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">

                    <a href="javascript:void(0)" class="btn btn-warning" wire:click="Detailspago()">Agregar</a>

                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe">NOMBRE</th>
                                <th class="table-th text-withe">FECHA INICIO</th>
                                <th class="table-th text-withe text-center">PROXIMO PAGO</th>
                                <th class="table-th text-withe text-center">DESCRIPCION</th>
                                <th class="table-th text-withe text-center">PAGOS TOTALES</th>
                                <th class="table-th text-withe text-center">PAGO POR MES</th>
                                <th class="table-th text-withe text-center">PAGO POR AÑO</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $salaries)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $salaries->name }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $salaries->fechaInicio }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $salaries->fechaFin }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $salaries->descripcion }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $salaries->totalPagos }}
                                        </h6>
                                    </td>
                                    <td>
                                        @if($salaries->salarioMes == 'null')
                                        <h6 class="text-center">null</h6>
                                        @else
                                        <h6 class="text-center">{{ number_format($salaries->salarioMes, 2) }} Bs.
                                        </h6>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $salaries->salarioAño }}     
                                        </h6>
                                    </td>

                                    <td class="text-center">
                       
                                        <a href="javascript:void(0)"  wire:click="Detailspago({{ $salaries->id }})"
                                            class="btn mtmobile" title="Ver detalles de la venta" style="background-color: rgb(10, 137, 235); color:white">
                                            <i class="fas fa-bars"></i>
                                        </a>
                                        <a href="javascript:void(0)" wire:click="Edit({{ $salaries->id }})"
                                            class="btn btn-warning mtmobile" title="Editar registro">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $salaries->id }}','{{ $salaries->name }}')" 
                                            class="btn btn-warning" title="Eliminar registro">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="4"><h6 class="text-center" style="font-size: 20px">TOTALES:</h6></td>
                            <td class="text-center">
                                @if($pagototalmes != 'null' )
                                    <h6 class="" style="font-size: 20px">{{ number_format($pagototalmes,2)}} Bs.</h6>
                                @else
                                <h6 class="" style="font-size: 20px">0 Bs.</h6>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($pagototalaño != 'null' )
                                    <h6 class="" style="font-size: 20px">{{ number_format($pagototalaño,2)}} Bs.</h6>
                                @else
                                <h6 class="" style="font-size: 20px"> 0 Bs.</h6>
                                @endif
                            </td>
                            
                        </tfoot>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>

    @include('livewire.salaries.salariedetail')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        window.livewire.on('detalles', Msg => {
            $('#detail').modal('show')
        });

        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-update', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('role-deleted', Msg => {
            noty(Msg)
        });
        window.livewire.on('item-exists', Msg => {
            noty(Msg)
        });
        window.livewire.on('item-error', Msg => {
            noty(Msg)
        });
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', Msg => {
            $('#theModal').modal('hide')
        });


    });

    function Confirm(id, name) {
        console.log('hola');
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el permiso ' + '"' + name + '"',
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
