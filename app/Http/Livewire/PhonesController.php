<?php

namespace App\Http\Livewire;

use App\Models\Phone;
use App\Models\Sucursal;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PhonesController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $phone, $description, $status, $sucursal_id,
    $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->sucursal_id = 'Elegir';
        $this->status = 'Elegir';
        $this->pageTitle = 'Listado';
        $this->componentName = 'Telefonos';
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $phon = Phone::join('sucursals as s', 's.id', 'phones.sucursal_id')
            ->select('phones.name as name', 'phones.phone as phone', 'phones.description as desc', 'phones.status as status',
            's.name as sname')
            ->where('phones.name', 'like', '%' . $this->search . '%')
            ->orWhere('phones.phone', 'like', '%' . $this->search . '%')
            ->orWhere('phones.description', 'like', '%' . $this->search . '%')
            ->orWhere('phones.status', 'like', '%' . $this->search . '%')
            ->orWhere('sucursals.name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);
        else
            $phon = Phone::join('sucursals as s', 's.id', 'phones.sucursal_id')
            ->select('phones.*', 's.name as sucursal')
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);

        return view('livewire.phones.component', [
            'telfs' => $phon,
            'sucursals' => Sucursal::orderBy('id', 'desc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'phone' => 'required|min:8',
            'status' => 'required|not_in:Elegir',
            'sucursal_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'phone.required' => 'El teléfono es requerido',
            'phone.min' => 'El teléfono debe tener al menos 8 dígitos',
            'status.required' => 'El estado es requerido',
            'status.not_in' => 'Elija un estado distinto a Elegir',
            'sucursal_id.required' => 'La sucursal es requerida',
            'sucursal_id.not_in' => 'Elija una sucursal distinta a Elegir'
        ];

        $this->validate($rules, $messages);
        
        DB::beginTransaction();
        try{           

            Phone::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'description' => $this->description,
                'status' => $this->status,
                'sucursal_id' => $this->sucursal_id
            ]);         

            DB::commit();

            $this->resetUI();
            $this->emit('item-added', 'Teléfono Registrado');

        }catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }        
    }

    public function Edit(Phone $p)
    {
        $this->selected_id = $p->id;
        $this->name = $p->name;
        $this->phone = $p->phone;
        $this->description = $p->description;
        $this->status = $p->status;
        $this->sucursal_id = $p->sucursal_id;

        $this->emit('modal-show', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'phone' => 'required|min:8',
            'status' => 'required|not_in:Elegir',
            'sucursal_id' => 'required|not_in:Elegir'
        ];
        $messages = [
            'phone.required' => 'El teléfono es requerido',
            'phone.min' => 'El teléfono debe tener al menos 8 dígitos',
            'status.required' => 'El estado es requerido',
            'status.not_in' => 'Elija un estado distinto a Elegir',
            'sucursal_id.required' => 'La sucursal es requerida',
            'sucursal_id.not_in' => 'Elija una sucursal distinta a Elegir'
        ];

        $this->validate($rules, $messages);

        $pho = Phone::find($this->selected_id);

        $pho->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'description' => $this->description,
            'status' => $this->status,
            'sucursal_id' => $this->sucursal_id
        ]); 

        $this->resetUI();
        $this->emit('item-updated', 'Teléfono actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];
    
    public function Destroy(Phone $p)
    {       
        $p->delete();

        $this->resetUI();
        $this->emit('item-deleted', 'Teléfono eliminado');
    }
    public function resetUI()
    {
        $this->name = '';
        $this->phone = '';
        $this->description = '';
        $this->status = 'Elegir';
        $this->sucursal_id = 0;
        $this->selected_id = 0;
        $this->search = '';

        $this->resetValidation();
    }
}