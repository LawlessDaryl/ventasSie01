<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">

                    <a href="javascript:void(0)" class="btn btn-warning" wire:click="Agregar()">Agregar</a>

                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe">ID</th>
                                <th class="table-th text-withe">Nombre</th>
                                <th class="table-th text-withe text-center">Lunes</th>
                                <th class="table-th text-withe text-center">Martes</th>
                                <th class="table-th text-withe text-center">Miercoles</th>
                                <th class="table-th text-withe text-center">Jueves</th>
                                <th class="table-th text-withe text-center">Viernes</th>
                                <th class="table-th text-withe text-center">Sabado</th>
                                <th class="table-th text-withe text-center">Domingo</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $shift)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $shift->name }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $shift->monday }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $shift->tuesday }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $shift->wednesday }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $shift->thursday }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $shift->friday }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $shift->saturday }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $shift->sunday }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $shift->id }})"
                                            class="btn btn-warning mtmobile" title="Editar registro">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $shift->id }}','{{ $shift->name }}','{{ $shift->usuarios }}')"
                                            class="btn btn-warning" title="Eliminar registro">
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
    @include('livewire.shifts.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-update', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('role-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('item-exists', Msg => {
            noty(Msg)
        })
        window.livewire.on('item-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('modal-hide', Msg => {
            $('#theModal').modal('hide')
        })


    });

    function Confirm(id, name, usuarios) {
        if (usuarios > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el Turno "' + name + '" porque hay ' +
                    usuarios + ' Empleados con ese Turno.'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el Turno ' + '"' + name + '"',
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
