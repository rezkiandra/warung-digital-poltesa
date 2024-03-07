@php
  $user = \App\Models\User::where('role_id', '3')->pluck('name', 'id')->toArray();
  $gender = [
      'male' => 'male',
      'female' => 'female',
  ];
  $status = [
      'active' => 'active',
      'inactive' => 'inactive',
      'pending' => 'pending',
  ];
  $bank = \App\Models\BankAccount::pluck('bank_name', 'id')->toArray();
@endphp

@extends('layouts.authenticated')

@section('title', 'Edit Customer')

@section('content')
  <div class="d-lg-flex justify-content-between gap-4">
    <div class="col-lg-2 card-body">
      <img src="{{ asset('storage/' . $customer->image) }}" alt="" class="img-fluid rounded" width="100%">
    </div>

    <x-edit-form :title="'Edit specific customer'" :action="route('admin.update.customer', $customer->uuid)" :route="route('admin.customers')" :class="'col-lg-10'">
      <div class="row">
        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Customer Name'" :name="'full_name'" :type="'text'" :value="$customer->full_name" />
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Address'" :name="'address'" :type="'text'" :value="$customer->address" />
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Phone'" :name="'phone_number'" :type="'text'" :value="$customer->phone_number" />
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <select name="gender" id="gender" class="form-select text-capitalize">
              <option value="{{ $customer->gender }}">{{ $customer->gender }}</option>
              @foreach ($gender as $key => $value)
                @if ($key == $customer->gender)
                  @continue
                @endif
                <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <select name="user_id" id="user_id" class="form-select">
              <option value="{{ $customer->user_id }}" selected>{{ $customer->user->name }}</option>
              @foreach ($user as $key => $value)
                @if ($key == $customer->user_id)
                  @continue
                @endif
                <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <select name="bank_account_id" id="bank_account_id" class="form-select">
              <option value="{{ $customer->bank_account_id }}" selected>
                {{ \App\Models\Customer::join('bank_accounts', 'bank_accounts.id', '=', 'customers.bank_account_id', 'left')->where('customers.id', $customer->id)->first()->bank_name }}
              </option>
              @foreach ($bank as $key => $value)
                @if ($key == $customer->bank_account_id)
                  @continue
                @endif
                <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Image'" :name="'image'" :type="'file'" :value="$customer->image" />
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <select name="status" id="status" class="form-select text-capitalize">
              <option value="{{ $customer->status }}" selected>{{ $customer->status }}</option>
              @foreach ($status as $key => $value)
                @if ($key == $customer->status)
                  @continue
                @endif
                <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Account Number'" :name="'account_number'" :type="'text'" :value="$customer->account_number, old('account_number')" />
          </x-form-floating>
        </div>
      </div>

      <x-submit-button :label="'Submit'" :type="'submit'" :variant="'primary'" :icon="'check-circle-outline'" />
    </x-edit-form>
  </div>
@endsection
