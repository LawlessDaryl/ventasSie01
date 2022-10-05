<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Shift;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendancesImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public $col, $entrada, $salida, $empleado, $empleadoAll;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    //
    public function collection(Collection $rows)
    {
        
        
        $importfecha=$rows->first();
       // dd(substr($importfecha['tiempo'],5,2));
       
        //dd($rows);
        //validar fechas repetidas
        $valifecha=Attendance::select('attendances.*')
        ->whereMonth('fecha', substr($importfecha['tiempo'],5,2))->first();
        
        if($valifecha != null)
        {
            return redirect('/')->with('importe-rechazado', 'Malo!');
        }
        
        
        


        //separamos entra y salida en otros collection  
        $this->empleado=collect([]);
        $this->entrada=collect([]);
        $this->salida=collect([]);
        $e=0;
        $s=0;
        //dd($rows);
        //nuevo registro donde si tengo una entrada busco si tiene una salida y si no marco no tiene salida
        //si no tiene una entrar y solo salida la dejo como no tiene entrada
        //si tengo una persona que tiene 2 entradas y salidas por dia guardarlas juntosa
        foreach ($rows as $row){
            
            if($row['estado_de_trabajo'] == "Entrada" )
            {
                
                //agregamos los datos
                $this->entrada->push(['id_entrada'=> $e,'id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => substr($row['tiempo'],0,10), 'entrada' =>substr( $row['tiempo'], 11, 9), 'salida' => 'no marco salida']);
                $e++;   
            }

            
            if($row['estado_de_trabajo']=="Salida")
            {
                $this->salida->push(['id_salida'=> $s,'id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => substr($row['tiempo'],0,10), 'entrada' => 'no marco entrada', 'salida' =>substr( $row['tiempo'], 11, 9)]);
                $s++;
            }
        }
        //dd($this->entrada);
        //dd($this->salida);
        $s=0;
        //agrupar las entradas con las salidas de las misma fecha y eliminarlas
        foreach ($this->entrada as $row){
            $result=$this->salida->where('id',$row['id'])->where('fecha',$row['fecha'])->first();
            //dd($result);
            if($result)
            {
                $shora=$result['salida'];
                $this->empleado->push(['id_salida'=> $s,'id' => $row['id'], 'name' => $row['name'], 'fecha' => $row['fecha'], 'entrada' => $row['entrada'], 'salida' => $shora]);
                $s++;
                //removemos las salidas utilizadas
                $this->salida->pull($result['id_salida']);
                //probar
                //$this->entrada->pull($result['id_salida']);
                //dd($this->empleado);
               
            }else{
                $shora='no marco salida';
                $this->empleado->push(['id_salida'=> $s,'id' => $row['id'], 'name' => $row['name'], 'fecha' => $row['fecha'], 'entrada' => $row['entrada'], 'salida' => $shora]);
                $s++;
                //dd($this->empleado);
            }
            
        }
        //dd($this->empleado);
        //dd($this->salida);

        $this->uniqueE=$this->empleado->merge($this->salida);
        //dd($this->uniqueE);
        //sacar valores duplicados
        $this->empleadoAll = $this->uniqueE->unique(function ($item) {
            $jc;

            /*$jc=Shift::join('employees as e', 'e.id', 'shifts.employee_id')
            ->select('shifts.name', 'e.name')
            ->where('shifts.employee_id', $item['id'] && 'shifts.name', 'jornada completa')
            ->first();*/
            
            //if($item['name']=='Yazmin')
            //si el usuario es del turno completo o jornada completa por definir aun

            if(($item['entrada']>'08:00:00' && $item['salida']<'12:50:00')){
                
                return $item['id'].$item['fecha'].$item['entrada'];
            }
            return $item['id'].$item['fecha'];
        });
        $this->empleadoAll->values()->all();
        //dd($this->empleadoAll);
        //dd($this->empleadoAll);
       /* $uniqueS= $this->salida->unique(function ($item){
            return $item['id'].$item['fecha'];
        });
        
        $uniqueE->values()->all();
        $uniqueS->values()->all(); */
        //dump($uniqueE);
        //dump($this->salida);
        //dd($uniqueS);
        //dump($this->empleado);
        //$this->empleadoAll=$uniqueE->merge($uniqueS);
        //dd($this->empleadoAll);
        

        //agregar a la base de datos
        
        //dd($this->empleadoAll);
        
        foreach ($this->empleadoAll as $row) 
        {
            //dd($row);
            Attendance::create([
                'fecha' =>$row['fecha'],
                'entrada' =>$row['entrada'],
                'salida' =>$row['salida'],
                'employee_id' =>$row['id'],
            ]);
            //dd($row);
        }
    }
    public function dupli($rows){
        return ;
    }
   /* public function model(array $row)
    {
        //dd($row);
        $this->col=collect([]);
        $this->col->push(['id' => $row['id_de_usuario'], 'name' => $row['nombre'], 'fecha' => $row['tiempo'], 'estado' => $row['estado_de_trabajo']]);
        
        
        //$this->col->push(['product_id'=> $id->id,'product-name'=>$id->nombre,'costo'=>$this->costo,'cantidad'=>$this->cantidad]);
        
        
        //dd($this->col);
        return $this->col;
        // return new Attendance([
        // //agregar atributos
        //     'id' =>$row['id'],
        //     'fecha' =>$row['fecha'],
        //     'entrada' =>$row['entrada'],
        //     'salida' =>$row['salida'],
        //     'employee_id' =>$row['idempleado'],
        // ]);
        //dd($row);
    }*/
    public function batchSize(): int
    {
        return 5000;
    }
    public function chunkSize(): int
    {
        return 5000;
    }
}
