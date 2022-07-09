<div wire:ignore.self class="modal fade" id="ajustesinv" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ajuste de Inventarios</h5>
               
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-8">
                        <div class="form-group">
                            <label>
                                <h6> <b>Producto</b> </h6>
                            </label>
                           <h6>{{$productoajuste}}</h6>
                        </div>
                       
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>
                                <h6> <b>Existencia Anterior:</b> </h6>
                            </label>
                            <h6>{{$productstock}}</h6>
                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>
                                <h6> <b>Agregar stock:</b> </h6>
                            </label>
                            <input wire:model="cantidad" class="form-control">
                            
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>
                                <h6> <b>Mobiliario:</b> </h6>
                            </label>
                            <select wire:model='mobiliario' class="form-control">
                                @if ($mobs)
                                <option value=null disabled selected>Elegir Mobiliario</option>
                                @foreach ($mobs as $data)
                                <option value="{{ $data->id }}">{{ $data->tipo}}-{{$data->codigo}}</option>
                              @endforeach
                                @endif
                             
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                          <table>
                             
                              <tbody>
                                @if ($mop_prod)
                                    
                                 @foreach ($mop_prod as $item)
                                    <td>
                                        {{$item->location}}
                                    </td>
                                 @endforeach
                                 @else
                                 <td>
                                    Sin mobiliarios
                                </td>
                                @endif
                              </tbody>
                          </table>
                            
                        </div>
                    </div>
                    
                </div>

                </div>
                <div class="row justify-content-center">

                    <div class="col-lg-4">
                        <div class="form-group">
                          
                            <button type="button" wire:click="guardarajuste()"
                            class="btn btn-danger fas fa-save text-center"> Guardar</button>
                        </div>
    
                        
                    </div>
                </div>
            </div>
  
        </div>
    </div>
</div>

<section class="container">
    <div>
        <select id="leftValues" size="5" multiple></select>
    </div>
    <div>
        <input type="button" id="btnLeft" value="&lt;&lt;" />
        <input type="button" id="btnRight" value="&gt;&gt;" />
    </div>
    <div>
        <select id="rightValues" size="4" multiple>
            <option>1</option>
            <option>2</option>
            <option>3</option>
        </select>
        <div>
            <input type="text" id="txtRight" />
        </div>
    </div>
</section>

SELECT, INPUT[type="text"] {
    width: 160px;
    box-sizing: border-box;
}
SECTION {
    padding: 8px;
    background-color: #f0f0f0;
    overflow: auto;
}
SECTION > DIV {
    float: left;
    padding: 4px;
}
SECTION > DIV + DIV {
    width: 40px;
    text-align: center;
}

$("#btnLeft").click(function () {
    var selectedItem = $("#rightValues option:selected");
    $("#leftValues").append(selectedItem);
});

$("#btnRight").click(function () {
    var selectedItem = $("#leftValues option:selected");
    $("#rightValues").append(selectedItem);
});

$("#rightValues").change(function () {
    var selectedItem = $("#rightValues option:selected");
    $("#txtRight").val(selectedItem.text());
});