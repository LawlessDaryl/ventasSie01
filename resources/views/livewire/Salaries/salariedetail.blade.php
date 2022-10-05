<div wire:ignore.self class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalle de Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table table-bordered table-bordered-bd-warning mt-6" style="min-width: 1000px;">
                    <thead class="text-white" style="background: #ee761c">
                      <tr>
                        <th>No</th>
                        <th>Nombre</th>
                        <th class="text-center">Sueldo</th>
                        <th class="text-center">Dias Transcurridos</th>
                        <th class="text-center">Dias a Pagar (Bs)</th>
                        <th class="text-center">Meses Transcurridos</th>
                        <th class="text-center">Total Meses <br> Pagados (Bs)</th>
                        
                      </tr>
                    </thead>
                    
                    <tbody>
                        <tr class="estilostr" >
                            <td class="table-th text-withe text-center" style="font-size: 20px">
                                1
                            </td>
                            <td class="table-th text-withe text-left" style="font-size: 20px">
                                {{ $nombre}}
                            </td>
                            <td class="table-th text-withe text-right" style="font-size: 20px">
                                {{ number_format($sueldo, 2) }}  BS.
                            </td>



                            <td class="table-th text-withe text-right" style="font-size: 20px">
                                {{ $Dtranscurridos}}
                            </td>
                            
                            
                            <td class="table-th text-withe text-right" style="font-size: 20px">
                                {{ number_format($pagarD,2)}} Bs.
                            </td>
                            
                            <td class="table-th text-withe text-right" style="font-size: 20px">
                                {{ $Mtranscurridos}}
                            </td>
                            
                            <td class="table-th text-withe text-right" style="font-size: 20px">
                                {{ number_format($pagarM,2)}} Bs.
                            </td>
                        </tr>
                    </tbody>
                    
                  </table>
            
            
            
            
            </div>
            
        </div>
    </div>
</div>