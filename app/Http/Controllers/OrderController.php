<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Products;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
  public function store(Request $request)
  {
    Order::create([
      'uuid' => Str::uuid('id'),
      'customer_id' => Auth::user()->customer->id,
      'product_id' => $request->product_id,
      'quantity' => $request->quantity,
      'total_price' => $request->total_price,
    ]);

    $product = Products::find($request->product_id);
    $product->decrement('stock', $request->quantity);
    $product->update();

    Alert::toast('Successfully maked an order', 'success');
    return redirect()->route('customer.orders');
  }
}
