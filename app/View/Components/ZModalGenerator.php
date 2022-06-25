<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ZModalGenerator extends Component
{
    public $modalName;
    public $modalHeaderTitle = '';
    public $modalBodyTitle = '';
    public $bg_color = 'z-bg-secondary';
    public $header_color = 'text-white-50';
    public $icon = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalName, $modalHeaderTitle = '', $modalBodyTitle = '', $bg_color = 'z-bg-secondary', $header_color = 'text-white-50', $icon = '')
    {
        $this->modalName = $modalName;
        $this->modalHeaderTitle = $modalHeaderTitle;
        $this->modalBodyTitle = $modalBodyTitle;
        $this->bg_color = $bg_color;
        $this->header_color = $header_color;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.z-modal-generator');
    }
}
