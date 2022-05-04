<div wire:ignore.self class="modal fade" id="detalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalle de Ventas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                

                  <table>
                    <thead class="titulos">
                      <tr>
                        <th> # </th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio Original</th>
                        <th>Descuento Venta</th>
                        <th>Precio Venta</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($listadetalles as $dv)
                        <tr>
                            <td class="table-th text-withe text-center">
                                x
                            </td>
                            <td class="table-th text-withe text-center">
                                <img src="{{('storage/productos/'.$dv->image) }}"
                                height="25" class="rounded">
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->nombre }}
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->po }}
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->po-$dv->pv }}
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->pv }}
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->cantidad }}
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->pv*$dv->cantidad }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2"> Totales</td>
                        <td class="PrecioTotal"> $23 </td>
                        <td class="CantidadTotal"> 5 </td>
                      </tr>
                    </tfoot>
                  </table>
            
            
            
            
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>