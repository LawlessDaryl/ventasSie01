<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b class="text-center">LISTADO DE LAS CAJAS DISPONIBLES EN TU SUCURSAL</b><br>
                    <b class="text-center">SELECCIONE LA CAJA EN LA CUAL VA A TRABAJAR</b>
                </h4>
            </div>
            <div>
                <div class="row">
                    @foreach ($data as $item)
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <div class="connect-sorting">
                                    <h5 class="text-center mb-3"> {{ $item->nombre }}</h5>
                                    <div class="connect-sorting-content">
                                        <div class="card simple-title-task ui-sortable-handle">
                                            <div class="card-body">
                                                <div class="task-header">
                                                    <div>
                                                        <h2>ESTADO: {{ $item->estado }}</h2>
                                                    </div>
                                                    @if ($item->AbiertaPorUsuario != '0')
                                                        <div>
                                                            <h2
                                                                style="{{ $item->AbiertaPorUsuario == auth()->user()->id ? 'background-color: #09ed3d;' : '' }}">
                                                                Abierta por:
                                                                {{ $item->UsuarioNombre }}</h2>
                                                        </div>
                                                    @endif
                                                </div>
                                                <h4 class="mt-3">SUCURSAL: {{ $item->sucursal }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="tabs tab-pills text-center mt-2">
                                        @if ($item->estado == 'Cerrado')
                                            <a href="javascript:void(0)"
                                                class="btn btn-warning {{ session('sesionCaja') != null ? 'disabled' : '' }}"
                                                wire:click.prevent="getDetails({{ $item->id }})">VER
                                                CAJA</a>
                                        @else
                                            <a href="javascript:void(0)"
                                                class="btn btn-warning {{ $item->AbiertaPorUsuario != auth()->user()->id ? 'disabled' : '' }}"
                                                wire:click.prevent="getDetails({{ $item->id }})">VER
                                                CAJA</a>
                                        @endif
                                        @if ($item->estado != 'Cerrado')
                                            @if ($item->AbiertaPorUsuario != auth()->user()->id)
                                                <a href="javascript:void(0)" class="btn btn-warning"
                                                    wire:click.prevent="CerrarCajaDelUsuario({{ $item->id }},{{ $item->AbiertaPorUsuario }})">CERRAR
                                                    LA CAJA DEL
                                                    USUARIO</a>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cortecaja.modal-detail')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('caja_funcion', msg => {
            $('#modalDetails').modal('hide')
            noty(msg)
        });
        window.livewire.on('show-modal', msg => {
            $('#modalDetails').modal('show')
        });
        window.livewire.on('no-carteras', msg => {
            noty(msg)
        });
        window.livewire.on('modal-hide', msg => {
            $('#modalDetails').modal('hide')
        });

    });
</script>
