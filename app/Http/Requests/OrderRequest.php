<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'order_type' => 'required|in:jasa kirim,ambil sendiri',
      'courier' => 'required_if:order_type,jasa kirim|in:jne,Maxim'
    ];
  }

  public function messages(): array
  {
    return [
      'order_type.required' => 'Pilih tipe pesanan terlebih dahulu',
      'order_type.in' => 'Pilih tipe pesanan yang tersedia',

      'courier.required_if' => 'Pilih kurir terlebih dahulu',
      'courier.in' => 'Pilih kurir yang tersedia',
    ];
  }

  public function attributes(): array
  {
    return [
      'order_type' => 'Tipe Pesanan',
      'courier' => 'Kurir',
    ];
  }
}
