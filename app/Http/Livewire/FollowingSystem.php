<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowingSystem extends Component
{

    public $users;
    protected $listeners = ['updateRequests'];

    
    public function render()
    {
        return view('livewire.following-system');
    }


    public function getUsers()
    {
        if(Auth::user()){
            $this->users = User::all()->except([Auth::user()->id]);
        }
        else{
            // $this->users = User::all()->except([1]);
        }
    }

    public function booted()
    {
        $this->getUsers();
    }

    public function updateRequests()
    {
        $this->booted();
    }


    public function followThisUser($user_id)
    {
        $auth = auth()->user()->id;
        $user = User::find($user_id);
        if(!$user || !$auth){
            return abort(403, "Vous n'êtes pas authorisé");
        }
        if(User::find($auth)->__followThisUser($user->id)){
            $this->emit('updateRequests');
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'warning', 'message' => "Vous ne pouvez pas effectuer cette requête"]);
        }
        
    }
}
