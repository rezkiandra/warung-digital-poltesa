<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'user_id' => 'required|unique:customers,full_name',
      'full_name' => 'required|unique:customers,id|max:30',
      'address' => 'required',
      'phone_number' => 'required|numeric|regex:/^\d{8,13}$/|min:8',
      'gender' => 'required',
      'image' => 'required_if:image,null|mimes:png,jpg,jpeg',
      'status' => 'required:status,null|in:active,inactive,pending',
    ];
  }

  public function messages(): array
  {
    return [
      'user_id.required' => 'Harap pilih user',
      'user_id.unique' => 'User sudah menjadi customer',

      'full_name.required' => 'Nama customer diperlukan',
      'full_name.unique' => 'Nama customer sudah ada',
      'full_name.max' => 'Nama customer maksimal 30 karakter',

      'address.required' => 'Alamat diperlukan',

      'phone_number.required' => 'Nomor handphone diperlukan',
      'phone_number.numeric' => 'Nomor handphone dalam bentuk angka',
      'phone_number.regex' => 'Nomor handphone tidak valid',
      'phone_number.max' => 'Nomor handphone maksimal 20 karakter',

      'gender.required' => 'Harap pilih gender',

      'image.required_if' => 'Gambar diperlukan',
      'image.mimes' => 'Gambar dalam format jpg, png, jpeg',
      // 'image.size' => 'Gambar maksimal 2 MB',

      'status.required' => 'Status diperlukan',
      'status.in' => 'Status tidak valid',
    ];
  }

  public function attributes(): array
  {
    return [
      'full_name' => 'Nama customer',
      'address' => 'Alamat',
      'phone_number' => 'Nomor handphone',
      'gender' => 'Gender',
      'image' => 'Gambar',
      'status' => 'Status',
    ];
  }
}
