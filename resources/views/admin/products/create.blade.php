@extends('layouts.authenticated')
@section('title', 'Add Product')
@section('content')
  <x-create-form :title="'Add new product'" :action="route('admin.store.product')" :route="route('admin.products')">
    <div class="row">
      <div class="col-lg-3">
        <x-form-floating>
          <x-input-form-label :label="'Product Name'" :name="'name'" :type="'text'" :placeholder="'Baju kemeja, Kue ulang tahun, dsb'" :value="old('name')" />
        </x-form-floating>
      </div>

      <div class="col-lg-3">
        <x-form-floating>
          <x-input-form-label :label="'Price'" :name="'price'" :type="'text'" :value="old('price')" />
        </x-form-floating>
      </div>

      <div class="col-lg-3">
        <x-form-floating>
          <x-input-form-label :label="'Stock'" :name="'stock'" :type="'text'" :value="old('stock')" />
        </x-form-floating>
      </div>

      <div class="col-lg-3">
        <x-form-floating>
          <x-input-form-label :label="'Seller'" :name="'seller_id'" :type="'select'" :options="$seller"
            :select="'Choose seller'" />
        </x-form-floating>
      </div>

      <div class="col-lg-4">
        <x-form-floating>
          <x-input-form-label :label="'Description'" :name="'description'" :type="'text'" :value="old('description')"
            :placeholder="'This product contain 1000mg vitamin c'" />
        </x-form-floating>
      </div>

      <div class="col-lg-4">
        <x-form-floating>
          <x-input-form-label :label="'Category'" :name="'category_id'" :type="'select'" :options="$categories"
            :select="'Choose categories'" />
        </x-form-floating>
      </div>

      <div class="col-lg-4">
        <x-form-floating>
          <x-input-form-label :label="'Image'" :name="'image'" :type="'file'" />
        </x-form-floating>
      </div>
    </div>

    <x-submit-button :label="'Submit'" :type="'submit'" :variant="'primary'" :icon="'check-circle-outline'" />
  </x-create-form>
@endsection
