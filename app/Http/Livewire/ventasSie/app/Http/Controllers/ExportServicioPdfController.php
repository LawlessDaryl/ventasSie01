<?php

namespace App\Http\Controllers;

use App\Models\OrderService;
use App\Models\Service;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExportServicioPdfController extends Controller
{
    public function reporteServPDF($userId, $estado, $sucursal,$reportType, $dateFrom = null, $dateTo = null)
    {
        $data = [];
        $sumaUtilidad = 0;
        $costoEntregado = 0;

        if ($reportType == 0) //ventas del dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d')     . ' 23:59:59';
        }

        if($sucursal == 0){
            if ($estado == 'Todos') {
                if ($userId == 0) {
                    /* $data=Service::orderBy('id','desc')->get(); */
                    $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')
                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();
    
                    foreach ($data as $serv) {
                        foreach ($serv->movservices as $mm) {
                            if ($mm->movs->status == 'ACTIVO') {
                                $serv->utilidad = $mm->movs->import - $serv->costo;
                                $sumaUtilidad += $serv->utilidad;
                            }
                        }
                    }
    
                } else {
    
                    if ($estado == "Todos") {
                        $costoEntregado = 0;
                        $data = [];
                        $data1 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
    
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.type', 'ENTREGADO')
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
    
    
                        foreach ($data1 as $dat) {
                            foreach ($dat->movservices as $dato) {
                                if ($dato->movs->type == 'TERMINADO' && $dato->movs->user_id == $userId) {
                                    $costoEntregado += $dat->costo;
                                    array_push($data, $dat);
                                    /* break; */
                                }
                            }
                        }
                        
                        $datos2 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.user_id', $userId)
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
    
                        foreach ($datos2 as $dat1) {
                            $validar = 1;
                            foreach ($data as $dat2) {
                                if ($dat2->id == $dat1->id) {
                                    $validar = 0;
                                }
                            }
                            if ($validar == 1) {
                                $costoEntregado += $dat1->costo;
                                array_push($data, $dat1);
                            }
                        }
    
                        foreach ($data as $serv) {
                            foreach ($serv->movservices as $mm) {
                                if ($mm->movs->status == 'ACTIVO') {
                                    $serv->utilidad = $mm->movs->import - $serv->costo;
                                    $sumaUtilidad += $serv->utilidad;
                                }
                            }
                        }
                        
                    } else {
    
                        $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.user_id', $userId)
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
    
                        foreach ($data as $serv) {
                            foreach ($serv->movservices as $mm) {
                                if ($mm->movs->status == 'ACTIVO') {
                                    $serv->utilidad = $mm->movs->import - $serv->costo;
                                    $sumaUtilidad += $serv->utilidad;
                                }
                            }
                        }
                    }
                }
            } else {
                if ($userId == 0) {
                    $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')
                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->where('mov.type', $estado)
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();
                    foreach ($data as $serv) {
                        foreach ($serv->movservices as $mm) {
                            if ($mm->movs->status == 'ACTIVO') {
                                $serv->utilidad = $mm->movs->import - $serv->costo;
                                $sumaUtilidad += $serv->utilidad;
                            }
                        }
                    }
                } else {
    
                    if ($estado == "ENTREGADO") {
                        $costoEntregado = 0;
                        $data = [];
                        $data1 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
    
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.type', $estado)
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
    
    
                        foreach ($data1 as $dat) {
                            foreach ($dat->movservices as $dato) {
                                if ($dato->movs->type == 'TERMINADO' && $dato->movs->user_id == $userId) {
                                    $costoEntregado += $dat->costo;
                                    array_push($data, $dat);
                                    /* break; */
                                }
                            }
                        }
    
                        foreach ($data as $serv) {
                            foreach ($serv->movservices as $mm) {
                                if ($mm->movs->status == 'ACTIVO') {
                                    $serv->utilidad = $mm->movs->import - $serv->costo;
                                    $sumaUtilidad += $serv->utilidad;
                                }
                            }
                        }
                    } else {
    
                        $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.user_id', $userId)
                            ->where('mov.type', $estado)
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
                        foreach ($data as $serv) {
                            foreach ($serv->movservices as $mm) {
                                if ($mm->movs->status == 'ACTIVO') {
                                    $serv->utilidad = $mm->movs->import - $serv->costo;
                                    $sumaUtilidad += $serv->utilidad;
                                }
                            }
                        }
                    }
                }
            }
        }else{
            if ($estado == 'Todos') {
                if ($userId == 0) {
                    $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')
                        ->where('services.sucursal_id',$sucursal)
                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();
    
                    foreach ($data as $serv) {
                        foreach ($serv->movservices as $mm) {
                            if ($mm->movs->status == 'ACTIVO') {
                                $serv->utilidad = $mm->movs->import - $serv->costo;
                                $sumaUtilidad += $serv->utilidad;
                            }
                        }
                    }
    
                } else {
    
                    if ($estado == "Todos") {
                        $costoEntregado = 0;
                        $data = [];
                        $data1 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
                            ->where('services.sucursal_id',$sucursal)
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.type', 'ENTREGADO')
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
    
    
                        foreach ($data1 as $dat) {
                            foreach ($dat->movservices as $dato) {
                                if ($dato->movs->type == 'TERMINADO' && $dato->movs->user_id == $userId) {
                                    $costoEntregado += $dat->costo;
                                    array_push($data, $dat);
                                }
                            }
                        }
                        
                        $datos2 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
                            ->where('services.sucursal_id',$sucursal)
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.user_id', $userId)
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
    
                        foreach ($datos2 as $dat1) {
                            $validar = 1;
                            foreach ($data as $dat2) {
                                if ($dat2->id == $dat1->id) {
                                    $validar = 0;
                                }
                            }
                            if ($validar == 1) {
                                $costoEntregado += $dat1->costo;
                                array_push($data, $dat1);
                            }
                        }
    
                        foreach ($data as $serv) {
                            foreach ($serv->movservices as $mm) {
                                if ($mm->movs->status == 'ACTIVO') {
                                    $serv->utilidad = $mm->movs->import - $serv->costo;
                                    $sumaUtilidad += $serv->utilidad;
                                }
                            }
                        }
                        
                    } else {
    
                        $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
                            ->where('services.sucursal_id',$sucursal)
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.user_id', $userId)
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
    
                        foreach ($data as $serv) {
                            foreach ($serv->movservices as $mm) {
                                if ($mm->movs->status == 'ACTIVO') {
                                    $serv->utilidad = $mm->movs->import - $serv->costo;
                                    $sumaUtilidad += $serv->utilidad;
                                }
                            }
                        }
                    }
                }
            } else {
                if ($userId == 0) {
                    $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')
                        ->where('services.sucursal_id',$sucursal)
                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->where('mov.type', $estado)
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();
                    foreach ($data as $serv) {
                        foreach ($serv->movservices as $mm) {
                            if ($mm->movs->status == 'ACTIVO') {
                                $serv->utilidad = $mm->movs->import - $serv->costo;
                                $sumaUtilidad += $serv->utilidad;
                            }
                        }
                    }
                } else {
    
                    if ($estado == "ENTREGADO") {
                        $costoEntregado = 0;
                        $data = [];
                        $data1 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
                            ->where('services.sucursal_id',$sucursal)
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.type', $estado)
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
    
    
                        foreach ($data1 as $dat) {
                            foreach ($dat->movservices as $dato) {
                                if ($dato->movs->type == 'TERMINADO' && $dato->movs->user_id == $userId) {
                                    $costoEntregado += $dat->costo;
                                    array_push($data, $dat);
                                }
                            }
                        }
    
                        foreach ($data as $serv) {
                            foreach ($serv->movservices as $mm) {
                                if ($mm->movs->status == 'ACTIVO') {
                                    $serv->utilidad = $mm->movs->import - $serv->costo;
                                    $sumaUtilidad += $serv->utilidad;
                                }
                            }
                        }
                    } else {
    
                        $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                            ->join('users as u', 'u.id', 'mov.user_id')
                            ->where('mov.status', 'like', 'ACTIVO')
                            ->where('services.sucursal_id',$sucursal)
                            ->select(
                                'services.*',
                                DB::raw('0 as utilidad')
                            )
                            ->whereBetween('mov.created_at', [$from, $to])
                            ->where('mov.user_id', $userId)
                            ->where('mov.type', $estado)
                            ->orderBy('services.id', 'desc')
                            ->distinct()
                            ->get();
                        foreach ($data as $serv) {
                            foreach ($serv->movservices as $mm) {
                                if ($mm->movs->status == 'ACTIVO') {
                                    $serv->utilidad = $mm->movs->import - $serv->costo;
                                    $sumaUtilidad += $serv->utilidad;
                                }
                            }
                        }
                    }
                }
            }
        }
        

        /* if ($estado == 'Todos') {
            if ($userId == 0) {
                $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->where('mov.status', 'like', 'ACTIVO')
                    ->select(
                        'services.*',
                        DB::raw('0 as utilidad')
                    )
                    ->whereBetween('mov.created_at', [$from, $to])
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();

                foreach ($data as $serv) {
                    foreach ($serv->movservices as $mm) {
                        if ($mm->movs->status == 'ACTIVO') {
                            $serv->utilidad = $mm->movs->import - $serv->costo;
                            $sumaUtilidad += $serv->utilidad;
                        }
                    }
                }

            } else {

                if ($estado == "Todos") {
                    $costoEntregado = 0;
                    $data = [];
                    $data1 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')

                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->where('mov.type', 'ENTREGADO')
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();


                    foreach ($data1 as $dat) {
                        foreach ($dat->movservices as $dato) {
                            if ($dato->movs->type == 'TERMINADO' && $dato->movs->user_id == $userId) {
                                $costoEntregado += $dat->costo;
                                array_push($data, $dat);
                            }
                        }
                    }
                    
                    $datos2 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')
                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->where('mov.user_id', $userId)
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();

                    foreach ($datos2 as $dat1) {
                        $validar = 1;
                        foreach ($data as $dat2) {
                            if ($dat2->id == $dat1->id) {
                                $validar = 0;
                            }
                        }
                        if ($validar == 1) {
                            $costoEntregado += $dat1->costo;
                            array_push($data, $dat1);
                        }
                    }

                    foreach ($data as $serv) {
                        foreach ($serv->movservices as $mm) {
                            if ($mm->movs->status == 'ACTIVO') {
                                $serv->utilidad = $mm->movs->import - $serv->costo;
                                $sumaUtilidad += $serv->utilidad;
                            }
                        }
                    }
                    
                } else {

                    $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')
                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->where('mov.user_id', $userId)
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();

                    foreach ($data as $serv) {
                        foreach ($serv->movservices as $mm) {
                            if ($mm->movs->status == 'ACTIVO') {
                                $serv->utilidad = $mm->movs->import - $serv->costo;
                                $sumaUtilidad += $serv->utilidad;
                            }
                        }
                    }
                }
            }
        } else {
            if ($userId == 0) {
                $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                    ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                    ->join('users as u', 'u.id', 'mov.user_id')
                    ->where('mov.status', 'like', 'ACTIVO')
                    ->select(
                        'services.*',
                        DB::raw('0 as utilidad')
                    )
                    ->whereBetween('mov.created_at', [$from, $to])
                    ->where('mov.type', $estado)
                    ->orderBy('services.id', 'desc')
                    ->distinct()
                    ->get();
                foreach ($data as $serv) {
                    foreach ($serv->movservices as $mm) {
                        if ($mm->movs->status == 'ACTIVO') {
                            $serv->utilidad = $mm->movs->import - $serv->costo;
                            $sumaUtilidad += $serv->utilidad;
                        }
                    }
                }
            } else {

                if ($estado == "ENTREGADO") {
                    $costoEntregado = 0;
                    $data = [];
                    $data1 = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')

                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->where('mov.type', $estado)
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();


                    foreach ($data1 as $dat) {
                        foreach ($dat->movservices as $dato) {
                            if ($dato->movs->type == 'TERMINADO' && $dato->movs->user_id == $userId) {
                                $costoEntregado += $dat->costo;
                                array_push($data, $dat);
                            }
                        }
                    }

                    foreach ($data as $serv) {
                        foreach ($serv->movservices as $mm) {
                            if ($mm->movs->status == 'ACTIVO') {
                                $serv->utilidad = $mm->movs->import - $serv->costo;
                                $sumaUtilidad += $serv->utilidad;
                            }
                        }
                    }
                } else {

                    $data = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                        ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                        ->join('users as u', 'u.id', 'mov.user_id')
                        ->where('mov.status', 'like', 'ACTIVO')
                        ->select(
                            'services.*',
                            DB::raw('0 as utilidad')
                        )
                        ->whereBetween('mov.created_at', [$from, $to])
                        ->where('mov.user_id', $userId)
                        ->where('mov.type', $estado)
                        ->orderBy('services.id', 'desc')
                        ->distinct()
                        ->get();
                    foreach ($data as $serv) {
                        foreach ($serv->movservices as $mm) {
                            if ($mm->movs->status == 'ACTIVO') {
                                $serv->utilidad = $mm->movs->import - $serv->costo;
                                $sumaUtilidad += $serv->utilidad;
                            }
                        }
                    }
                }
            }
        } */


        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        $pdf = PDF::loadView('livewire.pdf.reporteServicios', compact('data', 'reportType', 'user','estado', 'dateFrom', 'dateTo', 'sumaUtilidad','costoEntregado','userId'));

        return $pdf->setPaper('letter', 'landscape')->stream('ServiciosReport.pdf');  //visualizar
        /* return $pdf->download('salesReport.pdf');  //descargar  */
    }
}
