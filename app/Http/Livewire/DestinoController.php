<?php

namespace App\Http\Livewire;

use App\Models\Destino;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DestinoController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $pageTitle, $componentName;
    private $pagination = 5;

public $nombre,$sucursal,$observacion,$selected_id;
    
public function paginationView()
{
    return 'vendor.livewire.bootstrap';
}
public function mount()
{
    $this->pageTitle = 'Listado';
    $this->componentName = 'Estancias';
    $this->selected_id = 0;
}


    public function render()
    {
<<<<<<< HEAD

        $destino= Destino::join('sucursals as suc','suc.id','destinos.sucursal_id')
        ->select('destinos.*','suc.name')->orderBy('suc.name','desc')->paginate($this->pagination);

       
        return view('livewire.destino.destino-controller',['datas'=>$destino,'data_suc'=>Sucursal::all()])
=======
        if($this->selected_id !== null && $this->selected_ubicacion !== null )

            $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product-id')
                                        ->join('locations as loc','loc.id','productos_destinos.destino-id')
                                        ->join('sucursals as suc','suc.id','loc.sucursal_id')
                                        ->select('productos_destinos.*','loc.*','p.nombre as name','loc.ubicacion as ubi','suc.name as suc_id','loc.codigo as codigo')
                                        ->where('loc.ubicacion',$this->selected_ubicacion)
                                        ->where('suc.name',$this->selected_id)
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);
        else

            if($this->selected_id == 'General')
            {
                $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product-id')
                                            ->join('locations as loc','loc.id','productos_destinos.destino-id')
                                            ->join('sucursals as suc','suc.id','loc.sucursal_id')
                                            ->select(DB::raw('sum(product-id)'),'productos_destinos.*','loc.*','p.nombre as name','loc.ubicacion as ubi','suc.name as suc_id','loc.codigo as codigo')
                                            ->groupBy('productos_destinos.product-id')
                                          
                                            ->paginate($this->pagination);

            }
                 $almacen= ProductosDestino::join('products as p','p.id','productos_destinos.product-id')
                                        ->join('locations as loc','loc.id','productos_destinos.destino-id')
                                        ->join('sucursals as suc','suc.id','loc.sucursal_id')
                                        ->select('productos_destinos.*','loc.*','p.nombre as name','loc.ubicacion as ubi','suc.name as suc_id','loc.codigo as codigo')
                                        ->where('loc.ubicacion','ALMACEN')
                                        ->where('suc.id',1)
                                        ->orderBy('p.nombre','desc')
                                        ->paginate($this->pagination);

      
        /*$products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                ->orderBy('products.id', 'desc')
                ->paginate($this->pagination);
        */
            $suc_data=Sucursal::select('sucursals.*')
                                    ->orderBy('sucursals.id','asc');

                                    

        return view('livewire.destino.destino-controller',['destinos_almacen'=>$almacen,'data_suc' => $suc_data->get()])  
>>>>>>> c4564dec6882f117ac73a1d26fd2897b6f21f006
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required|unique:unidads',
            'sucursal' => 'required'
            
        ];
        $messages = [
            'nombre.required' => 'El nombre de la unidad es requerido.',
            'nombre.unique' => 'Ya existe una unidad con ese nombre.',
            'sucursal.required' => 'La sucursal es requerida'
        ];
        $this->validate($rules, $messages);

        Destino::create([
            'nombre' => $this->nombre,
            'observacion'=>$this->observacion,
            'sucursal_id'=>$this->sucursal
        ]);

        $this->resetUI();
        $this->emit('unidad-added', 'Estancia Registrada');
    }
    public function Edit(Destino $unity)
    {
        $this->selected_id = $unity->id;
        $this->nombre = $unity->nombre;
        $this->observacion = $unity->observacion;
        $this->sucursal = $unity->sucursal_id;
        
       

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre' => 'required|unique:unidads',
            'sucursal' => 'required'
        ];
        $messages = [
            'nombre.required' => 'El nombre de la unidad es requerido.',
            'nombre.unique' => 'Ya existe una unidad con ese nombre.',
            'sucursal.required' => 'La sucursal es requerida'
        
        ];
        $this->validate($rules, $messages);
        $uni = Destino::find($this->selected_id);
        $uni->update([
            'nombre' => $this->nombre,
            'observacion'=>$this->observacion,
            'sucursal_id'=>$this->sucursal
            
        ]);
        $uni->save();

        $this->resetUI();
        $this->emit('unidad-updated', 'Estancia Actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Destino $uni)
    {
        $uni->delete();
        $this->resetUI();
        $this->emit('unidad-deleted', 'Estancia Eliminada');
    }

    public function resetUI()
    {
        $this->nombre = '';
        $this->selected_id = 0;
        $this->observacion = '';
        $this->sucursal = '';
       
    }


}
