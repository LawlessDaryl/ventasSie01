<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Carteras de esta caja</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($carteras as $item)
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <div class="connect-sorting">
                                    <h6 class="text-center"> {{ $item->nombre }}</h6>
                                    <div class="connect-sorting-content">
                                        <div class="card simple-title-task ui-sortable-handle">
                                            <div class="card-body">
                                                <div class="task-header">
                                                    <div>
                                                        <h6>Descripción: {{ $item->descripcion }}</h6>
                                                    </div>
                                                    <div>
                                                        <h6>Total: <strong>{{ $item->monto }}</strong> Bs.</h6>
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
                <ul class="tabs tab-pills text-center">
                    @if ($habilitado == 0)
                        <a href="javascript:void(0)" class="btn btn-success" wire:click.prevent="CrearCorte()">REALIZAR
                            APERTURA DE ESTA CAJA</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-danger" wire:click.prevent="CerrarCaja()">REALIZAR
                            CIERRE DE CAJA</a>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
