@php
  $user = \App\Models\User::where('role_id', '2')->pluck('name', 'id')->toArray();
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

@section('title', 'Edit Seller')

@section('content')
  <div class="d-lg-flex justify-content-between gap-4">
    <div class="col-lg-2 card-body">
      <img src="{{ asset('storage/' . $seller->image) }}" alt="" class="img-fluid rounded" width="100%">
    </div>

    <x-edit-form :title="'Edit specific seller'" :action="route('admin.update.seller', $seller->uuid)" :route="route('admin.sellers')" :class="'col-lg-10'">
      <div class="row">
        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Seller Name'" :name="'full_name'" :type="'text'" :value="$seller->full_name" />
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Address'" :name="'address'" :type="'text'" :value="$seller->address" />
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Phone'" :name="'phone_number'" :type="'text'" :value="$seller->phone_number" />
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <select name="gender" id="gender" class="form-select text-capitalize">
              <option value="{{ $seller->gender }}">{{ $seller->gender }}</option>
              @foreach ($gender as $key => $value)
                @if ($key == $seller->gender)
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
              <option value="{{ $seller->user_id }}" selected>{{ $seller->user->name }}</option>
              @foreach ($user as $key => $value)
                @if ($key == $seller->user_id)
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
              <option value="{{ $seller->bank_account_id }}" selected>
                {{ \App\Models\Seller::join('bank_accounts', 'bank_accounts.id', '=', 'sellers.bank_account_id', 'left')->where('sellers.id', $seller->id)->first()->bank_name }}
              </option>
              @foreach ($bank as $key => $value)
                @if ($key == $seller->bank_account_id)
                  @continue
                @endif
                <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Image'" :name="'image'" :type="'file'" :value="$seller->image" />
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <select name="status" id="status" class="form-select text-capitalize">
              <option value="{{ $seller->status }}" selected>{{ $seller->status }}</option>
              @foreach ($status as $key => $value)
                @if ($key == $seller->status)
                  @continue
                @endif
                <option value="{{ $key }}">{{ $value }}</option>
              @endforeach
            </select>
          </x-form-floating>
        </div>

        <div class="col-lg-4">
          <x-form-floating>
            <x-input-form-label :label="'Account Number'" :name="'account_number'" :type="'text'" :value="$seller->account_number, old('account_number')" />
          </x-form-floating>
        </div>
      </div>

      <x-submit-button :label="'Submit'" :type="'submit'" :variant="'primary'" :icon="'check-circle-outline'" />
    </x-edit-form>
  </div>
@endsection
