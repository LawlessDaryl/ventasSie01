<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                   
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Agregar Categoria</a>
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal_s">Agregar Subcategoria</a>
                    
                </ul>
            </div>

            
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe">NOMBRE</th>
                                <th class="table-th text-withe text-center">DESCRIPCION</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                             
                            </tr>
                        </thead>
                       
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        
                                        <h6>{{ $category->name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $category->descripcion }}</h6>
                                    </td>
                                   
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $category->id }}','{{ $category->name }}',
                                            '{{ $category->products->count() }}')" class="btn btn-dark"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="javascript:void(0)" wire:click="Ver({{$category->id}})"
                                            class="btn btn-dark mtmobile" title="Ver subcategorias">
                                            <i class="fas fa-eye"></i>
                                           
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('show-modal_s', Msg => {
            $('#theModal_sub').modal('show')
        });
        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-deleted', Msg => {
            noty(Msg)
        });
        window.livewire.on('show-modal_sub', Msg => {
            $('#theModal_subcategory').modal('show')
        });

    });

    function Confirm(id, name, products) {
        if (products > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la categoria, ' + name + ' porque tiene ' 
                + products + ' productos relacionados'
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
