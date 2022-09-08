<div wire:ignore.self class="modal fade" id="modalimport" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        
      <div class="modal-content">
        <div class="modal-header bg-primary" style="background: #414141">
            <h5 class="modal-title text-white">
                <b>Importar Productos</b>
            </h5>
        </div>

    <div class="row">
        <div class="col-lg-12 mb-2">
           
         

                <div class="form-group" >
                    @if ($failures)
                    <div class="alert alert-danger" role="alert">
                        @foreach ($failures as $failure)
                        @foreach ($failure->errors() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                     @endforeach
                    </div>
                    @endif

                    <form wire:submit.prevent="import('{{$archivo}}')" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{$archivo}}
                        <input type="file" name="import_file" wire:model="archivo" />
                    </form>
                    </div>
                    <div class="col-lg-12 m-2">
                        <button class="btn btn-primary" type="submit" >Importar</button>
                        <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning"
                        data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                    </div>
                 
                </div>
            
       
    </div>
</div>
</div>

</div>