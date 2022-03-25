@include('common.modalHead')
<div class="row">
    <div class="col-12 col-lg-12 col-md-3">

        <div class="form-group">
            <select wire:model='selected_id2' class="form-control">
              <option value="null">Origen</option>
              @foreach ($data_suc as $data)
              <option value="{{ $data->id }}">{{ $data->sucursal }}-{{$data->destino}}</option>
              @endforeach             
            </select>
          </div>
        </div>
        <div class="col-12 col-lg-12 col-md-3">
        <div class="form-group">
            <select wire:model='selected_id3' class="form-control">
              <option value="null">Destino de Transferencia</option>
              @foreach ($data_suc as $data)
              <option value="{{ $data->id }}">{{ $data->sucursal }}-{{$data->destino}}</option>
              @endforeach             
            </select>
          </div>
          </div>
          @include('common.modalFooter')
</div>