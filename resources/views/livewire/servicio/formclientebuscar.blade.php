<div wire:ignore.self class="modal fade" id="theClient" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Buscar</b> | Cliente
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row justify-content-between">
                    <div class="col-lg-8 col-md-4 col-sm-12">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="buscarCliente" placeholder="Buscar Cliente..." class="form-control">


                        </div>

                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">

                        <ul class="tabs tab-pills">
                            <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                                data-target="#theNewClient" wire:click.prevent="resetUI()" data-dismiss="modal">Nuevo
                                Cliente</a>
                        </ul>
                    </div>
                </div>
                @if ($condicion != 0)

                <div class="table-wrapper">
                    <table class="tablaservicios" style="min-width: 400px;">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center ">Cédula</th>
                                <th class="table-th text-withe text-center">Nombre</th>
                                <th class="table-th text-withe text-center">Teléfono</th>
                                <th class="table-th text-withe text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($datos as $d)
                                    <tr>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $d->cedula }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $d->nombre }}</h6>
                                        </td>
                                        <td class="text-center">
                                            {{-- <h6 class="text-center">{{ $d->celular }}</h6> --}}
                                            <input type="number" wire:model.lazy="celular" class="form-control" 
                                            placeholder="{{ $d->celular }}" maxlength="8">
                                            @error('celular') <span class="text-danger er">{{ $message }}</span>@enderror
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)"
                                                wire:click="Seleccionar({{ $d->id }})"
                                                class="btn btn-warning mtmobile" title="Seleccionar">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>

                    



                </div>
                @endif

                <div class="row">

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
