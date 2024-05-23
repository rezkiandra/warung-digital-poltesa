<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Products;
use App\Models\Wishlist;
use Illuminate\Support\Str;
use App\Models\ProductsCart;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\BiodataRequest;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\UpdateBiodataRequest;

class CustomerController extends Controller
{
  public function index()
  {
    $foodProducts = Products::where('category_id', 1)->get();
    $fashionProducts = Products::where('category_id', 2)->get();
    $parfumeProducts = Products::where('category_id', 3)->get();
    return view('customer.home', compact('fashionProducts', 'parfumeProducts', 'foodProducts'));
  }

  public function dashboard()
  {
    if (auth()->user()->customer) {
      $bulanJan = date('01');
      $bulanFeb = date('02');
      $bulanMar = date('03');
      $bulanApr = date('04');
      $bulanMei = date('05');
      $bulanJun = date('06');
      $bulanJul = date('07');
      $bulanAgu = date('08');
      $bulanSep = date('09');
      $bulanOkt = date('10');
      $bulanNov = date('11');
      $bulanDes = date('12');

      $tahun = Carbon::now()->year;
      $data = [
        'labels'  => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        'data'    => [
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanJan)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanFeb)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanMar)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanApr)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanMei)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanJun)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanJul)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanAgu)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanSep)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanOkt)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanNov)->sum('total_price'),
          Order::where('customer_id', auth()->user()->customer->id)->where('status', 'paid')->whereYear('created_at', $tahun)->whereMonth('created_at', $bulanDes)->sum('total_price'),
        ],
      ];

      $orders = Order::with('product')->where('customer_id', Auth::user()->customer->id)->orderBy('created_at', 'desc')->paginate(6) ?? collect([]);
      return view('customer.dashboard', compact('orders', 'data'));
    } else {
      $orders = collect([]);
      return view('customer.anonymous', compact('orders'));
    }
  }

  public function products()
  {
    $products = Products::orderBy('category_id', 'asc')->get();
    return view('customer.products', compact('products'));
  }

  public function faq()
  {
    return view('customer.faq');
  }

  public function product(string $slug)
  {
    $product = Products::where('slug', $slug)->firstOrFail();
    return view('pages.detail-product', compact('product'));
  }

  public function biodata()
  {
    $customer = Customer::where('user_id', Auth::user()->id)->get();
    return view('customer.biodata', compact('customer'));
  }

  public function cart()
  {
    if (Auth::user()->customer) {
      $carts = ProductsCart::where('customer_id', Auth::user()->customer->id)->get();
    } else {
      $carts = collect([]);
    }
    return view('customer.cart', compact('carts'));
  }

  public function wishlist()
  {
    if (Auth::user()->customer) {
      $wishlists = Wishlist::where('customer_id', Auth::user()->customer->id)->get();
    } else {
      $wishlists = collect([]);
    }
    return view('customer.wishlist', compact('wishlists'));
  }

  public function orders()
  {
    if (Auth::user()->customer) {
      $orders = Order::with('product')->where('customer_id', Auth::user()->customer->id)->orderBy('created_at', 'desc')->paginate(8);
    } else {
      $orders = collect([]);
    }
    return view('customer.orders', compact('orders'));
  }

  public function settings()
  {
    return view('customer.settings');
  }

  public function updateProfile(UserRequest $request, string $uuid)
  {
    $userCustomer = User::where('uuid', $uuid)->firstOrFail();

    $userCustomer->update([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->new_password) ?? $userCustomer->password,
    ]);

    Alert::toast('Berhasil update profile', 'success');
    return redirect()->back();
  }

  public function store(BiodataRequest $request)
  {
    Customer::create([
      'uuid' => Str::uuid('id'),
      'user_id' => Auth::user()->id,
      'full_name' => $request->full_name,
      'slug' => Str::slug($request->full_name),
      'address' => $request->address,
      'phone_number' => $request->phone_number,
      'gender' => $request->gender,
      'image' => $request->image->store('customers', 'public'),
    ]);

    Alert::toast('Berhasil menambahkan biodata', 'success');
    return redirect()->route('customer.biodata');
  }

  public function update(UpdateBiodataRequest $request, string $uuid)
  {
    $customer = Customer::where('uuid', $uuid)->firstOrFail();
    $customerImage = Customer::where('uuid', $uuid)->pluck('image')->first();

    if ($request->hasFile('image')) {
      if ($customerImage) {
        Storage::delete('public/' . $customerImage);
      }
      $customer->update([
        'image' => $request->image->store('customers', 'public'),
      ]);
    } else {
      $customer->update([
        'full_name' => $request->full_name,
        'slug' => Str::slug($request->full_name),
        'address' => $request->address,
        'phone_number' => $request->phone_number,
        'gender' => $request->gender,
        'status' => $customer->status,
      ]);
    }

    Alert::toast('Berhasil mengupdate biodata', 'success');
    return redirect()->route('customer.biodata');
  }
}
