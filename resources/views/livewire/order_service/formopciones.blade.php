<div wire:ignore.self class="modal fade" id="theOptions" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Información del Servicio</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="card component-card_1 col-lg-12 col-sm-12 col-md-6">
                    <div class="card-body">
                        
                        <div class="text-center">
                            <div class="col-lg-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                        {{-- <a class="badge badge-info" style="font-size: 115%" href="{{ url('reporte/pdf' . '/' . $orderservice) }}" 
                                        target="_blank">Imprimir</a> --}}
                                        <a class="btn btn-outline-primary" style="font-size: 115%" href="{{ url('reporte/pdf' . '/' . $orderservice) }}" 
                                        target="_blank">Imprimir</a>
                                </div>
                            </div>
                            @if(@Auth::user()->hasPermissionTo('Ver_Modificar_Eliminar_Servicio'))
                                <div class="col-lg-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <span data-dismiss="modal" wire:click.prevent="EditService({{$orderservice}})" 
                                        class="badge badge-success" style="font-size: 115%"
                                        data-dismiss="modal">Modificar Servicio</span>
                                    </div>
                                </div>
                                    {{-- Este $mostrar es del controlador en el método VerOpciones --}}
                                    @if($mostrar)
                                        @if(@Auth::user()->hasPermissionTo('Anular_Servicio'))
                                            <div class="col-lg-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <span data-dismiss="modal" wire:click.prevent="VerAnular({{$orderservice}})" 
                                                    class="badge badge-warning" style="font-size: 115%">Anular Servicio</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    {{-- Este $mostrarEliminar es del controlador en el método VerOpciones --}}
                                    @if($mostrarEliminar)
                                        @if(@Auth::user()->hasPermissionTo('Eliminar_Servicio'))
                                            <div class="col-lg-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <span data-dismiss="modal" wire:click.prevent="VerEliminar({{$orderservice}})" 
                                                    class="badge badge-danger" style="font-size: 115%">Eliminar Servicio</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">ATRÁS</button>
            </div>
        </div>
    </div>
</div>