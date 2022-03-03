<?php

namespace App\Http\Livewire;

use App\Models\I_Supplier;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InvSupliersController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $nombre,$apellido,$direccion,$telefono,$correo, $selected_id;
    public  $pageTitle, $componentName;
    private $pagination = 5;
    
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Proveedores Productos';
        $this->selected_id = 0;
    }

    public function render()
    {
        
            if (strlen($this->search) > 0)
                $suplier = I_Supplier::select('i_supliers.*')
                ->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('apellido','like','%'.$this->search.'%')
                ->orWhere('direccion','like','%'.$this->search.'%')
                ->orWhere('status','like','%'.$this->search.'%')
                ->paginate($this->pagination);
            else
            $suplier = I_Supplier::select('i_supliers.*')
            ->paginate($this->pagination);

            return view('livewire.i_suplier.component', [
                'data_proveedor' => $suplier
            ])
                ->extends('layouts.theme.app')
                ->section('content');
        
    }
    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:i_supliers',
            'apellido' => 'required',
            
            
        ];
        $messages = [
            'nombre.required' => 'El nombre del proveedor es requerido.',
            'nombre.unique' => 'Ya existe un proveedor  con ese nombre.',
            'apellido.required' => 'El apellido del proveedor es requerido.'
        ];
        $this->validate($rules, $messages);

        I_Supplier::create([
            'nombre' => $this->nombre,
            'apellido'=>$this->apellido,
            'direccion' => $this->direccion,
            'telefono'=>$this->telefono,
            'correo'=>$this->correo
            
        ]);

        $this->resetUI();
        $this->emit('proveedor-added', 'proveedor Registrada');
    }
    public function Edit(I_Supplier $sup)
    {
        $this->selected_id = $sup->id;
        $this->nombre = $sup->nombre;
        $this->apellido = $sup->apellido;
        $this->direccion = $sup->direccion;
        $this->telefono = $sup->telefono;
        $this->correo = $sup->correo;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre.required' => 'El nombre del proveedor es requerido.',
            'nombre.unique' => 'Ya existe un proveedor  con ese nombre.',
            'apellido.required' => 'El apellido del proveedor es requerido.'
        ];
        $messages = [
            'nombre.required' => 'El nombre del proveedor es requerido.',
            'nombre.unique' => 'Ya existe un proveedor  con ese nombre.',
            'apellido.required' => 'El apellido del proveedor es requerido.'

        ];
        $this->validate($rules, $messages);
        $uni = I_Supplier::find($this->selected_id);
        $uni->update([
            'nombre' => $this->nombre,
            'apellidos'=>$this->apellido,
            'direccion' => $this->direccion,
            'telefono'=>$this->telefono,
            'correo'=>$this->correo
            
        ]);
        $uni->save();

        $this->resetUI();
        $this->emit('proveedor-updated', 'proveedor Actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(I_Supplier $uni)
    {
        $uni->delete();
        $this->resetUI();
        $this->emit('proveedor-deleted', 'Unidad Eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->apellido='';
        $this->direccion='';
        $this->telefono='';
        $this->correo='';
    }
}
