<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Origen;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ClienteController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $nombre = "", $cedula, $celular, $direccion="", $email="", $fnacim, $razonsocial="", $nit="", $selected_id, $image;
    public  $pageTitle, $componentName;
    private $pagination = 6;
    
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Cliente';
        $this->selected_id = 0;
        $this->image = '';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $cliente = Cliente::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('cedula', 'like', '%' . $this->search . '%')
            ->orWhere('celular', 'like', '%' . $this->search . '%')
            ->orWhere('nit', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);
        else
            $cliente = Cliente::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.cliente.component', [
            'data' => $cliente,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'cedula' => 'required|min:5',
            'celular' => 'required|min:8'
        ];
        $messages = [
            'cedula.required' => 'Numero de cédula es requerido.',
            'cedula.min' => 'Ingrese un numero de cédula superior a 5 dígitos.',
            'celular.required' => 'Numero de celular es requerido.',
            'celular.min' => 'Ingrese un celular superior a 7 dígitos.'
        ];
        $this->validate($rules, $messages);

        Cliente::create([
            'nombre' => $this->nombre,
            'cedula' => $this->cedula,
            'celular' => $this->celular,
            'direccion' => $this->direccion,
            'email' => $this->email,
            'fecha_nacim' => $this->fnacim,
            'razon_social' => $this->razonsocial,
            'nit' => $this->nit
        ]);
        
        $this->resetUI();
        $this->emit('item-added', 'Cliente Registrado');
    }

    public function Edit(Cliente $cli)
    {
        $this->selected_id = $cli->id;
        $this->nombre = $cli->nombre;
        $this->cedula = $cli->cedula;
        $this->celular = $cli->celular;
        $this->email = $cli->email;
        $this->fnacim = $cli->fecha_nacim;
        $this->nit = $cli->nit;
        $this->direccion = $cli->direccion;
        $this->razonsocial = $cli->razon_social;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'cedula' => 'required|min:5',
            'celular' => 'required|min:8'
        ];
        $messages = [
            'cedula.required' => 'Numero de cédula es requerido.',
            'cedula.min' => 'Ingrese un numero de cédula superior a 5 dígitos.',
            'celular.required' => 'Numero de celular es requerido.',
            'celular.min' => 'Ingrese un celular superior a 7 dígitos.'
        ];
        $this->validate($rules, $messages);

        $cliente = Cliente::find($this->selected_id);
        $cliente->update([
            'nombre' => $this->nombre,
            'cedula' => $this->cedula,
            'celular' => $this->celular,
            'direccion' => $this->direccion,
            'email' => $this->email,
            'fecha_nacim' => $this->fnacim,
            'razon_social' => $this->razonsocial,
            'nit' => $this->nit
        ]);
        $cliente->save();

        $this->resetUI();
        $this->emit('item-updated', 'Cliente Actualizado');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Cliente $cli)
    {
        $cli->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Cliente Eliminado');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->nombre = '';
        $this->cedula = '';
        $this->celular = '';
        $this->email = '';
        $this->fnacim = '';
        $this->nit = '';
        $this->direccion = '';
        $this->razonsocial = '';
        
        $this->resetValidation();
    }
}
