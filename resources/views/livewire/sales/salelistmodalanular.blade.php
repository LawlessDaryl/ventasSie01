<div wire:ignore.self class="modal fade" id="anular" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <div class="text-center">
                    <h5 style="color: crimson"><b>¿Está Realmente Seguro de Anular esta Venta?</b></h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <div class="modal-body" style="color: black">
                

                  Esta Acción devolvera los siguientes productos a la Tienda con estos Precios
            
                  <table border="1">
                    <thead>
                      <tr>
                        <td>No</td>
                        <th>Nombre Producto</th>
                        <th>Total Bs</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Egreso</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($listadetalles as $dv)
                        <tr>
                            <td class="table-th text-withe text-center">
                                {{$loop->iteration}}
                            </td>
                            <td class="table-th text-withe text-left">
                                {{ $dv->nombre }}
                            </td>
                            <td class="table-th text-withe text-right">
                                {{ number_format($dv->po, 2) }} Bs
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->cantidad }}
                            </td>
                            <td class="table-th text-withe text-right">
                                {{ number_format($dv->pv*$dv->cantidad, 2) }} Bs
                            </td>
                            <td class="table-th text-withe text-right">
                              {{ number_format($dv->po - ($dv->po-$dv->pv), 2) }} Bs
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger">Anular Venta</button>
            </div>
        </div>
    </div>
</div>