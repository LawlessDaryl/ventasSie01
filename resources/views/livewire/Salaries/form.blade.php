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
                <div class="row justify-content-center" style="font-size: 20px;" >
                    
                    <div class="form-control col-sm-7 p-2 bd-highligh d-flex flex-row" >
                        <div class="col-sm-12 col-md-4 " style="margin-left: 50px">
                            <div class="input-group">
                                <h3>Desde: </h3>
                                <select name="horae" wire:model.lazy="horaentrada"  style="margin-left: 10px; padding: 5px">
                                    <option value="1" selected>1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3" selected>3</option>
                                    <option value="4" selected>4</option>
                                    <option value="5" selected>5</option>
                                    <option value="6" selected>6</option>
                                    <option value="7" selected>7</option>
                                    <option value="8" selected>8</option>
                                    <option value="9" selected>9</option>
                                    <option value="10" selected>10</option>
                                    <option value="12" selected>12</option>
                                    <option value="13" selected>13</option>
                                    <option value="14" selected>14</option>
                                    <option value="15" selected>15</option>
                                    <option value="16" selected>16</option>
                                    <option value="17" selected>17</option>
                                    <option value="18" selected>18</option>
                                    <option value="19" selected>19</option>
                                    <option value="20" selected>20</option>
                                </select>
                            </div>
                        @error('horae')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                        </div>
                        <div class="col-sm-12 col-md-6 " >
                            <div class="input-group" >
                                <h3>Hasta: </h3>
                                <select name="horas" wire:model.lazy="horasalida"style="margin-left: 10px; padding: 5px">
                                    <option value="1" selected>1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3" selected>3</option>
                                    <option value="4" selected>4</option>
                                    <option value="5" selected>5</option>
                                    <option value="6" selected>6</option>
                                    <option value="7" selected>7</option>
                                    <option value="8" selected>8</option>
                                    <option value="9" selected>9</option>
                                    <option value="10" selected>10</option>
                                    <option value="12" selected>12</option>
                                    <option value="13" selected>13</option>
                                    <option value="14" selected>14</option>
                                    <option value="15" selected>15</option>
                                    <option value="16" selected>16</option>
                                    <option value="17" selected>17</option>
                                    <option value="18" selected>18</option>
                                    <option value="19" selected>19</option>
                                    <option value="20" selected>20</option>
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
