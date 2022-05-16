<div wire:ignore.self class="modal fade" id="mobil" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalle de Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div>
                @if ($show == true)
                @foreach ($grouped as $key=>$item)
                <h4>Sucursal:{{$key}}</h4>
                    @foreach ($item as $value)
                    <h4>{{$value->estancia}}</h4>
                    <h5>Stock</h5>   
                    <label>{{$value->stock}}</label>
                    <h5>Mobiliario</h5>
                    @if ($value->tipo == null)
                        No asignado
                    @else
                        
                    {{$value->tipo}}-{{$value->mob_code}}
                    @endif
                    
                    @endforeach
                @endforeach

                @endif
            </div>
                   
          
            
        </div>
    </div>
</div>