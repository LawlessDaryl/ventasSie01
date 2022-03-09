@include('common.modalHead')

<div class="row">
    <div class="col-sm-6 col-md-8" style="background: #f0ecec">

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Correo</label>
                <div class="input-group">
                    <input type="text" id="c" wire:model.lazy="content" class="form-control" placeholder="">
                    <a onclick="copia();" class="btn btn-dark">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-clone fa-w-16 fa-3x"><path fill="currentColor" d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zM362 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h42v224c0 26.51 21.49 48 48 48h224v42a6 6 0 0 1-6 6zm96-96H150a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h308a6 6 0 0 1 6 6v308a6 6 0 0 1-6 6z" class=""></path></svg>
                    </a>                    
                </div>                
            </div>
            @error('content') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Contraseña</label>
                <div class="input-group">
                    <input type="text" id="p" wire:model.lazy="pass" class="form-control" placeholder="">
                    <a onclick="copiap();" class="btn btn-dark">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-clone fa-w-16 fa-3x"><path fill="currentColor" d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zM362 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h42v224c0 26.51 21.49 48 48 48h224v42a6 6 0 0 1-6 6zm96-96H150a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h308a6 6 0 0 1 6 6v308a6 6 0 0 1-6 6z" class=""></path></svg>
                    </a>                    
                </div>                
            </div>
            @error('pass') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
   
        <div class="row align-items-start ml-1 mr-1">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Estado</label>
                    <select wire:model='status' class="form-control">
                        <option value="Elegir" disabled>Elegir</option>
                        <option>ACTIVO</option>
                        <option>INACTIVO</option>
                    </select>
                    @error('status') <span class="text-danger er">{{ $message }}</span>@enderror
                </div>
            </div>
    
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Disponibilidad</label>
                    <select wire:model='availability' class="form-control">
                        <option value="Elegir" disabled>Elegir</option>
                        <option>LIBRE</option>
                        <option>OCUPADO</option>
                    </select>
                    @error('availability') <span class="text-danger er">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Observaciones</label>
                <textarea wire:model.lazy="observations" class="form-control" placeholder="Cuenta para ....... plataforma"></textarea>
                @error('observations') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>    
    </div>

    
    <div class="col-sm-12 col-md-4" style="background: #f0ecec">        

        <br>
        <div class="col-sm-12 col-md-12 mt-2">
            <button wire:click="Email()" class="btn btn-dark btn-block">
                Generar Correo
            </button>
        </div> 

        <div class="col-sm-12 col-md-12 mt-2">
            <button wire:click="Pass()" class="btn btn-dark btn-block">
                Generar Contraseña
            </button>
        </div>        

        <div class="col-sm-6 col-md-12 mt-2">
            <label class="form-label ">Longitud</label>
            <input type="number" wire:model.lazy="longitud" class="form-control text-center" min="1" max="10" value="6" />
        </div>

        <div class="n-chk col-sm-6 col-md-12 mt-3">
            <label class="new-control new-checkbox checkbox-primary">
                <input type="checkbox" wire:model.lazy="checkN" class="new-control-input" />
                <span class="new-control-indicator"></span>
                <h6>Incluir Números</h6>
            </label>            
        </div>

        <div class="n-chk col-sm-6 col-md-12 mt-3">
            <label class="new-control new-checkbox checkbox-primary">
                <input type="checkbox" wire:model.lazy="checkS" class="new-control-input" />
                <span class="new-control-indicator"></span>
                <h6>Incluir Puntos</h6>
            </label>
            
        </div>

        
        
    </div>



    
</div>

@include('common.modalFooter')
