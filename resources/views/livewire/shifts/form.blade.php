<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-edit"></span>
                                </span>
                            </div>
                            <input type="text" wire:model.lazy="shiftName" class="form-control" placeholder="ej: mañana"
                                maxlength="255">
                        </div>
                        @error('shiftName')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <br>
                <div class="row justify-content-center">
                    <h2>Horarios</h2>
                </div>
               
                
                  
                
            </div>

              <!-- Lunes -->
              <div class="col-sm-12 bg-light p-3 border">
                <div class="row justify-content-center" style="font-size: 20px;" >
                    
                    <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >
                        <div class="col-sm-12 col-md-4 " style="margin-left: 50px">
                            <div class="input-group">
                                <h3>lunes: h: </h3>
                                <select name="horae" wire:model.lazy="horalunes"  style="margin-left: 10px; padding: 5px">
                                   
                                    @foreach($horas as $h)
                                        <option value="{{$h}}">{{$h}}</option>
                                    @endforeach

                                    
                                </select>
                            </div>
                        @error('horae')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 " >
                            <div class="input-group" >
                                <h3>m: </h3>
                                <select name="horas" wire:model.lazy="minutolunes"style="margin-left: 10px; padding: 5px">
                                    
                                    @foreach($minutos as $m)
                                        <option value="{{$m}}">{{$m}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        @error('horas')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </div>
              </div>

            <!-- Martes -->

              <div class="col-sm-12 bg-light p-3 border">
                <div class="row justify-content-center" style="font-size: 20px;" >
                    
                    <div class="form-control col-sm-9 p-2 bd-highligh d-flex flex-row" >
                        <div class="col-sm-12 col-md-4 " style="margin-left: 50px">
                            <div class="input-group">
                                <h3>Martes: h: </h3>
                                <select name="horam" wire:model.lazy="horamartes"  style="margin-left: 10px; padding: 5px">
                                   
                                    @foreach($horas as $h)
                                        <option value="{{$h}}">{{$h}}</option>
                                    @endforeach

                                    
                                </select>
                            </div>
                        @error('horam')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 " >
                            <div class="input-group" >
                                <h3>m: </h3>
                                <select name="horas" wire:model.lazy="minutomartes"style="margin-left: 10px; padding: 5px">
                                    
                                    @foreach($minutos as $m)
                                        <option value="{{$m}}">{{$m}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        @error('horas')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </div>
              </div>

              <!-- Miercoles -->

              <div class="col-sm-12 bg-light p-3 border">
                <div class="row justify-content-center" style="font-size: 20px;" >
                    
                    <div class="form-control col-sm-10 p-2 bd-highligh d-flex flex-row" >
                        <div class="col-sm-12 col-md-4 " style="margin-left: 50px">
                            <div class="input-group">
                                <h3>Miercoles: h: </h3>
                                <select name="horae" wire:model.lazy="horamiercoles"  style="margin-left: 10px; padding: 5px">
                                   
                                    @foreach($horas as $h)
                                        <option value="{{$h}}">{{$h}}</option>
                                    @endforeach

                                    
                                </select>
                            </div>
                        @error('horae')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 " >
                            <div class="input-group" >
                                <h3>m: </h3>
                                <select name="horas" wire:model.lazy="minutomiercoles"style="margin-left: 10px; padding: 5px">
                                    
                                    @foreach($minutos as $m)
                                        <option value="{{$m}}">{{$m}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        @error('horas')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </div>
              </div>

              <!-- Jueves -->

              <div class="col-sm-12 bg-light p-3 border">
                <div class="row justify-content-center" style="font-size: 20px;" >
                    
                    <div class="form-control col-sm-10 p-2 bd-highligh d-flex flex-row" >
                        <div class="col-sm-12 col-md-4 " style="margin-left: 50px">
                            <div class="input-group">
                                <h3>Jueves: h: </h3>
                                <select name="horae" wire:model.lazy="horajueves"  style="margin-left: 10px; padding: 5px">
                                   
                                    @foreach($horas as $h)
                                        <option value="{{$h}}">{{$h}}</option>
                                    @endforeach

                                    
                                </select>
                            </div>
                        @error('horae')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 " >
                            <div class="input-group" >
                                <h3>m: </h3>
                                <select name="horas" wire:model.lazy="minutojueves"style="margin-left: 10px; padding: 5px">
                                    
                                    @foreach($minutos as $m)
                                        <option value="{{$m}}">{{$m}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        @error('horas')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </div>
              </div>


              <!-- Viernes -->

              <div class="col-sm-12 bg-light p-3 border">
                <div class="row justify-content-center" style="font-size: 20px;" >
                    
                    <div class="form-control col-sm-10 p-2 bd-highligh d-flex flex-row" >
                        <div class="col-sm-12 col-md-4 " style="margin-left: 50px">
                            <div class="input-group">
                                <h3>Viernes: h: </h3>
                                <select name="horae" wire:model.lazy="horaviernes"  style="margin-left: 10px; padding: 5px">
                                   
                                    @foreach($horas as $h)
                                        <option value="{{$h}}">{{$h}}</option>
                                    @endforeach

                                    
                                </select>
                            </div>
                        @error('horae')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 " >
                            <div class="input-group" >
                                <h3>m: </h3>
                                <select name="horas" wire:model.lazy="minutoviernes"style="margin-left: 10px; padding: 5px">
                                    
                                    @foreach($minutos as $m)
                                        <option value="{{$m}}">{{$m}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        @error('horas')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </div>
              </div>

              <!-- Sabado -->

              <div class="col-sm-12 bg-light p-3 border">
                <div class="row justify-content-center" style="font-size: 20px;" >
                    
                    <div class="form-control col-sm-10 p-2 bd-highligh d-flex flex-row" >
                        <div class="col-sm-12 col-md-4 " style="margin-left: 50px">
                            <div class="input-group">
                                <h3>Sabado: h: </h3>
                                <select name="horae" wire:model.lazy="horasabado"  style="margin-left: 10px; padding: 5px">
                                   
                                    @foreach($horas as $h)
                                        <option value="{{$h}}">{{$h}}</option>
                                    @endforeach

                                    
                                </select>
                            </div>
                        @error('horae')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 " >
                            <div class="input-group" >
                                <h3>m: </h3>
                                <select name="horas" wire:model.lazy="minutosabado"style="margin-left: 10px; padding: 5px">
                                    
                                    @foreach($minutos as $m)
                                        <option value="{{$m}}">{{$m}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        @error('horas')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </div>
              </div>

              <!-- Domingo -->

              <div class="col-sm-12 bg-light p-3 border">
                <div class="row justify-content-center" style="font-size: 20px;" >
                    
                    <div class="form-control col-sm-10 p-2 bd-highligh d-flex flex-row" >
                        <div class="col-sm-12 col-md-4" style="margin-left: 50px">
                            <div class="input-group">
                                <h3>Domingo: h: </h3>
                                <select name="horae" wire:model.lazy="horaentrada"  style="margin-left: 10px; padding: 5px">
                                   
                                    @foreach($horas as $h)
                                        <option value="{{$h}}">{{$h}}</option>
                                    @endforeach

                                    
                                </select>
                            </div>
                        @error('horae')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 " >
                            <div class="input-group" >
                                <h3>m: </h3>
                                <select name="horas" wire:model.lazy="horasalida"style="margin-left: 10px; padding: 5px">
                                    
                                    @foreach($minutos as $m)
                                        <option value="{{$m}}">{{$m}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        @error('horas')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                </div>
              </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="CreateRole()"
                        class="btn btn-warning close-btn text-info">GUARDAR</button>
                @else
                    <button type="button" wire:click.prevent="UpdateRole()"
                        class="btn btn-warning close-btn text-info">ACTUALIZAR</button>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
    const horaentrada = document.getElementById('horae');
    const horasalida = document.getElementById('horas');
    function horasDay() {

        let horaNum=24;
        for (let i = 0; i <= horaNum; i++) {
            const option = document.createElement("option");
            option.textContent = i;
            horaentrada.appendChild(option);
        }
    }

    function horasDays() {

        let horaNum=24;
        for (let i = 0; i <= horaNum; i++) {
            const option = document.createElement("option");
            option.textContent = i;
            horasalida.appendChild(option);
            
        }
    }

    horasDay();
    horasDays();

    horaentrada.onchange = function(){
        horasDay()
    }
</script>
