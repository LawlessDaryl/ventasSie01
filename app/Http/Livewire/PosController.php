<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\Redirect;

class PosController extends Component
{
    public $total, $itemsQuantity, $efectivo, $change;



    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }
    public function render()
    {

        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name')
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];
    public function ScanCode($barcode, $cant = 1)
    {

        $product = Product::where('barcode', $barcode)->first();
        if ($product == null || empty($product)) {
            $this->emit('scan-notfound', 'El producto no esta registrado');
        } else {

            if ($this->inCart($product->id)) {
                $this->increaseQty($product->id);
                return;
            }
            if ($product->stock < 1) {
                $this->emit('no-stock', 'stock insuficiente :/');
                return;
            }
            Cart::add(
                $product->id,
                $product->name,
                $product->price,
                $cant,
                $product->image
            );
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Producto agregado');
        }
    }
    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if ($exist)
            return true;
        else
            return false;
    }


    public function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = "Producto agregado";
        }
        if ($exist) {
            if ($product->stock < ($cant + $exist->quantity)) {
                $this->emit('no-stock', 'stock insuficiente');
                return;
            }
        }
        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);
    }

    public function UpdateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist) {
            $title = "cantidad actualizada";
        } else {
            $title = "producto agregado";
        }
        if ($exist) {
            if ($product->stock < $cant) {
                $this->emit('no-stock', 'stock insuficiente :/');
                return;
            }
        }
        $this->removeItem($productId);
        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }

        
    }
    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
    }
    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);
        $product = Product::find($productId);

        $newQty = ($item->quantity) - 1;
        if ($newQty > 0) {
            Cart::add($item->id, $item->name, $item->price, $newQty, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Cantidad actualizada');
        }
        if($newQty==0 && Cart::getTotalQuantity()==0)
        {
            $this->total = 0;
            $this->change = 0;
        }
        $this->itemsQuantity = Cart::getTotalQuantity();

    }

    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito vacio');
    }

    public function saveSale()
    {

        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta');

            return;
        }
        if ($this->efectivo <= 0) {
            $this->emit('sale-error', 'Ingrese efectivo');

            return;
        }
        if ($this->total > $this->efectivo) {
            $this->emit('sale-error', 'El efectivo debe ser mayor o igual al total');

            return;
        }
        DB::beginTransaction();

        try {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,

                'user_id' => Auth()->user()->id
            ]);

            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('save-ok', 'venta registrada con exito');
            $this->emit('print-ticket', $sale->id);
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }
    public function printTicket($sale)
    {
        return Redirect::to('print://$sale->id');
    }
}
