<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProcessModal extends Component
{
    protected $listeners = ['displayProcessModalEvent'];

    public $process = 0;

    public function render()
    {
        return view('livewire.process-modal');
    }


    public function displayProcessModalEvent()
    {
        $this->dispatchBrowserEvent('modal-displayProcessModal');
    }

}
