<!-- Modal -->
<div wire:ignore.self class="modal fade" id="modallotesproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ee761c; color: white;">
          <h5 class="modal-title" id="exampleModalLongTitle">
            Lotes Producto
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">

            <p>Mostrando todos los lotes nesesarios para vender la cantidad de {{$this->cantidad_venta}} unidades del producto:</p>

            <h4><b>{{$this->nombreproducto}}</b></h4>
          </div>
          <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                      <th class="text-center">
                        Fecha
                      </th>
                      <th class="text-center">
                        Stock
                      </th>
                      <th class="text-center">
                        Costo
                      </th>
                      <th class="text-center">
                        Precio
                      </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->lotes_producto as $lp)
                    <tr>
                      <td class="text-center">
                        {{ \Carbon\Carbon::parse($lp->created_at)->format('d/m/Y H:i') }}
                      </td>
                      <td class="text-center">
                        {{ $lp->existencia }}
                      </td>
                      <td class="text-center">
                        {{ $lp->costo }}
                      </td>
                      <td class="text-center">
                        {{ $lp->pv_lote }}
                      </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
          <h3>¿Aplicar Precio Promedio?</h3>
          <button wire:click.prevent="aplicar_precio_promedio()" class="btn btn-button" style="background-color: chocolate; color: white; font-size: 25px;">
            <b>{{number_format($this->precio_promedio, 2)}} Bs</b>
          </button>
        </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar Ventana</button> --}}
          {{-- <button wire:click="save()" type="button" class="btn btn-primary">Guardar Cambios</button> --}}
        </div>
      </div>
    </div>
  </div>