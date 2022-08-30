
<div wire:ignore.self class="modal fade" id="modalbuscarcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(252, 130, 42); color: white;">
            <h5 class="modal-title" id="exampleModalLongTitle">Buscar Cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                
                <div class="col-sm-12">
                    
                    <div class="input-group" style="padding-right: 20px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-gp">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" wire:model="buscarcliente" placeholder="Buscar por Nombre del Cliente..." class="form-control">
                    </div>
                    <br>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre Cliente</th>
                                    <th class="text-center">Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listaclientes as $lc)
                                <tr>
                                    <td class="text-left">
                                        {{ ucwords(strtolower($lc->nombre)) }}
                                    </td>
                                    <td class="text-center">
                                        <button title="Seleccionar Cliente" wire:click.prevent="seleccionarcliente({{ $lc->id }})" class="btn btn-sm" style="background-color: rgb(10, 137, 235); color:white">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar Ventana</button>
            </div>
            <br>
        </div>
    </div>
</div>