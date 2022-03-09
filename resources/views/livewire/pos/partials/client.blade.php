@if ($total > 0)
<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">

                

                <div class="row">
                    
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label style="color: black">NIT:</label>
                            <input type="text" wire:model="nit" class="form-control" placeholder="">
                            @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label style="color: black">RAZON SOCIAL:</label>
                            <input type="text" wire:model="razonsocial" class="form-control" placeholder="">
                            @error('cedula')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label style="color: black">CELULAR:</label>
                            <input type="text" wire:model="celular" class="form-control" placeholder="">
                            @error('cedula')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <label style="color: black">Cliente Anónimo:</label>
                        <div class="form-group">
                            <label class="switch s-outline s-outline-primary  mb-4 mr-2">
                                <input type="checkbox" checked="">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    

                    
                    {{-- Tabla para Clientes encontrados por NIT --}}
                    @if ($BuscarClienteNit != 0)
                    <div class="col-sm-12">
                        <div class="vertical-scrollable">
                            <div class="row layout-spacing">
                                <div class="col-md-12 ">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-content widget-content-area row">
                                            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                <table class="table table-hover table-sm" style="width:100%">
                                                    <thead class="text-white" style="background: #3B3F5C">
                                                        <tr>
                                                            <th class="table-th text-withe text-center">NIT</th>
                                                            <th class="table-th text-withe text-center">Razón Social</th>
                                                            <th class="table-th text-withe text-center">Celular</th>
                                                            <th class="table-th text-withe text-center">Acccion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($datosnit as $n)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">{{ $n->nit }}</h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">{{ $n->razon_social }}</h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">{{ $n->celular }}</h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)"
                                                                        wire:click="llenardatoscliente({{ $n->id }})"
                                                                        class="btn btn-dark mtmobile" title="Seleccionar">
                                                                        <i class="fas fa-check"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>   
                    @endif
                </div>
                

            </div>
        </div>
    </div>
</div>
@endif