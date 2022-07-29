<div wire:ignore.self class="modal fade" id="buscarproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="d-flex row ml-2">
                                <h6>PRODUCTO</h6>
                            </label>
                            <input wire:model="searchproduct" class="form-control">
                            
                        </div>
                       
                    </div>
@if ($buscarproducto != 0)
<div class="col-sm-12 col-md-12">
    <div class="vertical-scrollable">
        <div class="row layout-spacing">
            <div class="col-md-12 ">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area row">
                        <div
                            class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                            <table class="table table-hover table-sm" style="width:100%">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">Producto</th>
                                        <th class="table-th text-withe">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sm as $d)
                                        <tr>
                                      
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $d->nombre }}
                                                </h6>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)"
                                                    wire:click="Seleccionar('{{ $d->id }}')"
                                                    class="btn btn-warning mtmobile"
                                                    title="Seleccionar">
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
