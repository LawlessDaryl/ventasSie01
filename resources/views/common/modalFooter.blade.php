      </div>
      <div class="modal-footer">
          <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning"
              data-dismiss="modal" style="background: #3b3f5c">Cancelar</button>
          @if ($selected_id < 1)
              <button type="button" wire:click.prevent="Store()"
              class="btn btn-warning">Guardar</button>
          @else
              <button type="button" wire:click.prevent="Update()"
              class="btn btn-warning">Actualizar</button>
          @endif


      </div>
      </div>
      </div>
      </div>
