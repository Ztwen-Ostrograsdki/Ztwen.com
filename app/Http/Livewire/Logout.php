<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout extends Component
{
    public function render()
    {
        return view('livewire.logout');
    }

    public $email;
    public $password;
    protected $rules = [
        'email' => 'required|email|between:5,255',
        'password' => 'required|string',
    ];


    public function logout()
    {

        Auth::guard('web')->logout();
        $this->emit("newUserConnected");
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('Logout');
        Session::flush();
        return redirect()->route('login');
    }

    public function cancel()
    {
        session()->flash('message', 'Deconnexion annulée');
        session()->flash('type', 'success');
        $this->dispatchBrowserEvent('hide-form');
        Session::flush();
    }

}
