<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\AdminUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EditSellerRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\EditCustomerRequest;

class UserController extends Controller
{
  public function createSeller()
  {
    return view('admin.sellers.create');
  }

  public function storeSeller(SellerRequest $request)
  {
    Seller::create([
      'uuid' => Str::uuid('id'),
      'user_id' => $request->user_id,
      'full_name' => $request->full_name,
      'slug' => Str::slug($request->full_name),
      'address' => $request->address,
      'phone_number' => $request->phone_number,
      'gender' => $request->gender,
      'bank_account_id' => $request->bank_account_id,
      'image' => $request->image->store('sellers', 'public'),
      'account_number' => $request->account_number,
      'status' => $request->status,
    ]);

    Alert::toast('Berhasil menambahkan penjual', 'success');
    session()->flash('action', 'store');
    return redirect()->route('admin.sellers');
  }

  public function showSeller(string $slug)
  {
    $seller = Seller::where('slug', $slug)->firstOrFail();
    return view('admin.sellers.detail', compact('seller'));
  }

  public function editSeller(string $uuid)
  {
    $seller = Seller::where('uuid', $uuid)->firstOrFail();
    return view('admin.sellers.edit', compact('seller'));
  }

  public function updateSeller(EditSellerRequest $request, string $uuid)
  {
    $seller = Seller::where('uuid', $uuid)->firstOrFail();
    $sellerImage = Seller::where('uuid', $uuid)->pluck('image')->first();

    if ($request->hasFile('image')) {
      if ($sellerImage) {
        Storage::delete('public/' . $sellerImage);
      }
      $seller->update([
        'image' => $request->image->store('sellers', 'public'),
      ]);
    } else {
      $seller->update([
        'user_id' => $seller->user_id,
        'full_name' => $request->full_name,
        'slug' => Str::slug($request->full_name),
        'address' => $request->address,
        'phone_number' => $request->phone_number,
        'gender' => $request->gender,
        'bank_account_id' => $request->bank_account_id,
        'account_number' => $request->account_number,
        'status' => $request->status,
      ]);
    }

    Alert::toast('Berhasil mengupdate biodata penjual', 'success');
    return redirect()->route('admin.sellers');
  }

  public function destroySeller(string $uuid)
  {
    $seller = Seller::where('uuid', $uuid)->firstOrFail();
    $seller->delete();

    if ($seller->image) {
      Storage::delete('public/' . $seller->image);
    }

    Alert::toast('Berhasil menghapus penjual', 'success');
    session()->flash('action', 'delete');
    return redirect()->route('admin.sellers');
  }

  public function createCustomer()
  {
    return view('admin.customers.create');
  }

  public function storeCustomer(CustomerRequest $request)
  {
    Customer::create([
      'uuid' => Str::uuid('id'),
      'user_id' => $request->user_id,
      'full_name' => $request->full_name,
      'slug' => Str::slug($request->full_name),
      'address' => $request->address,
      'phone_number' => $request->phone_number,
      'gender' => $request->gender,
      'image' => $request->image->store('customers', 'public'),
      'status' => $request->status,
    ]);

    Alert::toast('Berhasil menambahkan pelanggan', 'success');
    session()->flash('action', 'store');
    return redirect()->route('admin.customers');
  }

  public function showCustomer(string $slug)
  {
    $customer = Customer::where('slug', $slug)->firstOrFail();
    return view('admin.customers.detail', compact('customer'));
  }

  public function editCustomer(string $uuid)
  {
    $customer = Customer::where('uuid', $uuid)->firstOrFail();
    return view('admin.customers.edit', compact('customer'));
  }

  public function updateCustomer(EditCustomerRequest $request, string $uuid)
  {
    $customer = Customer::where('uuid', $uuid)->firstOrFail();
    $customerImage = Customer::where('uuid', $uuid)->pluck('image')->first();

    if ($request->hasFile('image')) {
      if ($customerImage) {
        Storage::delete('public/' . $customerImage);
      }
      $customer->update([
        'image' => $request->image->store('customer', 'public'),
      ]);
    } else {
      $customer->update([
        'user_id' => $customer->user_id,
        'full_name' => $request->full_name,
        'slug' => Str::slug($request->full_name),
        'address' => $request->address,
        'phone_number' => $request->phone_number,
        'gender' => $request->gender,
        'status' => $request->status,
      ]);
    }

    Alert::toast('Berhasil mengupdate biodata pelanggan', 'success');
    return redirect()->route('admin.customers');
  }

  public function destroyCustomer(string $uuid)
  {
    $customer = Customer::where('uuid', $uuid)->firstOrFail();
    $customer->delete();

    if ($customer->image) {
      Storage::delete('public/' . $customer->image);
    }

    Alert::toast('Berhasil menghapus pelanggan', 'success');
    session()->flash('action', 'delete');
    return redirect()->route('admin.customers');
  }

  public function createUser()
  {
    return view('admin.users.create');
  }

  public function storeUser(AdminUserRequest $request)
  {
    User::create([
      'uuid' => Str::uuid('id'),
      'name' => $request->name,
      'slug' => Str::slug($request->name),
      'email' => $request->email,
      'role_id' => $request->role_id,
      'password' => Hash::make($request->password),
    ]);

    Alert::toast('Berhasil menambahkan pengguna', 'success');
    session()->flash('action', 'store');
    return redirect()->route('admin.users');
  }

  public function showUser(string $slug)
  {
    $user = User::where('slug', $slug)->firstOrFail();
    return view('admin.users.detail', compact('user'));
  }

  public function editUser(string $uuid)
  {
    $user = User::where('uuid', $uuid)->firstOrFail();
    $isDisabled = true;
    return view('admin.users.edit', compact('user', 'isDisabled'));
  }

  public function updateUser(UserRequest $request, string $uuid)
  {
    $user = User::where('uuid', $uuid)->firstOrFail();
    $user->update([
      'uuid' => Str::uuid('id'),
      'name' => $request->name,
      'slug' => Str::slug($request->name),
      'email' => $request->email,
      'role_id' => $request->role_id ?? $user->role_id,
      'password' => Hash::make($request->new_password) ?? $user->password,
    ]);

    Alert::toast('Berhasil mengupdate pengguna', 'success');
    return redirect()->route('admin.users');
  }

  public function destroyUser(string $uuid)
  {
    $user = User::where('uuid', $uuid)->firstOrFail();
    $user->delete();

    Alert::toast('Berhasil menghapus pengguna', 'success');
    session()->flash('action', 'delete');
    return redirect()->route('admin.users');
  }
}
