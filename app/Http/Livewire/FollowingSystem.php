<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Events\NewFollowerEvent;
use Illuminate\Support\Facades\Auth;

class FollowingSystem extends Component
{

    protected $listeners = ['onUpdateUsersList_L_Event' => 'onUpdateUsersList'];
    public $counter = 0;

    
    public function render()
    {
        $users = [];
        if(Auth::user()){
            $users = User::all()->except([Auth::user()->id]);
        }
        return view('livewire.following-system', compact('users'));
    }


    public function onUpdateUsersList()
    {
        $this->reset('counter');
    }


    public function followThisUser($user_id)
    {
        $auth = auth()->user()->id;
        $user = User::find($user_id);
        if(!$user || !$auth){
            return abort(403, "Vous n'êtes pas authorisé");
        }
        if(User::find($auth)->__followThisUser($user->id)){
            $this->emit('IsendNewFriendRequest_L_Event');
            $event = new NewFollowerEvent($user, 'added');
            broadcast($event);
        }
        else{
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'warning', 'message' => "Vous ne pouvez pas effectuer cette requête"]);
        }
        
    }
}
