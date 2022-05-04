<div wire:ignore.self class="modal fade" id="asignar_mobiliario" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
            <h5 class="modal-title text-white">
                <b>Asignar Mobiliario</b>
            </h5>
            <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
         <div class="modal-body" style="background: #f0ecec">
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <div class="form-group">
                        <label>Categoria</label>
                        <select wire:model='categoria' class="form-control">
                            <option value="Elegir">Elegir</option>
                            @foreach ($data_categoria as $data)
                            
                                <option value="{{$data->id}}">{{ $data->name}}</option>
                            @endforeach
                          
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <div class="form-group">
                        <label>Subcategoria</label>
                        <select wire:model='subcategoria' class="form-control">
                            <option value="Elegir">Elegir</option>
                            @foreach ($data_subcategoria as $data)
                                <option value="{{$data->id}}">{{ $data->name}}</option>
                            @endforeach
                          
                        </select>
                    </div>
                </div>
             </div>
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-12">
                    <div class="form-group">
                        <label>Productos</label>
                        <select wire:model='product' class="form-control">
                            <option value="Elegir">Elegir</option>
                            @foreach ($data_producto as $data)
                                <option value="{{$data->id}}">{{ $data->nombre}}</option>
                            @endforeach
                        </select>
                        @error('product') <span class="text-danger er">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-sm-12 col-md-8 col-lg-6">
                        <div class="form-group">
                            <label>Sucursal-locacion</label>
                            <select wire:model='destino' class="form-control">
                                <option value="Elegir">Elegir</option>
                                @foreach ($data_destino as $data)
                                
                                    <option value="{{$data->destino_id}}">{{ $data->nombre}}-{{$data->name}}</option>
                                @endforeach
                              
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-6">
                        <div class="form-group">
                            <label>Mobiliario</label>
                            <select wire:model='location' class="form-control">
                                <option value="Elegir">Elegir</option>
                                @foreach ($data_mobiliario as $data)
                                
                                    <option value="{{$data->id}}">{{ $data->tipo}}-{{$data->codigo}}</option>
                                @endforeach
                            </select>
                            @error('location') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

     </div>
     <div class="modal-footer" style="background: #f0ecec">
         <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
             data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
        
             <button type="button" wire:click.prevent="asignarMobiliario()"
                 class="btn btn-dark close-btn text-info">GUARDAR</button>
     </div>
    </div>
        </div>
</div>