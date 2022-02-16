<?php

namespace App\Http\Livewire;


use App\Models\Sucursal;
use App\Models\Location;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class LocalizacionController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $sucursal, $codigo, $descripcion,$ubicacion, $aparador, 
    $selected_id, $pageTitle, $componentName,$search,$sucursals;
    private $pagination = 8;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Locaciones';
        $this->tipo = 'Elegir';
        $this->ubicacion = 'Elegir';
        $this->sucursal_id = 'Elegir';
     

    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $locations = Location::join('sucursals as s', 's.id', 'locations.sucursal_id')
                ->select('locations.*', 's.name as sucursal')
                ->where('locations.codigo', 'like', '%' . $this->search . '%')
                ->orWhere('locations.tipo', 'like', '%' . $this->search . '%')
                ->orWhere('s.name', 'like', '%' . $this->search . '%')
                ->orWhere('locations.ubicacion', 'like', '%' . $this->search . '%')
                ->orderBy('locations.id', 'desc')
                ->paginate($this->pagination);
        } else {
            $locations = Location::join('sucursals as s', 's.id', 'locations.sucursal_id')
                ->select('locations.*', 's.name as sucursal')
                ->orderBy('locations.id', 'desc')
                ->paginate($this->pagination);
        }

        $suc_data=Sucursal::select('sucursals.*')
        ->orderBy('sucursals.id','asc');

    
        return view('livewire.localizacion.component', [
            'data_locations' => $locations,
            'data_suc' => $suc_data->get(),
           
        
        ])->extends('layouts.theme.app')->section('content');
    }
    public function Store()
    {
        $rules = [
            'sucursal' => 'required|not_in:Elegir',
            'codigo' => 'required|unique:locations|min:4',
            'aparador' => 'required|not_in:Elegir',
            'ubicacion' => 'required|not_in:Elegir',
            'descripcion' => 'required|min:5',
            
        ];
        $messages = [
            'sucursal' => 'La sucursal es requerida',
            'sucursal_id.not_in' => 'Elegir un nombre de categoria diferente de Elegir',
            'codigo.required' => 'Codigo de la locacion es requerido',
            'codigo.unique' => 'Ya existe el codigo de la locacion',
            'codigo.min' => 'El codigo debe contener al menos 4 caracteres',
            'aparador.required' => 'El codigo debe contener al menos 4 caracteres',
            'aparador.not_in' => 'El codigo debe contener al menos 4 caracteres',
            'ubicacion.required' => 'La ubicacion es requerida',
            'ubicacion.not_in' => 'Elegir una ubicacion  diferente de Elegir',
            
            'descripcion.required' => 'La descripcion es requerida',
            'descripcion.min' => 'La descripcion debe contener al menos 10 caracteres',
        ];

        $this->validate($rules, $messages);
        $localizacion = Location::create([
            'sucursal_id' => $this->sucursal,
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'ubicacion' => $this->ubicacion,
            'tipo' => $this->aparador
            
        ]);
        
        $localizacion->save();
        $this->resetUI();
        $this->emit('localizacion-added', 'Localizacion Registrada Exitosamente');
    }
    public function Edit(Location $loc)
    {
        $this->selected_id = $loc->id;
        $this->aparador = $loc->tipo;
        $this->codigo = $loc->codigo;
        $this->descripcion = $loc->descripcion;
        $this->ubicacion = $loc->ubicacion;
        $this->sucursal = $loc->sucursal_id;
  

        $this->emit('modal-locacion', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'sucursal' => 'required|not_in:Elegir',
            'codigo' => 'required',
            'aparador' => 'required',
            'ubicacion' => 'required',
            'descripcion' => 'required',
        ];
        $messages = [
            'sucursal.required' => 'Sucursal requerida',
            'sucursal.not_int' => 'Elegir un nombre de categoria diferente de elegir',
            'codigo.required' => 'El codigo es requerido',
            'aparador.required' => 'El nombre de tipo aparador es requerido',
            'ubicacion.required' => 'La ubicacion es requerido',
            'descripcion.required' => 'La descripcion es requerida',
        ];
        $this->validate($rules, $messages);
        $locations = Location::find($this->selected_id);
        $locations->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
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

    public function Destroy(Location $loc)
    {
   
        $loc->delete();

        $this->resetUI();
        $this->emit('localizacion-deleted', 'Localizacion Eliminada');
    }
    public function resetUI()
    {
        $this->aparador = 'Elegir';
        $this->codigo = '';
        $this->descripcion = '';
        $this->ubicacion = 'Elegir';
        $this->sucursal = 'Elegir';
       

        $this->resetValidation();
    }
}
