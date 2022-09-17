<div wire:ignore.self class="modal fade" id="detalleventa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalle de Venta Código: @if($this->venta != null) {{$this->venta->id}} @endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table table-bordered" style="min-width: 770px;">
                    <thead class="text-white" style="background: #ee761c">
                      <tr>
                        <th>No</th>
                        <th>Nombre</th>
                        <th class="text-center">Precio (Bs)</th>
                        <th class="text-center">Desc/Rec</th>
                        <th class="text-center">Precio Venta</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Total (Bs)</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($detalle_venta as $dv)
                        <tr>
                            <td class="text-center">
                                {{$loop->iteration}}
                            </td>
                            <td class="text-left">
                                {{ ucwords(strtolower($dv->nombre)) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($dv->po, 2) }}
                            </td>



                            @if($dv->pv-$dv->po == 0)
                            <td class="text-center">
                                {{ number_format($dv->pv-$dv->po, 2) }}
                            </td>
                            @else
                                @if($dv->pv-$dv->po < 0)
                                <td class="text-center">
                                    <div style="color: rgb(250, 12, 12);">
                                        Descuento
                                    </div>
                                    {{ number_format($dv->pv-$dv->po, 2) }}
                                </td>
                                @else
                                <td class="table-th text-withe text-center">
                                    <div style="color: #002df3;">
                                        Recargo
                                    </div>
                                    {{ number_format($dv->pv-$dv->po, 2) }}
                                </td>
                                @endif
                            @endif


                            <td class="text-right">
                                {{ number_format($dv->pv, 2) }}
                            </td>
                            <td class="text-center">
                                {{ $dv->cantidad }}
                            </td>
                            <td class="text-right">
                                {{ number_format($dv->pv * $dv->cantidad, 2) }}
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
                                {{$this->totalitems}}
                            </b>
                        </td>
                        <td class="text-right">
                            @if($this->venta != null)
                            <b>
                                {{number_format( $this->venta->total, 2) }}
                            </b>
                            @endif
                        </td>
                      </tr>
                    </tfoot>
                  </table>
            
            
            
            
            </div>
            <div class="text-center" style="color: black">
                @if($this->desc_rec == 0)
                <div>
                    Esta Venta tuvo un Descuento Total de {{$this->desc_rec}} Bs
                </div>
                @else
                    @if($this->desc_rec < 0)
                    <div style="color: rgb(250, 12, 12);">Esta Venta tuvo un Descuento Total de<b> {{$this->desc_rec}} Bs</b></div>
                    @else
                    <div style="color: #002df3;">Esta Venta tuvo un Recargo Total de<b> {{$this->desc_rec}} Bs</b></div>
                    @endif
                @endif
                @if($this->venta != null)
                    @if($this->venta->observacion == "")
                    <b>Observación: Ninguna</b>
                    @else
                    <b>Observación: {{$this->venta->observacion}}</b>
                    @endif
                @endif
            </div>
            <br>
        </div>
    </div>
</div>