<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ZInput extends Component
{
    public $placeholder;
    public $modelName;
    public $inputId;
    public $labelTitle = '';
    public $hasLabel = true;
    public $type = 'text';
    public $error = null;
    public $width = 'w-100';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modelName, $labelTitle = '', $type = 'text', $hasLabel = true, $error = null, $width = 'w-100')
    {
        $this->modelName = $modelName;
        $this->labelTitle = $labelTitle;
        $this->type = $type;
        $this->hasLabel = $hasLabel;
        $this->error = $error;
        $this->width = $width;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.z-input');
    }
}
