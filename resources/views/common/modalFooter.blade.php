      </div>
      <div class="modal-footer" style="background: #f0ecec">
          <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
              data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
          @if ($selected_id < 1)
              <button type="button" wire:click.prevent="Store()"
                  class="btn btn-dark close-btn text-info">GUARDAR</button>
          @else
              <button type="button" wire:click.prevent="Update()"
                  class="btn btn-dark close-btn text-info">ACTUALIZAR</button>
          @endif


      </div>
      </div>
      </div>
      </div>
