<?php

namespace App\Http\Livewire;

use App\Models\Email;
use Exception;
use Illuminate\Support\Facades\DB;
use LengthException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Nette\Utils\Random;

class EmailsController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $content, $pass, $availability, $status, $observations,
        $selected_id, $pageTitle, $componentName, $nombre, $dominio, $search,
        $longitud, $letras, $letras0, $numeros, $simbolos, $checkN, $checkS;
    private $pagination = 6;

    public function mount()
    {
        $this->pass = '';
        $this->checkN = false;
        $this->checkS = false;
        $this->name = 'emanuel';
        $this->dominio = '@gmail.com';
        $this->availability = 'LIBRE';
        $this->status = 'ACTIVO';
        $this->pageTitle = 'Listado';
        $this->componentName = 'Correos';
        $this->letras = 'abcdefghijklmnopqrstuvwxyz';
        $this->letras0 = 'abcdefghijklmnopqrstuvwxyz';
        $this->numeros = '1234567890';
        $this->simbolos = '.';
        $this->longitud = 6;
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Email::where('content', 'like', '%' . $this->search . '%')
                ->orWhere('availability', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhere('observations', 'like', '%' . $this->search . '%')
                ->paginate($this->pagination);
        else
            $data = Email::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.emails.component', ['emails' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }

    //método que genera el key para el nombre del correo
    function Email()
    {
        $key = "";

        $this->letras = $this->letras0;

        if ($this->checkN == true && $this->checkS == true) {

            $this->letras = $this->letras . $this->numeros . $this->simbolos;
        } else {
            if ($this->checkN == true) {
                $this->letras .= $this->numeros;
            } else if ($this->checkS == true) {
                $this->letras .= $this->simbolos;
            }
        }

        $max = strlen($this->letras) - 1;
        for ($i = 0; $i < $this->longitud; $i++) {
            $key .= substr($this->letras, mt_rand(0, $max), 1);
        }

        $this->content = $this->GenerarCorreo($key);

        $this->emit('pass-generated', 'Email generado exitosamente');
    }

    //metodo que genera el password
    function Pass()
    {
        $key = "";

        $this->letras = $this->letras0;

        if ($this->checkN == true && $this->checkS == true) {

            $this->letras = $this->letras . $this->numeros . $this->simbolos;
        } else {
            if ($this->checkN == true) {
                $this->letras .= $this->numeros;
            } else if ($this->checkS == true) {
                $this->letras .= $this->simbolos;
            }
        }

        $max = strlen($this->letras) - 1;
        for ($i = 0; $i < $this->longitud; $i++) {
            $key .= substr($this->letras, mt_rand(0, $max), 1);
        }

        $this->pass = $this->GenerarPass($key);

        $this->emit('pass-generated', 'Contraseña generada exitosamente');
    }

    //Metodo que une el el nombre inicial del email + el key generado + @gmail.com
    public function GenerarCorreo($k)
    {
        $temp = $this->name . $k;
        $temp .= $this->dominio;
        return $temp;
    }

    public function GenerarPass($k)
    {
        $temp = $k . $this->name;
        return $temp;
    }

    public function Edit(Email $mail)
    {
        $this->selected_id = $mail->id;
        $this->content = $mail->content;
        $this->pass = $mail->pass;
        $this->availability = $mail->availability;
        $this->status = $mail->status;
        $this->observations = $mail->observations;

        $this->emit('show-modal', 'open!');
    }

    public function Store()
    {
        $rules = [
            'content' => "required|min:11|unique:emails",
            'pass' => "unique:emails",
            'status' => 'required',
            'availability' => 'required'
        ];

        $messages = [
            'content.required' => 'Ingresa el nombre del correo',
            'content.min' => 'El nombre del correo debe tener al menos 11 caracteres',
            'content.unique' => 'El nombre del correo ya se encuentra registrado',            
            'pass.unique' => 'Esta contraseña ya se encuentra registrada',
            'status.required' => 'Selecciona el estado del correo',
            'availability.required' => 'Selecciona la disponibilidad del correo',
        ];

        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {
            Email::create([
                'content' => $this->content,
                'pass' => $this->pass,
                'availability' => $this->availability,
                'status' => $this->status,
                'observations' => $this->observations,
            ]);

            DB::commit();
            $this->resetUI();
            $this->emit('item-added', 'Correo Registrado con Éxito');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'No se pudo crear el correo ' . $e->getMessage());
        }
    }


    public function Update()
    {
        $rules = [
            'content' => "required|min:11|unique:emails,content,{$this->selected_id}",
            'pass' => "unique:emails,pass,{$this->selected_id}",
            'status' => 'required',
            'availability' => 'required'
        ];

        $messages = [
            'content.required' => 'Ingresa el nombre del correo',
            'content.min' => 'El nombre del correo debe tener al menos 11 caracteres',
            'content.unique' => 'El nombre del correo ya se encuentra registrado',
            'pass.unique' => 'Esta contraseña ya se encuentra registrada',
            'status.required' => 'Selecciona el estado del correo',
            'availability.required' => 'Selecciona la disponibilidad del correo',
        ];

        $this->validate($rules, $messages);

        $mail = Email::find($this->selected_id);
        DB::beginTransaction();
        try {
            $mail->update([
                'content' => $this->content,
                'pass' => $this->pass,
                'availability' => $this->availability,
                'status' => $this->status,
                'observations' => $this->observations
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'No se pudo actualizar el correo ' . $e->getMessage());
        }

        $this->resetUI();
        $this->emit('item-updated', 'Correo Actualizado Exitosamente');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Email $mail)
    {
        $mail->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Correo eliminado');
    }

    public function resetUI()
    {
        $this->content = '';
        $this->pass = '';
        $this->availability = 'LIBRE';
        $this->status = 'ACTIVO';
        $this->observations = '';
        $this->longitud = 6;
        $this->selected_id = 0;
        $this->checkN = false;
        $this->checkS = false;
        $this->resetValidation();
    }
}
