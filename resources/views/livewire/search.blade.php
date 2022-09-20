

  

    <div class="collapse" id="search-nav">
        {{-- <form class="navbar-left navbar-form nav-search mr-md-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <button type="submit" class="btn btn-search pr-1">
                <i class="fa fa-search search-icon"></i>
              </button>
            </div>
            <input id="code" type="text" wire:keydown.enter.prevent="$emit('scan-code',$('#code').val())" class="form-control " placeholder="Escanear Producto..." autofocus>
      
            
          </div>
        </form> --}}
      </div>
      <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
        <li class="nav-item toggle-nav-search hidden-caret">
          <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
            <i class="fa fa-search"></i>
          </a>
        </li>
    <script>
        document.addEventListener('DOMContentLoaded',function(){
            livewire.on('scan-code',action=>{
                $('#code').val('')
            })
        })
    </script>
    

