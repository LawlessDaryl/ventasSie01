<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MensajesController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $module_id, $content, $status,
    $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->module_id = 'Elegir';
        $this->status = 'Elegir';
        $this->pageTitle = 'Listado';
        $this->componentName = 'Perfiles';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $men = Message::join('modules as m', 'm.id', 'messages.module_id')
                ->select('messages.*', 'm.id as modulo', 'm.name as mname')
                ->where('messages.name', 'like', '%' . $this->search . '%')
                ->orWhere('messages.status', 'like', '%' . $this->search . '%')
                ->orWhere('m.name', 'like', '%' . $this->search . '%')
                ->orderBy('messages.id', 'desc')
                ->paginate($this->pagination);
        } else {
            $men = Message::join('modules as m', 'm.id', 'messages.module_id')
                ->select('messages.id as id', 'messages.name as name', 'messages.module_id as modulo', 'messages.content as mensaje', 'messages.status as status',
                 'm.id as moduloid', 'm.name as mname')
                ->orderBy('messages.id', 'desc')
                ->paginate($this->pagination);           
        

            $mdl = Module::orderBy('modules.id', 'desc')->get();
        }

        return view('livewire.mensajes.component', [
            'message' => $men,
            'moduls' => $mdl
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        
        $rules = [
            'name' => 'required|min:8',
            'module_id' => 'required|not_in:Elegir',
            'content' => 'required|min:15',
            'status' => 'required|not_in:Elegir'
        ];
        $messages = [
            'name.required' => 'El nombre del mensaje es requerido',
            'name.min' => 'El nombre del mensaje debe tener almenos 8 caracteres',
            'module_id.required' => 'El modulo del mensaje es requerido',
            'module_id.not_in' => 'Seleccione un modulo distinto a Elegir',
            'content.required' => 'El contenido del mensaje es requerido',
            'content.min' => 'El contenido debe tener al menos 15 caracteres',
            'status.required' => 'El estado es requerido',
            'status.not_in' => 'Elija un estado distinto a Elegir'
        ];

        $this->validate($rules, $messages);
        
        DB::beginTransaction();
        try{
            $modu = Module::find($this->account_id);            

            Message::create([
                'name' => $this->name,
                'module_id' => $this->module_id,
                'content' => $this->status,
                'status' => $this->availability
            ]);           

            $modu->whole_account = 'DIVIDIDA';        
            $modu->save();    

            DB::commit();

            $this->resetUI();
            $this->emit('item-added', 'Perfil Registrado');

        }catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }        
    }

    public function Edit(Profile $prof)
    {
        $this->selected_id = $prof->id;
        $this->account_id = $prof->account_id;
        $this->pin = $prof->pin;
        $this->status = $prof->status;
        $this->availability = $prof->availability;
        $this->observations = $prof->observations;
        $this->expiration_plan = $prof->expiration_plan;

        $this->emit('modal-show', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'account_id' => 'required|not_in:Elegir',
            'status' => 'required|not_in:Elegir',
            'availability' => 'required|not_in:Elegir'
        ];
        $messages = [
            'account_id.required' => 'La cuenta de streaming es requerida',
            'account_id.not_in' => 'Seleccione una cuenta distinta a Elegir',
            'status.required' => 'El estado es requerido',
            'status.not_in' => 'Elija un estado distinto a Elegir',
            'availability.required' => 'La disponibilidad es requerida',
            'availability.not_in' => 'Elija una plataforma distinta a Elegir'
        ];

        $this->validate($rules, $messages);

        $prof = Profile::find($this->selected_id);

        $prof->update([
            'account_id' => $this->account_id,
            'pin' => $this->pin,
            'status' => $this->status,
            'availability' => $this->availability,
            'observations' => $this->observations
        ]); 

        $this->resetUI();
        $this->emit('item-updated', 'Perfil Actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];
    
    public function Destroy(Profile $prof)
    {   
        $prof->delete();

        $this->resetUI();
        $this->emit('item-deleted', 'Perfil Eliminado');
    }
    public function resetUI()
    {
        $this->selected_id = 0;
        $this->account_id = '';
        $this->pin = '';
        $this->status = 'Elegir';
        $this->availability = 'Elegir';
        $this->observations = '';

        $this->resetValidation();
    }
}

