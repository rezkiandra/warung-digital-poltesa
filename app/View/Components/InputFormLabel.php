<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputFormLabel extends Component
{
  public $label;
  public $name;
  public $type;
  public $placeholder;
  public $value;
  public $options;
  public $select;
  public $attributes;
  public $height;
  /**
   * Create a new component instance.
   */
  public function __construct($label, $name = '', $type, $placeholder = "", $value = '', $options = '', $select = '', $attributes = '', $height = '150px')
  {
    $this->label = $label;
    $this->name = $name;
    $this->type = $type;
    $this->placeholder = $placeholder;
    $this->value = $value;
    $this->options = $options;
    $this->select = $select;
    $this->attributes = $attributes;
    $this->height = $height;
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render()
  {
    return view('components.input-form-label');
  }
}
