<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CompaniesController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $name, $adress, $phone, $nit_id, $selected_id;
    public  $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empresas';
        $this->selected_id = 0;
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $company = Company::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $company = Company::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.company.component', [
            'data' => $company,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'name' => 'required|unique:companies',

        ];
        $messages = [
            'name.required' => 'El nombre de la empresa es requerido.',
            'name.unique' => 'Ya existe una empresa con ese nombre.',
        ];
        $this->validate($rules, $messages);

        Company::create([
            'name' => $this->name,
            'adress' => $this->adress,
            'phone' => $this->phone,
            'nit_id' => $this->nit_id
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Empresa Registrada');
    }
    public function Edit(Company $company)
    {
        $this->selected_id = $company->id;
        $this->name = $company->name;
        $this->adress = $company->adress;
        $this->phone = $company->phone;
        $this->nit_id = $company->nit_id;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'name' => "required|unique:companies,name,{$this->selected_id}",
            
        ];
        $messages = [
            'name.required' => 'El nombre de la empresa es requerido.',
            'name.unique' => 'Ya existe una empresa con ese nombre.',
            
        ];
        $this->validate($rules, $messages);
        $comp = Company::find($this->selected_id);
        $comp->update([
            'name' => $this->name,
            'adress' => $this->adress,
            'phone' => $this->phone,
            'nit_id' => $this->nit_id
        ]);
        $comp->save();

        $this->resetUI();
        $this->emit('item-updated', 'Empresa Actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Company $company)
    {
        $company->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Empresa Eliminada');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->adress = '';
        $this->phone = '';
        $this->nit_id = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
