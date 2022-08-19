<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ZGaleryManagerComponent extends Component
{
    public $modalName;
    public $theModel;
    public $modalHeaderTitle = '';
    public $modelName;
    public $inputId;
    public $labelTitle = '';
    public $submitMethodName;
    public $error = null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($modalName, $submitMethodName, $modalHeaderTitle = '',$labelTitle = "L'image à télécharger ...", $theModel, $modelName, $error = false)
    {
        $this->modalName = $modalName;
        $this->modalHeaderTitle = $modalHeaderTitle;
        $this->theModel = $theModel;
        $this->error = $error;
        $this->labelTitle = $labelTitle;
        $this->modelName = $modelName;
        $this->submitMethodName = $submitMethodName;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.z-galery-manager-component');
    }
}
