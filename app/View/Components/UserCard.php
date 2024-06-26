<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserCard extends Component
{
  public $datas, $label, $icon, $variant, $description, $condition;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($datas, $label, $icon, $variant, $description = 'Total', $condition)
  {
    $this->datas = $datas;
    $this->label = $label;
    $this->icon = $icon;
    $this->variant = $variant;
    $this->description = $description;
    $this->condition = $condition;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.user-card');
  }
}
