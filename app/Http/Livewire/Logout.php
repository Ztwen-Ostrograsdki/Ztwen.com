<?php

namespace App\Http\Livewire;

use App\Models\UserOnlineSession;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
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
        Session::forget('user-' . Auth::user()->id);
        Auth::guard('web')->logout();
        $this->emit("newUserConnected");
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('Logout');
        return redirect(RouteServiceProvider::HOME);
    }

    public function cancel()
    {
        session()->flash('message', 'Deconnexion annulée');
        session()->flash('type', 'success');
        $this->dispatchBrowserEvent('hide-form');
        Session::flush();
    }

}
