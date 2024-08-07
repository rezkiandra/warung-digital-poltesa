<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
  use HasFactory;

	protected $table = 'product_categories';

  protected $fillable = [
    'name',
    'slug',
  ];

	public function product()
	{
		return $this->hasMany(Products::class, 'category_id');
	}
}
