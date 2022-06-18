<div class="row sales layout-top-spacing" wire:init="loadPage">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">

                    <a href="javascript:void(0)" class="btn btn-dark" wire:click="Agregar()">Agregar</a>
                    
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe">NOMBRE</th>
                                <th class="table-th text-withe text-center">PRECIO PERFIL</th>
                                <th class="table-th text-withe text-center">PRECIO ENTERA</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">TIPO</th>
                                <th class="table-th text-withe tect-center">¿PERFILES?</th>
                                <th class="table-th text-withe text-center">DESCRIPCIÓN</th>
                                <th class="table-th text-withe text-center">IMAGEN</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($platforms as $p)
                                <tr>
                                    <td>
                                        <h6>{{ $p->nombre }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $p->precioPerfil }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $p->precioEntera }}</h6>
                                    </td>



                                    <td class="text-center">
                                        <h6>{{ $p->estado }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $p->tipo }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $p->perfiles }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <h6>{{ $p->descripcion }}</h6>
                                    </td>


                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/plataformas/' . $p->imagen) }}"
                                                alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $p->id }})"
                                            class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $p->id }}','{{ $p->nombre }}')"
                                            class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (count($platforms))
                        @if ($platforms->hasPages())
                            {{ $platforms->links() }}
                        @endif
                    @else
                        <tr>
                            <td colspan="5">
                                <h5 class="text-center">Sin Resultados</h5>
                            </td>
                        </tr>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('livewire.plataformas.form')
</div>

{{-- @stack('js')


@push('js')
    <script>
        function Confirm(id, name, cuentas) {
        if (cuentas > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la plataforma, ' + name + ' porque tiene ' +
                    cuentas + ' cuentas relacionadas'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la plataforma ' + '"' + name + '"',
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
@endpush --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-deleted', Msg => {
            noty(Msg)
        });

    });

    function Confirm(id, name, cuentas) {
        if (cuentas > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la plataforma, ' + name + ' porque tiene ' +
                    cuentas + ' cuentas relacionadas'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la plataforma ' + '"' + name + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('Destroy', id)
                Swal.close()
            }
        })
    }
</script>
