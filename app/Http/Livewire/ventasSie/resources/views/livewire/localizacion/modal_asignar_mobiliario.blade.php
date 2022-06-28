
@section('css')

<style>

.contenedortabla{
        /* overflow:scroll; */
        overflow-x:auto;
        /* max-height: 100%; */
        /* min-height:200px; */
        /* max-width: 100%; */
        /* min-width:100px; */
    }

    .estilostable {
    width: 100%;
   
    }
    .tablehead{
        background-color: #383938;
        color: aliceblue;
    }
    .tableheadprod{
        background-color: rgb(43, 42, 41);
        color: rgb(229, 229, 230);
        border-radius: 1rem;
        
    }
</style>
@endsection


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
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="form-group">
                        <label>Buscar productos...</label>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="search2" placeholder="Buscar" class="form-control">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12">

                        @if(strlen($search2) > 0 )
                        <div class="contenedortabla">
                            <table class="estilostable" style="color: rgb(6, 5, 5)">
                                <thead class="tableheadprod">
                                        <tr>
                                            <th class="table-th text-withe text-center">ITEM</th>
                                            <th class="table-th text-withe text-center">PRODUCTO</th>                    
                                                                  
                                            <th class="table-th text-withe text-center">ACCION</th>                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_mob as $data_m)
                                            <tr>
                                                <td>
                                                    <h6 class="text-center">{{ $loop->iteration}}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data_m->nombre }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" wire:click="addProd({{ $data_m->id}})"
                                                        class="btn btn-dark mtmobile p-1">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              
    
                            </div>
                        @endif
                        </div>

                </div>
               
             </div>
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-12">
                    
                        <h5>Producto</h5>
                        @if($product)
                        <div>{{$product_name}}</div>
                        
                       {{--
                        @if ($auxi)
                        @foreach ($auxi as $item)
                        <h6>{{$item}}</h6>
                        @endforeach
                        --}}
                        <br>
                        <br>
                        @else
                        <br>
                        Lista de productos para asignarlos a este mobiliario
                        <br>
                        @endif
                        
                        
                       
                    
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