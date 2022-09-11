@section('css')
<style>
    .tablainventarios {
        width: 100%;
    
        min-height: 140px;
    }
    .tablainventarios thead {
        background-color: #1572e8;
        color: white;
    }
    .tablainventarios th, td {
        border: 0.5px solid #1571e894;
        padding: 4px;
    }
    tr:hover {
        background-color: rgba(99, 216, 252, 0.336);
    }
        

</style>
@endsection
    










<div class="row">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div>
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="row justify-content-end">
                   
                    <a href="javascript:void(0)" class="btn btn-outline-primary" wire:click="$set('selected_id','0')" data-toggle="modal"
                        data-target="#theModal"> <b> <i class="fas fa-plus-circle"></i> Crear Categoria</b> </a>
                    {{-- <a href="javascript:void(0)" class="btn btn-dark m-1 p-2" wire:click="$set('selected_id','0')" data-toggle="modal"
                        data-target="#theModal_s"> <b>Crear Subcategoria</b> </a> --}}
                    {{-- <a href="javascript:void(0)" class="btn btn-dark m-1" data-toggle="modal"
                        data-target="#modalimportcat">Importar Categorias</a>
                    <a href="javascript:void(0)" class="btn btn-dark m-1" data-toggle="modal"
                        data-target="#modalimportsubcat">Importar SubCategorias</a> --}}
                    
                </ul>
            </div>

            
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="tablainventarios">
                        <thead>
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th> <center>NOMBRE</center> </th>
                                {{-- <th class="table-th text-withe text-center">DESCRIPCION</th> --}}
                                <th style="width: 60px;"> <center> SUBCATEGORIAS</center></th>
                                <th style="width: 150px;"> <center>ACCIONES</center> </th>
                             
                            </tr>
                        </thead>
                       
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        
                                        <h6>{{ ($categories->currentpage()-1) * $categories->perpage() + $loop->index + 1 }}</h6>
                                    </td>
                                    <td>
                                        
                                        <h6> <b>{{ $category->name }}</b> </h6>
                                        <label for=""> Descripcion : {{$category->descripcion}}</label>
                                    </td>
                                   
                                
                                    <td>
                                       
                                        <center>
                                            <a href="javascript:void(0)" wire:click="Ver({{$category->id}})"
                                            class="btn btn-info m-1 text-dark p-1" title="Ver subcategorias"> <b class="pl-1">{{ $category->subcategories()}}</b> 
                                            <i class="fas fa-eye"></i>
                                            </a>
                                        </center>
                                   
                                    </td>
                                   
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})"
                                            class="btn btn-dark p-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})"
                                            class="btn btn-dark p-1" title="Edit">
                                            <i class="fas fa-plus"></i>
                                        </a> --}}

                                        <a href="javascript:void(0)" class="btn btn-primary p-1" wire:click="asignarCategoria('{{$category->id}}')" title="Agregar subcategorias"
                                         <b> <i class="fas fa-plus"></i></b> </a>
                                 
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $category->id }}','{{ $category->name }}','{{$category->products->count()}}','{{$category->subcategories()}}')"
                                           class="btn btn-danger p-1"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.category.form')
    @include('livewire.category.form_subcategory')
    @include('livewire.category.subcategories')
    @include('livewire.category.importarcategorias')
    @include('livewire.category.importarsubcategorias')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('hide_modal_sub', Msg => {
            $('#theModal_subcategory').modal('hide')
        });
        window.livewire.on('modal_sub', Msg => {
            $('#theModal_subcategory').modal('show')
        });
        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('sub-show', Msg => {
            $('#theModal_s').modal('show')
          
        });
        window.livewire.on('sub_added', Msg => {
            $('#theModal_s').modal('hide')
            
        });
        window.livewire.on('item-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-deleted', Msg => {
            noty(Msg)
        });
       

    });

    function Confirm(id, name,products,subcategories) {
        if (products > 0 || subcategories>0) {
            const auxiliar= subcategories;
            const letras=auxiliar>0?'y subcategorias relacionadas':'no tiene ninguna subcategoria';
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la categoria, ' + name + ' porque tiene'+ 
            'productos relacionados/'+ letras
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la categoria ' + '"' + name + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>
