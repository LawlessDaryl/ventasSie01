<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">

                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Agregar</a>

                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">NOMBRE</th>
                                <th class="table-th text-withe text-center">TIPO</th>
                                <th class="table-th text-withe text-center">MONTO AFECTADO</th>
                                <th class="table-th text-withe text-center">MONTO INICIAL</th>
                                <th class="table-th text-withe text-center">MONTO FINAL</th>
                                <th class="table-th text-withe text-center">COMISIÓN</th>
                                <th class="table-th text-withe text-center">PORCENTAJE</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $item->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->tipo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->monto_a }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ number_format($item->monto_inicial, 2) }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ number_format($item->monto_final, 2) }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ number_format($item->comision, 2) }}</h6>
                                    </td>
                                    <td class="text-center">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            style="{{ $item->porcentaje == 'Activo' ? 'color: #29a727' : 'color: #f50707' }}"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-toggle-{{ $item->porcentaje == 'Activo' ? 'right' : 'left' }}">
                                            <rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect>
                                            <circle cx="{{ $item->porcentaje == 'Activo' ? '16' : '8' }}" cy="12"
                                                r="3">
                                            </circle>
                                        </svg>

                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $item->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $item->id }}','{{ $item->nombre }}',
                                        {{ $item->relacionados->count() }})" class="btn btn-dark" title="Delete">
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
        </div>
    </div>
    @include('livewire.comisiones.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-deleted', msg => {
            noty(Msg)
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
    });

    function Confirm(id, nombre,transaccions) {
        if (transaccions > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la comisión "' + nombre + '" porque existen ' 
                + transaccions + ' tipos de transacciones "origen - motivo" con esta comisión asignada.'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmar eliminar la comisión ' + '"' + nombre + '"?',
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
