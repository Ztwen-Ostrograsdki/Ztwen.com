<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ZSelectInput extends Component
{
    public $options  = [];
    public $modelName = '';
    public $errors = null;
    public $hasLabel = false;
    public $labelTitle = '';
    public $title = '';
    public $parentClasses = 'my-1';
    public $inputClasses = 'text-white z-bg-secondary w-100';
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $options = [], 
        $modelName = '', 
        $errors = null, 
        $hasLabel = false, 
        $labelTitle = '', 
        $title = '', 
        $parentClasses = 'my-1', 
        $inputClasses = 'text-white z-bg-secondary w-100'
        )
    {
        $this->options = $options;
        $this->modelName = $modelName;
        $this->errors = $errors;
        $this->hasLabel = $hasLabel;
        $this->labelTitle = $labelTitle;
        $this->title = $title;
        $this->parentClasses = $parentClasses;
        $this->inputClasses = $inputClasses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.z-select-input');
    }
}
