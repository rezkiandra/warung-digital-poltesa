<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'level_name' => 'required|unique:levels,level_name',
		];
	}

	public function messages(): array
	{
		return [
			'level_name.required' => 'Level diperlukan',
			'level_name.unique' => 'Level sudah ada',
		];
	}

	public function attributes(): array
	{
		return [
			'level_name' => 'Level',
		];
	}
}
