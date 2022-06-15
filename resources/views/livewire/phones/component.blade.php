<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal" 
                        data-target="#theModal">Agregar</a>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe">NOMBRE</th>                                
                                <th class="table-th text-withe text-center">TELÉFONO</th>
                                <th class="table-th text-withe text-center">DESCRIPCIÓN</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">SUCURSAL</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($telfs as $t)
                                <tr>
                                    <td>
                                        <h6>{{ $t->name }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $t->phone }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $t->description }}</h6>
                                    </td>
                                    <td>
                                        <h6 class=" text-center">{{ $t->status }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $t->sucursal }}</h6>
                                    </td>                                  
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $t->id }})"
                                            class="btn btn-warning mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $t->id }}','{{ $t->phone }}')"
                                            class="btn btn-warning" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $telfs->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.phones.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide'),
            noty(msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-deleted', msg => {
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

    function Confirm(id, name) {
        /* if (cuentas > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la cuenta, ' + name + ' porque tiene ' +
                    cuentas + ' perfiles relacionadas'
            })
            return;
        } */
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la cuenta ' + '"' + name + '"',
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
