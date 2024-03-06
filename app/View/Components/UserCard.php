<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserCard extends Component
{
  public $datas, $label, $icon, $variant, $description, $condition, $percentage;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($datas, $label, $icon, $variant, $description = 'Last week analytics', $condition, $percentage = '')
  {
    $this->datas = $datas;
    $this->label = $label;
    $this->icon = $icon;
    $this->variant = $variant;
    $this->description = $description;
    $this->condition = $condition;
    $this->percentage = $percentage;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.user.user-card');
  }
}
