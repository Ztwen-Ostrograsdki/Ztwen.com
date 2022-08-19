<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ZModalDismisser extends Component
{
    public $targetModal= null;
    public $classes = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classes = '', $targetModal = null)
    {
        $this->classes = $classes;
        $this->targetModal = $targetModal; 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.z-modal-dismisser');
    }
}
