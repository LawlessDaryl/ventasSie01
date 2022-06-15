<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b>
                </h4>
            </div>

            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model="origen" class="form-control">
                            <option value="Elegir" selected>==Seleccione el Origen==</option>
                            @foreach ($origenes as $origen)
                                <option value="{{ $origen->id }}" selected>{{ $origen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button wire:click.prevent="SyncAll()" type="button"
                        class="btn btn-warning">Sincronizar todos</button>
                    <button onclick="Revocar()" type="button" class="btn btn-warning">Revocar todos</button>
                </div>


                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                                <thead class="text-white" style="background: #ee761c">
                                    <tr>
                                        <th class="table-th text-withe text-center">ID</th>
                                        <th class="table-th text-withe text-center">MOTIVOS</th>
                                        <th class="table-th text-withe text-center">ACCIONES</th>
                                </thead>
                                <tbody>
                                    @foreach ($motivos as $motivo)
                                        <tr>
                                            <td>
                                                <h6 class="text-center">{{ $motivo->id }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <div class="n-chk">
                                                    <label class="new-control new-checkbox checkbox-primary">
                                                        <input type="checkbox"
                                                            wire:change="SyncPermiso($('#p' + {{ $motivo->id }}).is(':checked'), '{{ $motivo->id }}')"
                                                            id="p{{ $motivo->id }}" value="{{ $motivo->id }}"
                                                            class="new-control-input"
                                                            {{ $motivo->checked == 1 ? 'checked' : '' }}>
                                                        <span class="new-control-indicator"></span>
                                                        <h6>{{ $motivo->nombre }}</h6>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($motivo->checked == 1)
                                                    @if ($motivo->condicional != 'no')
                                                        <button onclick="Confirm('{{ $motivo->id }}','{{ $motivo->nombre }}')" type="button"
                                                            class="btn btn-warning">
                                                            <svg aria-hidden="true" focusable="false" data-prefix="far"
                                                                data-icon="check-circle" role="img"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                class="svg-inline--fa fa-check-circle fa-w-16 fa-3x">
                                                                <path fill="currentColor"
                                                                    d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"
                                                                    class=""></path>
                                                            </svg>
                                                        </button>

                                                    @else
                                                        <button disabled wire:click.prevent="Condicion()"
                                                            class="btn btn-warning">


                                                            <svg aria-hidden="true" focusable="false" data-prefix="far"
                                                                data-icon="times-circle" role="img"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                class="svg-inline--fa fa-times-circle fa-w-16 fa-3x">
                                                                <path fill="currentColor"
                                                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm101.8-262.2L295.6 256l62.2 62.2c4.7 4.7 4.7 12.3 0 17l-22.6 22.6c-4.7 4.7-12.3 4.7-17 0L256 295.6l-62.2 62.2c-4.7 4.7-12.3 4.7-17 0l-22.6-22.6c-4.7-4.7-4.7-12.3 0-17l62.2-62.2-62.2-62.2c-4.7-4.7-4.7-12.3 0-17l22.6-22.6c4.7-4.7 12.3-4.7 17 0l62.2 62.2 62.2-62.2c4.7-4.7 12.3-4.7 17 0l22.6 22.6c4.7 4.7 4.7 12.3 0 17z"
                                                                    class=""></path>
                                                            </svg>
                                                        </button>

                                                    @endif

                                                    <button wire:click.prevent="viewDetails({{ $motivo->id }})"
                                                        class="btn btn-warning">

                                                        <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="clipboard-check" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                            class="svg-inline--fa fa-clipboard-check fa-w-12 fa-3x">
                                                            <path fill="currentColor"
                                                                d="M336 64h-80c0-35.3-28.7-64-64-64s-64 28.7-64 64H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM192 40c13.3 0 24 10.7 24 24s-10.7 24-24 24-24-10.7-24-24 10.7-24 24-24zm121.2 231.8l-143 141.8c-4.7 4.7-12.3 4.6-17-.1l-82.6-83.3c-4.7-4.7-4.6-12.3.1-17L99.1 285c4.7-4.7 12.3-4.6 17 .1l46 46.4 106-105.2c4.7-4.7 12.3-4.6 17 .1l28.2 28.4c4.7 4.8 4.6 12.3-.1 17z"
                                                                class=""></path>
                                                        </svg>

                                                    </button>
                                                @endif



                                                {{-- <button wire:click.prevent="viewDetails({{ $motivo->id }})"
                                                    class="btn btn-warning">
                                                    <i class="fas fa-list"></i>
                                                </button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $motivos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.origen_motivo.modalDetails')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('asignado', Msg => {
            $('#modal-details').modal('hide')
            noty(Msg)
        });
        window.livewire.on('sync-error', Msg => {
            noty(Msg)
        });
        window.livewire.on('permi', Msg => {
            noty(Msg)
        });
        window.livewire.on('syncall', Msg => {
            noty(Msg)
        });
        window.livewire.on('removeall', Msg => {
            noty(Msg)
        });
        window.livewire.on('asignar', Msg => {
            $('#modal-details').modal('show')
        })
    });

    function Revocar() {

        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmas revocar todos los motivos?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('revokeall')
                Swal.close()
            }
        })
    }

    function Confirm(id,nombre) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmar quitar todas las configuraciones de ' +nombre+'?',
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
