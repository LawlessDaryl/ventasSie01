<div wire:ignore.self class="modal fade" id="buscarproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                   
@if ($detalle)
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
                                        <th class="table-th text-withe">Cantidad</th>
                                        <th class="table-th text-withe">Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalle as $d)
                                        <tr>
                                      
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $d->productos->nombre}}
                                                </h6>
                                            </td>
                                            <td class="text-center">
                                             
                                                {{$d->cantidad}}
                                            </td>
                                            <td class="text-center">
                                             
                                                {{$d->costo}}
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
