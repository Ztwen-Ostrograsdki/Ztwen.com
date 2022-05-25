<?php

namespace App\Http\Livewire;

use Livewire\Component;


class Footer extends Component
{
    public $localLang;

    public function mount()
    {
        if(session()->has('localLang')){
            $this->localLang = session('localLang');
            app()->setLocale($this->localLang);
        }
        else{
            $this->localLang = app()->getLocale();
        }
    }
    public function render()
    {
        return view('livewire.footer');
    }

    public function changeLocalLang()
    {
        session()->put('localLang', $this->localLang);
        app()->setLocale($this->localLang);
    }
}
