<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdvancedRequestsModal extends Component
{
    public $classMapping;
    public $user;
    public $authenticated;
    public $key;
    public $adv_code;

    protected $listeners = ['startAdvancedRequests'];

    public function render()
    {
        return view('livewire.advanced-requests-modal');
    }


    public function targetedModel($classMapping)
    {
        $this->classMapping = $classMapping;
    }

    public function startAdvancedRequests($classMapping)
    {
        $this->targetedModel($classMapping);
        $this->dispatchBrowserEvent('modal-startAdvancedRequests');
    }


    public function start($forced = false)
    {

    }
}
