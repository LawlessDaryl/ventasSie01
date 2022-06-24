<div wire:ignore.self class="modal fade" id="detalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalle de Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                

                <table class="estilostable">
                    <thead class="text-white" style="background: #ee761c">
                      <tr>
                        <th>No</th>
                        <th>Nombre</th>
                        <th class="text-center">Precio Original (Bs)</th>
                        <th>Descuento <br> o Recargo</th>
                        <th>Precio Venta (Bs)</th>
                        <th>Cantidad</th>
                        <th>Total (Bs)</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($listadetalles as $dv)
                        <tr class="estilostr">
                            <td class="table-th text-withe text-center">
                                {{$loop->iteration}}
                            </td>
                            <td class="table-th text-withe text-left">
                                {{ $dv->nombre }}
                            </td>
                            <td class="table-th text-withe text-right">
                                {{ number_format($dv->po, 2) }}
                            </td>



                            @if($dv->pv-$dv->po == 0)
                            <td class="table-th text-withe text-right">
                                {{ number_format($dv->pv-$dv->po, 2) }}
                            </td>
                            @else
                            <td class="table-th text-withe text-right" style="background-color: rgb(248, 231, 197, 0.5)">
                                {{ number_format($dv->pv-$dv->po, 2) }}
                            </td>
                            @endif


                            <td class="table-th text-withe text-right">
                                {{ number_format($dv->pv, 2) }}
                            </td>
                            <td class="table-th text-withe text-center">
                                {{ $dv->cantidad }}
                            </td>
                            <td class="table-th text-withe text-right">
                                {{ number_format($dv->pv*$dv->cantidad, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td class="text-center">
                            <b>
                                -
                            </b>
                        </td>
                        <td>
                            <b>
                                -
                            </b>
                        </td>
                        <td class="text-center">
                            <b class="text-center">
                                Totales
                            </b>
                        </td>
                        <td class="table-th text-withe text-right">
                            <b>
                                --------
                            </b>
                        </td>
                        <td class="table-th text-withe text-right">
                            <b>
                                --------
                            </b>
                        </td>
                        <td class="text-center">
                            <b>
                                {{$this->totalitems()}}
                            </b>
                        </td>
                        <td class="text-right">
                            
                            <b>
                                {{number_format( $this->totabs(), 2) }}
                            </b>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
            
            
            
            
            </div>
            <div class="text-center" style="color: black">
                <b>
                    Esta Venta tuvo un Descuento Total de {{number_format( $this->totaldescuento($this->idventa), 2) }} Bs
                </b>
            </div>
            <br>
        </div>
    </div>
</div>