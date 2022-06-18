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
                

                  <p class="text-center">Esta acción devolvera los siguientes productos a la Tienda</p>
            
                  <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                    <thead class="text-white" style="background: #ee761c">
                      <tr>
                        <th>N°</th>
                        <th>Nombre Producto</th>
                        {{-- <th>Total Bs</th> --}}
                        <th>Cantidad</th>
                        {{-- <th>Total</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($listadetalles as $dv)
                        <tr>
                            <td class="table-th text-withe text-center">
                                {{$loop->iteration}}
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->nombre }}
                            </td>
                            {{-- <td class="table-th text-withe text-right">
                                {{ number_format($dv->po, 2) }} Bs
                            </td> --}}
                            <td class="table-th text-withe text-center">
                                {{ $dv->cantidad }}
                            </td>
                            {{-- <td class="table-th text-withe text-right">
                                {{ number_format($dv->pv*$dv->cantidad, 2) }} Bs
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <br>
                  <p class="text-center">Se generará un egreso de Bs {{$this->totabs()}} de 
                    <br>
                    <b>{{$this->obtenertipopago()}}</b>
                 .</p>

            </div>
            <div class="modal-footer">
                <button wire:click="anularventa({{ $idventa }})" class="btn btn-danger">Anular Venta</button>
            </div>
        </div>
    </div>
</div>