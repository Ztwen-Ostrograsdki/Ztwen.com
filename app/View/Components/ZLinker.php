<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ZLinker extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $routeName;
    public $isActive;
    public $params;

    public function __construct($routeName, $isActive = false, $params = null)
    {
        $this->routeName = $routeName;
        $this->isActive = $isActive;
        $this->params = $params;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.z-linker');
    }
}
