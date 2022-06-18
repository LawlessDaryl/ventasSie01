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
                                <th class="table-th text-withe">USUARIO</th>
                                <th class="table-th text-withe text-center">TELÉFONO</th>
                                <th class="table-th text-withe text-center">EMAIL</th>
                                <th class="table-th text-withe text-center">PERFIL</th>
                                <th class="table-th text-withe text-center">STATUS</th>
                                <th class="table-th text-withe text-center">SUCURSAL</th>
                                <th class="table-th text-withe text-center">IMAGEN</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $r)
                                <tr>
                                    <td>
                                        <h6>{{ $r->name }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $r->phone }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $r->email }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $r->profile }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $r->status == 'ACTIVE' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $r->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            @foreach ($r->sucursalusers as $su)
                                                @if ($su->estado == 'ACTIVO')
                                                    {{ $su->sucursal->name }}
                                                @endif
                                            @endforeach
                                        </h6>
                                    </td>

                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/usuarios/' . $r->imagen) }}" alt="imagen"
                                                class=" rounded" width="70px" height="70px">
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $r->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $r->id }}','{{ $r->name }}','{{ $r->movimientos->count() }}')"
                                            class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <button wire:click.prevent="viewDetails('{{ $r->id }}')"
                                            class="btn btn-dark">
                                            <i class="fas fa-list"></i>
                                        </button>
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
    @include('livewire.users.form')
    @include('livewire.users.modalDetails')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('sucursal-actualizada', Msg => {
            $('#modal-details').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('item-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('item-error', Msg => {
            noty(Msg)
        });
        window.livewire.on('user-withsales', Msg => {
            noty(Msg)
        })
        window.livewire.on('user-fin', Msg => {
            $('#modal-details').modal('hide')
            noty(Msg)
        })
        window.livewire.on('show-modal2', Msg => {
            $('#modal-details').modal('show')
        })
    });

    function Confirm(id, name, movimientos) {
        if (movimientos > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar al usuario "' + name + '" porque tiene varios movimientos.'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmar eliminar el usuario ?',
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
