<div wire:ignore.self class="modal fade" id="theModal_cat" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        
      <div class="modal-content">
        <div class="modal-header" style="background: #414141">
            <h5 class="modal-title text-white">
                <b>Importar Categorias</b>
            </h5>
        </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Importar Categorias</div>

                <div class="card-body">
                    @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                        {{$error}}
                        @endforeach
                    </div>
                    @endif

                    <form action="{{route('importar')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="import_file" />

                        <button class="btn btn-primary" type="submit">Importar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>