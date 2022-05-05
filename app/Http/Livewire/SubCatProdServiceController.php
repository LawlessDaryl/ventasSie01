<?php

namespace App\Http\Livewire;

use App\Models\CatProdService;
use App\Models\SubCatProdService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SubCatProdServiceController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $status/* ,  $price */,  $categoryid, $search,  $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'LISTADO';
        $this->componentName = 'SUB CATEGORÍA PRODUCTOS';
        $this->categoryid = 'Elegir';
        $this->status = 'Elegir';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $products = SubCatProdService::join('cat_prod_services as c', 'c.id', 'sub_cat_prod_services.cat_prod_service_id')
                ->select('sub_cat_prod_services.*', 'c.nombre as categoria')
                ->where('sub_cat_prod_services.name', 'like', '%' . $this->search . '%')
                /* ->orWhere('sub_cat_prod_services.price', 'like', '%' . $this->search . '%') */
                ->orWhere('c.nombre', 'like', '%' . $this->search . '%')
                ->orderBy('sub_cat_prod_services.id', 'desc')
                ->paginate($this->pagination);
        } else {
            $products = SubCatProdService::join('cat_prod_services as c', 'c.id', 'sub_cat_prod_services.cat_prod_service_id')
                ->select('sub_cat_prod_services.*', 'c.nombre as categoria')
                ->orderBy('sub_cat_prod_services.id', 'desc')
                ->paginate($this->pagination);
        }
        return view('livewire.sub_categoria_producto_servicio.component', [
            'data' => $products,
            'cate' => CatProdService::orderBy('nombre', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'name' => "required|min:1|exclude_if:sub_cat_prod_services,name,{$this->selected_id}",
            /* 'price' => 'required',
            'price' => 'required|numeric', */
            'status' => 'required|not_in:Elegir',
            'categoryid' => 'required|not_in:Elegir'
        ];
        $messages = [
            'name.required' => 'Nombre de la sub categoria requerida',
            'name.unique' => 'Ya existe el nombre de la sub categoria ',
            'name.min' => 'El nombre debe ser contener al menos 3 caracteres',
            /* 'price.required' => 'El precio es requerido',
            'price.numeric' => 'No puede ingresar letras', */
            'status.required' => 'Selecciona el estado de la categoria',
            'categoryid.not_in' => 'Elegir un nombre de categoria diferente de Elegir'
        ];

        $this->validate($rules, $messages);

        $product = SubCatProdService::create([
            'name' => $this->name,
            /* 'price' => $this->price, */
            'status' => $this->status,
            'cat_prod_service_id' => $this->categoryid
        ]);
        
        $this->resetUI();
        $this->emit('item-added', 'Sub Categoria Registrada');
    }
    public function Edit(SubCatProdService $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        /* $this->price = $product->price; */
        $this->status = $product->status;
        $this->categoryid = $product->cat_prod_service_id;
      
        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    { $rules = [
        'name' => "required|min:1|unique:sub_cat_prod_services,name,{$this->selected_id}",
        /* 'price' => 'required',
        'price' => 'required|numeric', */
        'status' => 'required|not_in:Elegir',
        'categoryid' => 'required|not_in:Elegir'
    ];
    $messages = [
        'name.required' => 'Nombre de la sub categoria requerida',
        'name.unique' => 'Ya existe el nombre de la sub categoria ',
        'name.min' => 'El nombre debe ser contener al menos 1 caracter',
        /* 'price.required' => 'El precio es requerido',
        'price.numeric' => 'No puede ingresar letras', */
        'status.required' => 'Selecciona el estado de la categoria',
        'categoryid.not_in' => 'Elegir un nombre de categoria diferente de Elegir'
    ];
        
        $this->validate($rules, $messages);
        $product = SubCatProdService::find($this->selected_id);
        $product->update([
            'name' => $this->name,
            /* 'price' => $this->price, */
            'status' => $this->status,
            'cat_prod_service_id' => $this->categoryid
        ]);
       
        $this->resetUI();
        $this->emit('item-updated', 'Sub Categoria Actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(SubCatProdService $product)
    {
        $product->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Sub Categoría Eliminado');
    }
    public function resetUI()
    {
        $this->categoryid = 'Elegir';
        $this->name = '';
        /* $this->price = ''; */
        $this->status = 'Elegir';
        $this->search = '';
        $this->selected_id = 0;

        $this->resetValidation();
    }
}
