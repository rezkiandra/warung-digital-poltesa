@extends('layouts.authenticated')

@section('title', 'Product Categories')

@section('content')
  <x-basic-button :label="'Add new category'" :icon="'plus'" :class="'w-0 text-uppercase mb-4'" :variant="'primary'" :href="route('admin.create.category')" />
  <x-category-table :title="'List of categories'" :fields="['No', 'Category Name', 'Created at', 'Updated at', 'Actions']" :datas="$category" />
@endsection
