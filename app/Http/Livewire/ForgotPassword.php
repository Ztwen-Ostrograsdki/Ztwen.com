<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ForgotPassword extends Component
{

    public $user;
    public $email = '';
    protected $rules = [
        'email' => 'required|email|between:5,255',
    ];

    public function render()
    {
        return view('livewire.forgot-password');
    }

    public function submit()
    {
        
    }


}
