<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductsController extends Controller
{
	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('admin.products.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(ProductsRequest $request)
	{
		Products::create([
			'name' => $request->name,
			'slug' => Str::slug($request->name),
			'description' => $request->description,
			'price' => $request->price,
			'stock' => $request->stock,
			'category_id' => $request->category_id,
			'image' => $request->image->store('products', 'public'),
		]);

		Alert::toast('Successfully created new product', 'success');
		return redirect()->route('admin.products');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $slug)
	{
		$product = Products::where('slug', $slug)->firstOrFail();
		return view('admin.products.detail', compact('product'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $slug)
	{
		$product = Products::where('slug', $slug)->firstOrFail();
		return view('admin.products.edit', compact('product'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(ProductsRequest $request, string $slug)
	{
		$product = Products::where('slug', $slug)->firstOrFail();
		$product->update([
			'name' => $request->name,
			'slug' => Str::slug($request->name),
			'description' => $request->description,
			'price' => $request->price,
			'stock' => $request->stock,
			'category_id' => $request->category_id,
			'image' => $request->image ? $request->image->store('products', 'public') : $product->image,
		]);

		Alert::toast('Successfully updated product', 'success');
		return redirect()->route('admin.products');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $slug)
	{
		$product = Products::where('slug', $slug)->firstOrFail();
		$product->delete();

		if ($product->image) {
			Storage::delete('public/' . $product->image);
		}

		Alert::toast('Successfully deleted product', 'success');
		return redirect()->route('admin.products');
	}
}
