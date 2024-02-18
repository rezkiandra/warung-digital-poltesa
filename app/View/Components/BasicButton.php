<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BasicButton extends Component
{
	public $label;
	public $type;
	public $icon;
	public $class;
	public $href;
	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($label, $type = '', $icon, $class = '', $href = '')
	{
		$this->label = $label;
		$this->type = $type;
		$this->icon = $icon;
		$this->class = $class;
		$this->href = $href;
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\Contracts\View\View|\Closure|string
	 */
	public function render()
	{
		return view('components.basic-button');
	}
}
