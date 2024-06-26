<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteButton extends Component
{
  public $label, $class;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($label = '', $class = '')
  {
    $this->label = $label;
    $this->class = $class;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.delete-button');
  }
}
