<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $name,$descripcion, $search,$categoryid, $selected_id, $pageTitle, $componentName,$categoria_padre;
    private $pagination = 5;
    public $category_s = 0;
    public $subcat_s=false;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
        $this->componentSub = 'Subcategorias';
        $this->subcat_fill= 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Category::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('categoria_padre',$this->category_s)
            ->paginate($this->pagination);
        else
            $data = Category::orderBy('id', 'desc')
            ->orWhere('categoria_padre',$this->category_s)
            ->paginate($this->pagination);

            $data2=Category::where('categoria_padre',$this->selected_id)
            ->select('categories.*')->get();
           
        return view('livewire.category.categories', ['categories' => $data,'subcat'=>$data2])
            ->extends('layouts.theme.app')
            ->section('content');



    }

    public function Edit($id)
    {
        $record = Category::find($id, ['id', 'name', 'descripcion']);
        $this->selected_id = $record->id;
        $this->name = $record->name;
        $this->descripcion = $record->descripcion;
        $this->emit('show-modal', 'show modal!');

    }
    public function Ver(Category $category)
    {
        $this->selected_id = $category->id;
        $this->emit('show-modal_s', 'show modal!');
    }

    public function Store()
    {
        $rules = ['name' => 'required|unique:categories|min:3'];
        $messages = [
            'name.required' => 'El nombre de la categoría es requerido',
            'name.unique' => 'Ya existe el nombre de la categoría',
            'name.min' => 'El nombre de la categoría debe tener al menos 3 caracteres'
        ];
        $this->validate($rules, $messages);
        if ($this->categoria_padre) 
        {
            $category = Category::create([
                'name' => $this->name,
                'descripcion'=>$this->descripcion,
                'categoria_padre'=>$this->categoria_padre
            ]);
        }
        else
        {
          
            $category = Category::create([
                'name' => $this->name,
                'descripcion'=>$this->descripcion
            ]);
        }

        $category->save();
        $this->resetUI();
        $this->emit('item-added', 'Categoría Registrada');
    }

    

    public function Store_Subcategoria()
    {
        $rules = ['name' => 'required|unique:categories|min:3'];
        $messages = [
            'name.required' => 'El nombre de la categoría es requerido',
            'name.unique' => 'Ya existe el nombre de la categoría',
            'name.min' => 'El nombre de la categoría debe tener al menos 3 caracteres'
        ];
        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name,
            'descripcion'=>$this->descripcion,
            'categoria_padre'=>$this->categoria_padre
        ]);

        $category->save();
        $this->resetUI();
        $this->emit('item-added', 'Categoría Registrada');
    }


    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];
        $messages = [
            'name.required' => 'El nombre de la categoría es requerido',
            'name.unique' => 'Ya existe el nombre de la categoría',
            'name.min' => 'El nombre de la categoría debe tener al menos 3 caracteres'
        ];
        $this->validate($rules, $messages);
        $category = Category::find($this->selected_id);

        $category->update([
            'name' => $this->name,
            'descripcion'=>$this->descripcion
        ]);
        $this->resetUI();
        $this->emit('item-updated', 'Categoria Actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Category $category)
    {
        $imageName = $category->image;
        $category->delete();
        if ($imageName != null) {
            unlink('storage/categorias/' . $imageName);
        }
        $this->resetUI();
        $this->emit('item-deleted', 'Categoria eliminada');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
