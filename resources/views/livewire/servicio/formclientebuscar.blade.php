<div wire:ignore.self class="modal fade" id="theClient" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
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
                            <a href="javascript:void(0)" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#theNewClient" wire:click.prevent="resetUI()" data-dismiss="modal">Nuevo
                                Cliente</a>
                        </ul>
                    </div>
                </div>
                @if ($condicion != 0)

                <div class="table-wrapper">
                    <table class="tablaservicios">
                        <thead>
                            <tr>
                                <th class="text-center">Cédula</th>
                                <th>Nombre</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($datos as $d)
                                    <tr>
                                        <td class="text-center">
                                            {{ $d->cedula }}
                                        </td>
                                        <td>
                                            <div style="padding-left: 5px;">
                                                {{ ucwords(strtolower($d->nombre)) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $d->celular }}

                                            {{-- <input type="number" wire:model.lazy="celular" class="form-control" 
                                            placeholder="{{ $d->celular }}" maxlength="8">
                                            @error('celular') <span class="text-danger er">{{ $message }}</span>@enderror --}}
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)"
                                                wire:click="Seleccionar({{ $d->id }})"
                                                class="btn btn-primary btn-sm" title="Seleccionar Cliente">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>

                    



                </div>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn" style="background-color: rgb(0, 56, 161); color: beige;"
                    data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
