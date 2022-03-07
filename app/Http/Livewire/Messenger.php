<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Messenger extends Component
{
    
    protected $listeners = ['newUserAdded', 'refreshUsersList', 'chatReceiver', 'newUserConnected'];
    public $user;
    public $users;
    public $receiver;
    public $role;

    public function render()
    {
        $this->getUsers();
        return view('livewire.messenger');
    }


    public function newUserAdded($user)
    {
        $this->user = $user;
    }

    public function refreshUsersList()
    {
        return $this->getUsers();
    }
    
    public function newUserConnected()
    {
        return $this->getUsers();
    }


    public function getUsers()
    {
        return $this->users = User::all()->except([Auth::user()->id]);
    }

    public function chatReceiver($receiver)
    {
        $this->receiver = $receiver;
        $this->emit('chatReceiver', $this->receiver);
    }

}
