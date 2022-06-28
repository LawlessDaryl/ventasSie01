      </div>
      <div class="modal-footer">
          <button type="button" wire:click.prevent="resetUI()" class="btn btn-danger rounded close-btn shadow 
          text-dark font-weight-bold border-0"
              data-dismiss="modal" style="border-color: #1c1c1c">CANCELAR</button>
          @if ($selected_id < 1)
              <button type="button" wire:click.prevent="Store()"
                  class="btn btn-success text-white close-btn border-0" style="background:#ee761c;">GUARDAR</button>
          @else
              <button type="button" wire:click.prevent="Update()"
                  class="btn btn-success text-white close-btn border -0 hover-zoom" style="background:#ee761c;">ACTUALIZAR</button>
          @endif


      </div>
      </div>
      </div>
      </div>
