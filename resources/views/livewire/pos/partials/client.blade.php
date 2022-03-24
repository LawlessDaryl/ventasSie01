<div class="col-12 col-md-3 col-lg-6" style="border-left: thick solid #b4b4b1;" >
    @if ($anonimo == 1)
    
    <div class="row">

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <input type="text" wire:model="nit" class="form-control" placeholder="NIT">
                @error('nit')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <input type="text" wire:model="razonsocial" class="form-control" placeholder="RAZON SOCIAL">
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <input type="text" wire:model="celular" class="form-control" placeholder="CELULAR">
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


    @else

    <div class="text-center">
        <h3>Shopping Cart</h3>
    </div>
    
    @endif
</div>