<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Marca;
use App\Models\Product;
use App\Models\Unidad;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductsController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $nombre, $costo, $precio_venta,$cantidad_minima,
    $codigo,$lote,$unidad,$industria,$caracteristicas,$status,$categoryid, $search,
     $image, $selected_id, $pageTitle, $componentName,$cate,$marca,$garantia,$stock,$stock_v
     ,$selected_categoria,$selected_sub,$nro=1,$sub;

    private $pagination = 5;
    public $selected_id2=0;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName ='Productos';
        $this->categoryid ='Elegir';
        $this->selected_id2=0;
        $this->cate='Elegir';
        
    }
    public function render()
    {
      
       if ($this->selected_categoria !== null ) {

        if ($this->selected_sub == null) {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->where('c.categoria_padre',$this->selected_categoria)
            ->where(function($query){
                $query->where('products.nombre_prod', 'like', '%' . $this->search . '%')
                        ->orWhere('products.codigo', 'like', '%' . $this->search . '%');
                        
            })
            
            ->orderBy('products.id', 'desc')
            ->paginate($this->pagination);
        }
        else{
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->where('c.id',$this->selected_sub)
            ->where(function($query){
                $query->where('products.nombre_prod', 'like', '%' . $this->search . '%')
                        ->orWhere('products.codigo', 'like', '%' . $this->search . '%');
                        
            })
            
            ->orderBy('products.id', 'desc')
            ->paginate($this->pagination);
        }
      
      
           
        }

      

         elseif (strlen($this->search) > 0) {

        
        $products = Product::join('categories as c', 'c.id', 'products.category_id')
        ->select('products.*', 'c.name as category')
        ->where('products.nombre_prod', 'like', '%' . $this->search . '%')
        ->orWhere('products.codigo', 'like', '%' . $this->search . '%')
        ->orWhere('c.name', 'like', '%' . $this->search . '%')
        ->orderBy('products.id', 'desc')
        ->paginate($this->pagination);
     }


        else {
          
             
                $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.*')      
                ->orderBy('products.id', 'desc')
                ->paginate($this->pagination);}
            
        
        $this->sub= Category::select('categories.*')
        ->where('categories.categoria_padre',$this->selected_categoria)
     
        ->get();

        return view('livewire.products.component', [
            'data' => $products,
            'categories'=>Category::where('categories.categoria_padre',0)->orderBy('name', 'asc')->get(),
            'unidades'=>Unidad::orderBy('nombre','asc')->get(),
            'marcas'=>Marca::select('nombre')->orderBy('nombre','asc')->get(),
            'subcat'=>$this->sub
        ])->extends('layouts.theme.app')->section('content');
    }
    public function Store()
    {
        $rules = [
            'nombre_prod' => 'required|unique:products|min:5',
            'costo' => 'required',
            'precio_venta' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'nombre_prod.required' => 'Nombre del producto requerido',
            'nombre_prod.unique' => 'Ya existe el nombre del producto',
            'nombre_prod.min' => 'El nombre debe ser contener al menos 3 caracteres',
            'costo.required' =>'El costo es requerido',
            'precio_venta.required'=> 'El precio es requerido',
            'categoryid.required' => 'La categoria es requerida',
            'categoryid.not_in' => 'Elegir un nombre de categoria diferente de Elegir'
        ];

        $this->validate($rules, $messages);

        $product = Product::create([
            'nombre_prod' => $this->nombre_prod,
            'costo' => $this->costo,
            'caracteristicas'=>$this->caracteristicas,
            'codigo'=>$this->codigo,
            'lote'=>$this->lote,
            'unidad'=>$this->unidad,
            'marca' => $this->marca,
            'garantia' => $this->garantia,
            'cantidad_minima' => $this->cantidad_minima,
            'industria' => $this->industria,
            'precio_venta' => $this->precio_venta,
            'category_id' => $this->categoryid
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/images/productos/', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }
        else{
            $product->image='noimage.jpg';
            $product->save();
        }
        
        $this->emit('product-added', 'Producto Registrado');
        $this->resetUI();
    }
    public function Edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->selected_id2 = $product->category->categoria_padre;
        $this->costo = $product->costo;
        $this->nombre = $product->nombre;
        $this->precio_venta=$product->precio_venta;
        $this->caracteristicas=$product->caracteristicas;
        $this->barcode = $product->barcode;
        $this->lote = $product->lote;
        $this->unidad = $product->unidad;
        $this->marca = $product->marca;
        $this->garantia = $product->garantia;
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
            'categoryid' => 'required|not_in:Elegir'
        ];
        $messages = [
            'nombre.required' => 'Nombre del producto requerido',
            'nombre.unique' => 'Ya existe el nombre del producto',
            'nombre.min' => 'El nombre debe ser contener al menos 3 caracteres',
            'costo.required' =>'El costo es requerido',
            'precio_venta.required'=> 'El precio es requerido',
            'categoryid.required' => 'La categoria es requerida',
            'categoryid.not_in' => 'Elegir un nombre de categoria diferente de Elegir'
        ];
        $this->validate($rules, $messages);
        $product = Product::find($this->selected_id);
        $product->update([
            'nombr_prod' => $this->nombre,
            'costo' => $this->costo,
            'caracteristicas'=>$this->caracteristicas,
            'codigo'=>$this->codigo,
            'lote'=>$this->lote,
            'unidad'=>$this->unidad,
            'marca' => $this->marca,
            'garantia' => $this->garantia,
            'cantidad_minima' => $this->cantidad_minima,
            'industria' => $this->industria,
            'precio_venta' => $this->precio_venta,
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
        $this->selected_id2 =0;
        $this->costo = '';
        $this->nombre_prod = '';
        $this->precio_venta='';
        $this->caracteristicas='';
        $this->codigo ='';
        $this->lote = '';
        $this->unidad = 'Elegir';
        $this->marca = 'Elegir';
        $this->industria = '';
        $this->garantia = '';
        $this->cantidad_minima = '';
        $this->categoryid = 'Elegir';
        $this->image = null;

        $this->resetValidation();
    }

    public function GenerateCode(){
        
        $min=10000;
        $max= 99999;
        $this->codigo= Carbon::now()->format('ymd').mt_rand($min,$max);
    }
}
