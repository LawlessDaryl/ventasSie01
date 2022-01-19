<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CoinsController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $image, $selected_id, $type, $value;
    public  $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Monedas';
        $this->type = 'Elegir';
        $this->selected_id = 0;
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $coins = Denomination::where('type', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $coins = Denomination::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.denominations.component', [
            'data' => $coins,
            'categories' => Denomination::orderBy('type', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required'
        ];
        $messages = [
            'type.required' => 'Nombre de la moneda requerido',
            'type.not_in' => 'Elegir un tipo diferente de elegir',
            'value.required' => 'El valor de la moneda es requerido',            
        ];
        $this->validate($rules, $messages);
        $coin = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/monedas', $customFileName);
            $coin->image = $customFileName;
            $coin->save();
        }
        $this->resetUI();
        $this->emit('coin-added', 'Moneda Registrada');
    }
    public function Edit(Denomination $coin)
    {
        $this->selected_id = $coin->id;
        $this->type = $coin->type;
        $this->value = $coin->value;
        $this->image = null;

        $this->emit('modal-show', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required'
        ];
        $messages = [
            'type.required' => 'Nombre de la moneda requerido',
            'type.not_in' => 'Elegir un tipo diferente de elegir',
            'value.required' => 'El valor de la moneda es requerido',            
        ];
        $this->validate($rules, $messages);
        $coin = Denomination::find($this->selected_id);
        $coin->update([
            'type' => $this->type,
            'value' => $this->value
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/monedas', $customFileName);
            $imageTemp = $coin->image;
            $coin->image = $customFileName;
            $coin->save();

            if ($imageTemp != null) {
                if (file_exists('storage/monedas/' . $imageTemp)) {
                    unlink('storage/monedas/' . $imageTemp);
                }
            }
        }
        $this->resetUI();
        $this->emit('coin-added', 'Producto Registrado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Denomination $coin)
    {
        $imageTemp = $coin->image;
        $coin->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/monedas/' . $imageTemp)) {
                unlink('storage/monedas/' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('coin-deleted', 'Moneda Eliminado');
    }
    public function resetUI()
    {
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;

        $this->resetValidation();
    }
}
