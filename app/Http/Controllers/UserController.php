<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraDetalle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
   
    
    public function index(Request $request)
    {
        return $request->user();
    }



}
