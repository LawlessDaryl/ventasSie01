<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Marca;
use App\Models\Product;
use App\Models\Unidad;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductsController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $nombre, $barcode, $costo, $precio_venta,$cantidad_minima,$codigo,$lote,$unidad,$industria,$caracteristicas,$status,$categoryid, $search,
     $image, $selected_id, $pageTitle, $componentName,$cate,$marca;

    private $pagination = 5;
    public $subs=0;
    public $selected_id2=0;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->categoryid = 'Elegir';
        $this->selected_id2=0;
        $this->cate='Elegir';
        
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                ->orderBy('products.id', 'desc')
                ->paginate($this->pagination);
        } else {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.id', 'desc')
                ->paginate($this->pagination);
        }
        $sub= Category::where('categories.categoria_padre',$this->selected_id2)
        ->where('categories.categoria_padre','!=','Elegir')
        ->get();

     

        return view('livewire.products.component', [
            'data' => $products,
            'categories' => Category::where('categories.categoria_padre',0)->orderBy('name', 'asc')->get(),
            'subcat'=>$sub,
            'unidades'=>Unidad::orderBy('nombre','asc')->get(),
            'marcas'=>Marca::orderBy('nombre','asc')->get()
            
        ])->extends('layouts.theme.app')->section('content');
    }
    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:products|min:5',
            'costo' => 'required',
            'precio_venta' => 'required',
            'cantidad_minima' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'Nombre del producto requerido',
            'nombre.unique' => 'Ya existe el nombre del producto',
            'nombre.min' => 'El nombre debe ser contener al menos 3 caracteres',
            'costo.required' =>'El costo es requerido',
            'precio_venta.required'=> 'El precio es requerido',
            'cantidad_minima.required'=> 'La cantidad minima es requerida',
            'categoryid.required' => 'La categoria es requerida',
            'categoryid.not_in' => 'Elegir un nombre de categoria diferente de Elegir'
        ];

        $this->validate($rules, $messages);
        $product = Product::create([
            'nombre' => $this->nombre,
            'costo' => $this->costo,
            'precio_venta' => $this->precio_venta,
            'barcode' => $this->barcode,
            'codigo'=>$this->codigo,
            'caracteristicas'=>$this->caracteristicas,
            'lote'=>$this->lote,
            'unidad'=>$this->unidad,
            'marca' => $this->marca,
            'industria' => $this->industria,
            'cantidad_minima'=>$this->cantidad_minima,
            'status'=>$this->status,
            'category_id' => $this->categoryid
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/productos', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }
        else{
            $product->image='noimage.jpg';
            $product->save();
        }
        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado');
    }
    public function Edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->costo = $product->costo;
        $this->nombre = $product->nombre;
        $this->precio_venta=$product->precio_venta;
        $this->caracteristicas=$product->caracteristicas;
        $this->barcode = $product->barcode;
        $this->lote = $product->lote;
        $this->unidad = $product->unidad;
        $this->marca = $product->marca;
        $this->industria = $product->industria;
        $this->categoryid = $product->category_id;
        $this->image = null;

        $this->emit('modal-show', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre' => "required|min:3|unique:products,nombre,{$this->selected_id}",
            'costo' => 'required',
            'precio_venta' => 'required',
            'cantidad_min' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'Nombre del producto requerido',
            'nombre.unique' => 'Ya existe el nombre del producto',
            'nombre.min' => 'El nombre debe ser contener al menos 3 caracteres',
            'costo.required' =>'El costo es requerido',
            'precio_venta.required'=> 'El precio es requerido',
            'cantidad_min.required'=> 'La cantidad minima es requerida',
            'categoryid.required' => 'La categoria es requerida',
            'categoryid.not_in' => 'Elegir un nombre de categoria diferente de Elegir'
        ];
        $this->validate($rules, $messages);
        $product = Product::find($this->selected_id);
        $product->update([
            'nombre' => $this->nombre,
            'costo' => $this->costo,
            'precio_venta' => $this->precio_venta,
            'barcode' => $this->barcode,
            'codigo'=>$this->codigo,
            'caracteristicas'=>$this->caracteristicas,
            'lote'=>$this->lote,
            'unidad'=>$this->unidad,
            'marca' => $this->marca,
            'industria' => $this->industria,
            'cantidad_minima'=>$this->cantidad_minima,
            'status'=>$this->status,
            'category_id' => $this->categoryid
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/productos', $customFileName);
            $imageTemp = $product->image;
            $product->image = $customFileName;
            $product->save();

            if ($imageTemp != null) {
                if (file_exists('storage/productos/' . $imageTemp)) {
                    unlink('storage/productos/' . $imageTemp);
                }
            }
        }
        $this->resetUI();
        $this->emit('product-updated', 'Producto Actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Product $product)
    {
        $imageTemp = $product->image;
        $product->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/productos/' . $imageTemp)) {
                unlink('storage/productos/' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('product-deleted', 'Producto Eliminado');
    }
    public function resetUI()
    {
        
        $this->selected_id =0;
        $this->costo = '';
        $this->nombre = '';
        $this->precio_venta='';
        $this->caracteristicas='';
        $this->barcode ='';
        $this->lote = '';
        $this->unidad = '';
        $this->marca = '';
        $this->industria = '';
        $this->categoryid = 'Elegir';
        $this->image = null;

        $this->resetValidation();
    }
}
