<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Información de las carteras</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($carteras as $item)
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <div class="connect-sorting">
                                    <h5 class="text-center mb-3"> {{ $item->nombre }}</h5>
                                    <div class="connect-sorting-content">
                                        <div class="card simple-title-task ui-sortable-handle">
                                            <div class="card-body">
                                                <div class="task-header">
                                                    <div>
                                                        <h3>Descripción: {{ $item->descripcion }}</h3>
                                                    </div>
                                                    <div>
                                                        <h3>{{$item->monto}}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <ul class="tabs tab-pills text-center mt-2">
                    @if ($habilitado == 0)
                        <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="CrearCorte()">ACEPTAR
                            MONTO DE CARTERAS Y HACER CORTE DE CAJA APERTURA</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="CerrarCaja()">REALIZAR
                            CIERRE DE CAJA</a>
                    @endif
                </ul>
                <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
